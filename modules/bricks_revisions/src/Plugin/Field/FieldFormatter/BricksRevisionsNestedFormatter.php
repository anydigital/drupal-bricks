<?php

namespace Drupal\bricks_revisions\Plugin\Field\FieldFormatter;

use Drupal\entity_reference_revisions\Plugin\Field\FieldFormatter\EntityReferenceRevisionsEntityFormatter;

/**
 * {@inheritdoc}
 *
 * @FieldFormatter(
 *   id = "bricks_revisions_nested",
 *   label = @Translation("Bricks (Nested)"),
 *   description = @Translation("Display the referenced entities recursively rendered by entity_view()."),
 *   field_types = {
 *     "bricks_revisioned"
 *   }
 * )
 */
class BricksRevisionsNestedFormatter extends EntityReferenceRevisionsEntityFormatter {
}
