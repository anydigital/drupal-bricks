<?php

namespace Drupal\bricks\Plugin\Field\FieldWidget;

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
    _bricks_form_element_alter($element, $item, $entity);

    // Restore keyboard/screenreader accessibility for the depth field.
    $element['depth']['#type'] = 'textfield';
    $element['depth']['#size'] = 3;

    return $element;
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
