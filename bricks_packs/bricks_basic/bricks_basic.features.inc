<?php
/**
 * @file
 * bricks_basic.features.inc
 */

/**
 * Implements hook_views_api().
 */
function bricks_basic_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_eck_bundle_info().
 */
function bricks_basic_eck_bundle_info() {
  $items = array(
    'brick_image' => array(
      'machine_name' => 'brick_image',
      'entity_type' => 'brick',
      'name' => 'image',
      'label' => 'Image',
    ),
    'brick_molecule' => array(
      'machine_name' => 'brick_molecule',
      'entity_type' => 'brick',
      'name' => 'molecule',
      'label' => 'Molecule',
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
function bricks_basic_eck_entity_type_info() {
  $items = array(
    'brick' => array(
      'name' => 'brick',
      'label' => 'Brick',
      'properties' => array(
        'machine_name' => array(
          'label' => 'Machine name',
          'type' => 'text',
          'behavior' => '',
        ),
      ),
    ),
  );
  return $items;
}

/**
 * Implements hook_node_info().
 */
function bricks_basic_node_info() {
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
