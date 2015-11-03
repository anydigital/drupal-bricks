<?php
/**
 * @file
 * bricks_advanced.features.inc
 */

/**
 * Implements hook_eck_bundle_info().
 */
function bricks_advanced_eck_bundle_info() {
  $items = array(
    'brick_unit' => array(
      'machine_name' => 'brick_unit',
      'entity_type' => 'brick',
      'name' => 'unit',
      'label' => 'Unit',
    ),
  );
  return $items;
}
