<?php

namespace Drupal\bricks_dynamic\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dynamic_entity_reference\Plugin\Field\FieldWidget\DynamicEntityReferenceWidget;

/**
 * {@inheritdoc}
 *
 * @FieldWidget(
 *   id = "bricks_tree_dynamic",
 *   label = @Translation("Bricks tree (Dynamic)"),
 *   description = @Translation("A tree of autocomplete text fields."),
 *   field_types = {
 *     "bricks_dynamic"
 *   }
 * )
 */
class BricksTreeDynamicWidget extends DynamicEntityReferenceWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // #default_value is en Entity or NULL.
    _bricks_form_element_alter($element, $items[$delta], $element['target_id']['#default_value']);
    hide($element['depth']);

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  protected function formMultipleElements(FieldItemListInterface $items, array &$form, FormStateInterface $form_state) {
    $elements = parent::formMultipleElements($items, $form, $form_state);

    $elements['#widget'] = 'bricks_tree_dynamic';

    return $elements;
  }

}
