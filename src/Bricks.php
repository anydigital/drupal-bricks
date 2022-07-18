<?php

namespace Drupal\bricks;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Render\Element;

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
    // The keys in are the same field items/$root_object as in $parent_items,
    // the values are keys in the $new_elements array or self::ROOT.
    $parent_keys = new \SplObjectStorage();
    $parent_keys[$root_object] = self::ROOT;
    $key = 0;
    foreach ($render_elements as $render_element) {
      // At this point, the element contains a 'content' key containing a render
      // array to view an entity and an empty attributes object. Remove this
      // layer and keep only content.
      $content = $render_element['content'] ?? [];
      // The field item is needed because it stores the bricks specific
      // options. Because of
      // https://www.drupal.org/project/drupal/issues/3108189 it is not
      // possible to correlate $render_elements to $items, it needs to be found
      // in the current render element.
      $field_item = static::fieldItem($content);
      // Sanity check.
      if (!$field_item) {
        continue;
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
      $depth = (int) $item->getDepth();
      $parent_items[$item] = $parent_for_depth[$depth];
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

}
