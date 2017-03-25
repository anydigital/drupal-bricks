<?php

namespace Drupal\bricks\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;

/**
 * @FieldFormatter(
 *   id = "bricks_nested",
 *   label = @Translation("Bricks (Nested)"),
 *   description = @Translation("Display the referenced entities recursively rendered by entity_view()."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   }
 * )
 */
class BricksNestedFormatter extends EntityReferenceEntityFormatter {
}
