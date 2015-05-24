<?php
/**
 * @file
 * brickdown_quickstart.features.inc
 */

/**
 * Implements hook_eck_bundle_info().
 */
function brickdown_quickstart_eck_bundle_info() {
  $items = array(
    'brick_column' => array(
      'machine_name' => 'brick_column',
      'entity_type' => 'brick',
      'name' => 'column',
      'label' => 'Column',
    ),
    'brick_image' => array(
      'machine_name' => 'brick_image',
      'entity_type' => 'brick',
      'name' => 'image',
      'label' => 'Image',
    ),
    'brick_row' => array(
      'machine_name' => 'brick_row',
      'entity_type' => 'brick',
      'name' => 'row',
      'label' => 'Row',
    ),
    'brick_text' => array(
      'machine_name' => 'brick_text',
      'entity_type' => 'brick',
      'name' => 'text',
      'label' => 'Text',
    ),
  );
  return $items;
}

/**
 * Implements hook_eck_entity_type_info().
 */
function brickdown_quickstart_eck_entity_type_info() {
  $items = array(
    'brick' => array(
      'name' => 'brick',
      'label' => 'Brick',
      'properties' => array(),
    ),
  );
  return $items;
}

/**
 * Implements hook_node_info().
 */
function brickdown_quickstart_node_info() {
  $items = array(
    'page' => array(
      'name' => t('Page'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
