<?php

namespace Drupal\bricks_inline\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormComplex;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "bricks_tree_inline",
 *   label = @Translation("Bricks tree (Inline entity form)"),
 *   description = @Translation("A tree of inline entity forms."),
 *   field_types = {
 *     "bricks"
 *   },
 *   multiple_values = true
 * )
 */
class BricksTreeInlineWidget extends InlineEntityFormComplex {

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['entities']['#widget'] = 'bricks_tree_inline';

    $entities = $form_state->get(['inline_entity_form', $this->getIefId(), 'entities']);
    foreach ($entities as $delta => $value) {
      $element['entities'][$delta]['depth'] = array(
        '#type' => 'hidden', // @TODO: Other types break the correct indentations.
        '#default_value' => !empty($items[$delta]->depth) ? $items[$delta]->depth : 0,
        '#weight' => 10,
        '#attributes' => array(
          'class' => array('bricks-depth'),
        ),
      );
    }

    return $element;
  }

  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $field_name = $this->fieldDefinition->getName();

    foreach ($values as $delta => $value) {
      $values[$delta]['depth'] = $form_state->getValue($field_name)['entities'][$delta]['depth'];
    }

    return $values;
  }

}
