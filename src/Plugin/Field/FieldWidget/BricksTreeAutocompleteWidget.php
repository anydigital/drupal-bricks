<?php

namespace Drupal\bricks\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;

/**
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
}
