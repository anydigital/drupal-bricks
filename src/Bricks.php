<?php

namespace Drupal\bricks;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\TypedData\TranslatableInterface;

/**
 * Helper class.
 */
class Bricks {

  /**
   * Tree root key. The real tree elements have integer keys so this is unique.
   */
  const ROOT = 'root';

  /**
   * @param $render_elements
   *   The rendered elements.
   * @param $all_items
   *   The field items. $render_elements only contains the rendered version of
   *   the currently visible items.
   *
   * @return array
   *   A tree of render elements. Each element contains its brick children
   *   under the bricks_children key.
   */
  public static function nestItems($render_elements, $all_items): array {
    // See static::newElement() for the elements in $new_elements.
    $new_elements = static::newElements($render_elements, $all_items);
    $layout_exists = \Drupal::service('module_handler')->moduleExists('layout_discovery');
    $keys_to_keep = array_flip([
      '#label',
      '#attributes',
      '#paragraph',
      '#parent_paragraph',
    ]);

    // By processing the elements from the bottom, by the time the parent is
    // reached, all the children are moved under it.
    foreach (array_reverse(array_keys($new_elements)) as $key) {
      // Save the parent key because moving into a layout loses it.
      $parent_key = $new_elements[$key]['#bricks_parent_key'];

      // If this is a layout paragraph, move the children of it into a layout.
      if (!empty($new_elements[$key]['#layout']) && $layout_exists) {
        $keep = array_intersect_key($new_elements[$key], $keys_to_keep);
        $new_elements[$key] = $keep + self::layoutFromItems($new_elements[$key]['#layout'], $new_elements[$key]['bricks_children']);
      }

      // If this is not a top level element, move it under the parent.
      if ($parent_key !== self::ROOT) {
        if (isset($new_elements[$parent_key]['#paragraph'])) {
          $new_elements[$key]['#parent_paragraph'] = $new_elements[$parent_key]['#paragraph'];
        }
        array_unshift($new_elements[$parent_key]['bricks_children'], $new_elements[$key]);
        unset($new_elements[$key]);
      }
    }

    return $new_elements;
  }

  /**
   * @param $render_elements
   *   The render elements.
   * @param FieldItemListInterface $items
   *   The bricks field items.
   *
   * @return array
   *   A new list of render elements. Children of access denied elements are
   *   removed, the rest is enriched with bricks specific information as seen
   *   in self::newElement().
   */
  protected static function newElements(array $render_elements, FieldItemListInterface $items): array {
    // \SplObjectStorage only allows objects as keys.
    $root_object = new class { };
    $parent_items = self::parentItems($items, $root_object);
    // The field item is needed because it stores bricks specific options.
    // While EntityReferenceFormatterBase::getEntitiesToView() indexes
    // by delta, FormatterBase::view() has
    // $elements = array_merge($info, $elements); which loses this and changes
    // $elements into a list as defined by array_is_list(). Also,
    // https://www.drupal.org/project/drupal/issues/3489179
    // makes _referringItem unreliable if the same entity is referred twice. So
    // this code needs to guess. It has two guessing mechanisms: one is
    // collecting the items referring an allowed entity into a list, borrowing
    // the access check logic from
    // EntityReferenceFormatterBase::getEntitiesToView(). If no elements are
    // added or removed in various hooks then this will work (unless an alter
    // hook replaces an element, no way to detect that). If some are added or
    // removed then fall back to using _referringItem. Note, however this is
    // also guesswork because there's no API helper to get the rendered entity
    // back from a render element.
    $allowed_items = self::getAllowedItems($items);
    $fallback = (!array_is_list($render_elements) || count($allowed_items) !== count($render_elements));
    // The keys in are the same field items/$root_object as in $parent_items,
    // the values are keys in the $new_elements array or self::ROOT.
    $parent_keys = new \SplObjectStorage();
    $parent_keys[$root_object] = self::ROOT;
    $key = 0;
    foreach ($render_elements as $render_key => $render_element) {
      // At this point, the element contains a 'content' key containing a render
      // array to view an entity and an empty attributes object. Remove this
      // layer and keep only content.
      $content = $render_element['content'] ?? [];
      $field_item = $fallback ? static::fieldItem($content) : $allowed_items[$render_key];
      if (empty($parent_items[$field_item])) {
        throw new \UnexpectedValueException(sprintf('Bricks field %s has been altered in unholy ways', $items->getName()));
      }
      $parent_item = $parent_items[$field_item];
      // Only keep elements whose parent is in the new tree. If it is not then
      // the parent was access denied.
      if (isset($parent_keys[$parent_item])) {
        $new_elements[$key] = static::newElement($content, $field_item, $parent_keys[$parent_item]);
        $parent_keys[$field_item] = $key;
        $key++;
      }
    }
    return $new_elements ?? [];
  }

