<?php

namespace Drupal\bricks_dynamic\Plugin\Field\FieldFormatter;

use Drupal\dynamic_entity_reference\Plugin\Field\FieldFormatter\DynamicEntityReferenceEntityFormatter;

/**
 * {@inheritdoc}
 *
 * @FieldFormatter(
 *   id = "bricks_nested_dynamic",
 *   label = @Translation("Bricks (Nested dynamic)"),
 *   description = @Translation("Display the referenced entities recursively rendered by entity_view()."),
 *   field_types = {
 *     "bricks_dynamic"
 *   }
 * )
 */
class BricksNestedDynamicFormatter extends DynamicEntityReferenceEntityFormatter {
}
