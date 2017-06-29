<?php

namespace Drupal\bricks\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;

/**
 * {@inheritdoc}
 *
 * @FieldWidget(
 *   id = "bricks_tree_autocomplete",
 *   label = @Translation("Bricks tree (Autocomplete)"),
 *   description = @Translation("A tree of autocomplete text fields."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   }
 * )
 */
class BricksTreeAutocompleteWidget extends EntityReferenceAutocompleteWidget {
  // DEPRECATED in favor of generic `entity_reference_autocomplete`.
  // Kept for backward compatibility.
}
