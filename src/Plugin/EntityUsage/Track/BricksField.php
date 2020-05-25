<?php

namespace Drupal\bricks\Plugin\EntityUsage\Track;

use Drupal\entity_usage\Plugin\EntityUsage\Track\EntityReference;

/**
 * Tracks usage of entities related in bricks fields.
 *
 * @EntityUsageTrack(
 *   id = "bricks_field",
 *   label = @Translation("Bricks Field"),
 *   description = @Translation("Tracks relationships created with 'Bricks' fields."),
 *   field_types = {"bricks"},
 * )
 */
class BricksField extends EntityReference {

}
