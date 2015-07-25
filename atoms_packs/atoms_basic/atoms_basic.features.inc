<?php
/**
 * @file
 * atoms_basic.features.inc
 */

/**
 * Implements hook_eck_bundle_info().
 */
function atoms_basic_eck_bundle_info() {
  $items = array(
    'atom_columns' => array(
      'machine_name' => 'atom_columns',
      'entity_type' => 'atom',
      'name' => 'columns',
      'label' => 'Columns',
    ),
    'atom_group' => array(
      'machine_name' => 'atom_group',
      'entity_type' => 'atom',
      'name' => 'group',
      'label' => 'Group',
    ),
    'atom_image' => array(
      'machine_name' => 'atom_image',
      'entity_type' => 'atom',
      'name' => 'image',
      'label' => 'Image',
    ),
    'atom_text' => array(
      'machine_name' => 'atom_text',
      'entity_type' => 'atom',
      'name' => 'text',
      'label' => 'Text',
    ),
  );
  return $items;
}

/**
 * Implements hook_eck_entity_type_info().
 */
function atoms_basic_eck_entity_type_info() {
  $items = array(
    'atom' => array(
      'name' => 'atom',
      'label' => 'Atom',
      'properties' => array(),
    ),
  );
  return $items;
}

/**
 * Implements hook_node_info().
 */
function atoms_basic_node_info() {
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
