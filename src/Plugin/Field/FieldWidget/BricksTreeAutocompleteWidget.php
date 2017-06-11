<?php

namespace Drupal\bricks\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "bricks_tree_autocomplete",
 *   label = @Translation("Bricks tree (Autocomplete)"),
 *   description = @Translation("A tree of autocomplete text fields."),
 *   field_types = {
 *     "bricks"
 *   }
 * )
 */
class BricksTreeAutocompleteWidget extends EntityReferenceAutocompleteWidget {

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // #default_value is en Entity or NULL.
    _bricks_form_element_alter($element, $items[$delta], $element['target_id']['#default_value']);
    hide($element['depth']);

    return $element;
  }

  protected function formMultipleElements(FieldItemListInterface $items, array &$form, FormStateInterface $form_state) {
    $elements = parent::formMultipleElements($items, $form, $form_state);

    $elements['#widget'] = 'bricks_tree_autocomplete';

    return $elements;
  }

}