  /**
   * Find the parent item for each bricks item.
   *
   * This needs to be done with the field items instead of the rendered items
   * to avoid problems with access denied elements. See comments in
   * ::newElements() for more.
   *
   * @param FieldItemListInterface $items
   *   The bricks field items.
   * @param object $root_object
   *   An object representing the tree root.
   *
   * @return \SplObjectStorage
   *   keys are field items, values are the parent item or $root_object.
   */
  protected static function parentItems(FieldItemListInterface $items, object $root_object): \SplObjectStorage {
    $parent_items = new \SplObjectStorage();
    $parent_for_depth[0] = $root_object;
    foreach ($items as $item) {
      $depth = $item->getDepth();
      if (!isset($depth)) {
        $depth = 0;
        if (!$items->getEntity()->isNew()) {
          drupal_register_shutdown_function([$items->getEntity(), 'save']);
        }
      }
      $parent_items[$item] = $parent_for_depth[$depth];
      // Thanks to ::correctDepths() we know the children are exactly 1 deeper.
      $parent_for_depth[$depth + 1] = $item;
    }
    return $parent_items;
  }

  /**
   * @param $content
   *   A render array to view an entity.
   *
   * @return
   *   The bricks field item this content was rendered from.
   */
  protected static function fieldItem(array $content): ?BricksFieldItemInterface {
    $entity = NULL;
    // The default is the same #theme and entity type id, see
    // EntityViewBuilder::getBuildDefaults().
    if ($theme = ($content['#theme'] ?? '')) {
      $entity = $content["#$theme"] ?? NULL;
    }
    if (!$entity) {
      // If that didn't work out, try to fish for it among the properties. If
      // there is only one entity sure it is the one. If there is more than one,
      // give up.
      foreach (Element::properties($content) as $property) {
        if ($content[$property] instanceof EntityInterface) {
          if ($entity) {
            throw new \LogicException(sprintf('Unsupported render array with entity types %s %s', $entity->getEntityTypeId(), $content[$property]->getEntityTypeId()));
          }
          $entity = $content[$property];
        }
      }
    }
    return $entity ? $entity->_referringItem : NULL;
  }

  /**
   * Create a new elelemnt.
   *
   * @param $content
   * @param \Drupal\bricks\BricksFieldItemInterface $field_item
   * @param $parent_key
   *
   * @return array
   *   A render array to view an entity plus a few bricks specific extras:
   *   some CSS classes are added, the entity label s surfaced and
   *   importantly #bricks_parent_key points to the parent n the
   *   $new_elements array and #layout is extracted from the field item
   *   options.
   */
  public static function newElement($content, BricksFieldItemInterface $field_item, $parent_key): array {
    $element = $content;
    $entity = $field_item->entity;
    $element['#label'] = $entity->label();
    $element['#bricks_parent_key'] = $parent_key;
    $element['#attributes']['class'][] = 'brick';
    $element['#attributes']['class'][] = 'brick--type--' . Html::cleanCssIdentifier($entity->bundle());
    $element['#attributes']['class'][] = 'brick--id--' . $entity->id();

    $element['bricks_children'] = [];
    if ($view_mode = $field_item->getOption('view_mode')) {
      $element['#view_mode'] = $view_mode;
    }
    if ($layout = $field_item->getOption('layout')) {
      $element['#layout'] = $layout;
    }
    if ($css_class = $field_item->getOption('css_class')) {
      $element['#attributes']['class'][] = $css_class;
    }
    if ($css_id = $field_item->getOption('css_id')) {
      $element['#attributes']['id'][] = $css_id;
    }
    return $element;
  }

