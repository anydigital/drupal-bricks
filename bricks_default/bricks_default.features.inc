<?php
/**
 * @file
 * bricks_default.features.inc
 */

/**
 * Implements hook_views_api().
 */
function bricks_default_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_eck_bundle_info().
 */
function bricks_default_eck_bundle_info() {
  $items = array(
    'brick_columns' => array(
      'machine_name' => 'brick_columns',
      'entity_type' => 'brick',
      'name' => 'columns',
      'label' => 'Columns',
    ),
    'brick_grid' => array(
      'machine_name' => 'brick_grid',
      'entity_type' => 'brick',
      'name' => 'grid',
      'label' => 'Grid',
    ),
    'brick_image' => array(
      'machine_name' => 'brick_image',
      'entity_type' => 'brick',
      'name' => 'image',
      'label' => 'Image',
    ),
    'brick_section' => array(
      'machine_name' => 'brick_section',
      'entity_type' => 'brick',
      'name' => 'section',
      'label' => 'Section',
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
function bricks_default_eck_entity_type_info() {
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
function bricks_default_node_info() {
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
