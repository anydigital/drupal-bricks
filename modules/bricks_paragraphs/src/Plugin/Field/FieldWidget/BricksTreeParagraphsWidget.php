<?php

namespace Drupal\bricks_paragraphs\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\paragraphs\Plugin\Field\FieldWidget\ParagraphsWidget;

/**
 * Bricks widget based on the stable paragraphs widget, for use with paragraphs.
 *
 * @FieldWidget(
 *   id = "bricks_tree_paragraphs",
 *   label = @Translation("Bricks tree (paragraphs)"),
 *   description = @Translation("Bricks widget based on the stable paragraphs widget."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   },
 *   multiple_values = false
 * )
 */
class BricksTreeParagraphsWidget extends ParagraphsWidget {

  /**
   * {@inheritdoc}
   */
  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $widget = parent::form($items, $form, $form_state, $get_delta);
    // This lets us pull in the widget CSS from paragraphs module.
    $widget['#attributes']['class'][] = 'field--widget-paragraphs';
    return $widget;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $widget_state = static::getWidgetState($element['#field_parents'], $this->fieldDefinition->getName(), $form_state);
    $entity = $widget_state['paragraphs'][$delta]['entity'];
    $item = $items[$delta];
    // ::duplicateSubmit sets up depth for duplicated entities. $item is an empty
    // item added in parent::formMultipleElements() with $items->appendItem().
    if ($entity?->isNew() && isset($widget_state['paragraphs'][$delta]['depth'])) {
      $item->depth = $widget_state['paragraphs'][$delta]['depth'];
    }
    _bricks_form_element_alter($element, $item, $entity);

    // Restore keyboard/screenreader accessibility for the depth field.
    $element['depth']['#type'] = 'textfield';
    $element['depth']['#size'] = 3;

    return $element;
  }

  public static function duplicateSubmit(array $form, FormStateInterface $form_state) {
    parent::duplicateSubmit($form, $form_state);
    // All this is copied from the parent.
    $button = $form_state->getTriggeringElement();
    $element = NestedArray::getValue($form, array_slice($button['#array_parents'], 0, -5));
    $field_name = $element['#field_name'];
    $parents = $element['#field_parents'];
    $widget_state = static::getWidgetState($parents, $field_name, $form_state);
    $delta = array_search($button['#delta'], $widget_state['original_deltas']);
    // The parent appended the duplicate paragraph to the end of the
    // paragraphs list in widget state. Copy the depth of the original.
    // This single line is the only specific piece of logic, everything else
    // is copied from the parent.
    $widget_state['paragraphs'][array_key_last($widget_state['paragraphs'])]['depth'] = $element[$delta]['depth']['#value'];
    static::setWidgetState($parents, $field_name, $form_state, $widget_state);
  }

  /**
   * {@inheritdoc}
   */
  public function formMultipleElements(FieldItemListInterface $items, array &$form, FormStateInterface $form_state) {
    $elements = parent::formMultipleElements($items, $form, $form_state);
    $elements['#widget'] = 'bricks_tree_paragraphs';

    return $elements;
  }

}