  protected static function layoutFromItems($layoutName, $items) {
    $layoutPluginManager = \Drupal::service('plugin.manager.core.layout');
    if (!$layoutPluginManager->hasDefinition($layoutName)) {
      \Drupal::messenger()->addWarning(t('Layout `%layout_id` is unknown.', ['%layout_id' => $layoutName]));
      return [];
    }

    // Provide any configuration to the layout plugin if necessary.
    $layoutInstance = $layoutPluginManager->createInstance($layoutName);
    $regionNames = $layoutInstance->getPluginDefinition()->getRegionNames();
    $defaultRegion = $layoutInstance->getPluginDefinition()->getDefaultRegion();

    $regions = [];

    // If there is just one region and is the default one, add all items inside
    // the default region.
    if (count($regionNames) == 1 && !empty($defaultRegion)) {
      $regions[$defaultRegion] = $items;
    }
    else {
      // Adjust the lengths.
      $count = min(count($regionNames), count($items));
      $regionNamesSlice = array_slice($regionNames, 0, $count);
      $items = array_slice($items, 0, $count);

      // Build the content for your regions.
      $regions = array_combine($regionNamesSlice, $items);
    }

    // This builds the render array.
    return $layoutInstance->build($regions);
  }

  /**
   * Renumber depths.
   *
   * The increment from one item to the next must be 1. The widget enforces
   * this and so clicking an item with the wrong depth will jump around,
   * confusing users. It is also a major hassle to do this runtime so rather
   * enforce a uniform structure save time.
   */
  public static function correctDepths(\Traversable $items): void {
    $root_object = new class {
      // Top level elements have a depth of 0 (but see below), the helper root
      // object must have a depth of -1.
      public function getDepth(): int {
        return -1;
      }
    };
    $parent_stack = new \SplStack();
    $parent_stack->push($root_object);
    $uncorrected_depths = new \SplObjectStorage();
    $uncorrected_depths[$root_object] = $root_object->getDepth();
    $expected_child_depth = fn () => $uncorrected_depths[$parent_stack->top()] + 1;
    // The tree starts with the root.
    $previous_item = $root_object;
    // Actual top level depth.
    $top_level_depth = NULL;
    /** @var \Drupal\bricks\BricksFieldItemInterface $item */
    foreach ($items as $item) {
      // One of the broken cases is a NULL depth which doesn't work with the
      // comparisons below.
      $item_depth = (int) $item->getDepth();
      if (!isset($top_level_depth)) {
        $top_level_depth = $item_depth;
      }
      $item_depth -= $top_level_depth;
      $uncorrected_depths[$item] = $item_depth;
      // |P1|  | |
      // |  |P2| |
      // |  |  |X| <= we are here. The current item is X, the parent stack top
      // currently is P1, the previous item is P2.
      if ($item_depth > $expected_child_depth()) {
        $parent_stack->push($previous_item);
      }
      // |P1|  | |
      // |  |P2| |
      // |  |  |X|
      // |Y |  | | <= we are here, remove P1, P2 and any other parents even
      // deeper.
      while ($item_depth < $expected_child_depth()) {
        $parent_stack->pop();
      }
      // The parent stack at this point contains the correct paths. The number
      // of them minus one for the root object is the correct depth.
      $item->setDepth($parent_stack->count() - 1);
      $previous_item = $item;
    }
  }

  /**
   * Collect items referring an allowed entity into a list.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *
   * @return array
   *   A list containing items referring an allowed entity.
   */
  public static function getAllowedItems(FieldItemListInterface $items): array {
    $allowed_items = [];
    $langcode = $items->getLangcode();
    foreach ($items as $item) {
      if (!empty($item->_loaded)) {
        $entity = $item->entity;
        if ($entity instanceof TranslatableInterface) {
          $entity = \Drupal::service('entity.repository')->getTranslationFromContext($entity, $langcode);
        }
        if ($entity->access('view')) {
          $allowed_items[] = $item;
        }
      }
    }
    return $allowed_items;
  }

}
