<?php

namespace Drupal\bricks_inline\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormComplex;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 *
 * @FieldWidget(
 *   id = "bricks_tree_inline",
 *   label = @Translation("Bricks tree (Inline entity form)"),
 *   description = @Translation("A tree of inline entity forms."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   },
 *   multiple_values = true
 * )
 */
class BricksTreeInlineWidget extends InlineEntityFormComplex {

  /**
   * {@inheritdoc}
   */
  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $elements = parent::form($items, $form, $form_state, $get_delta);

    // Signal to content_translation that this field should be treated as
    // multilingual and not be hidden, see
    // \Drupal\content_translation\ContentTranslationHandler::entityFormSharedElements().
    $elements['#multilingual'] = TRUE;
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['entities']['#widget'] = 'bricks_tree_inline';

    $entities = $form_state->get(['inline_entity_form', $this->getIefId(), 'entities']);
    foreach ($entities as $delta => $value) {
      _bricks_form_element_alter($element['entities'][$delta], $items[$delta], $value['entity']);
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $field_name = $this->fieldDefinition->getName();
    $field_value = $form_state->getValue($field_name);

    foreach ($values as $delta => $value) {
      if (isset($field_value['entities'][$delta])) {
        $values[$delta]['depth'] = $field_value['entities'][$delta]['depth'];
        $values[$delta]['options'] = $field_value['entities'][$delta]['options'];
      }
    }

    return $values;
  }

}
