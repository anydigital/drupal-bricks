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
    'atom_image' => array(
      'machine_name' => 'atom_image',
      'entity_type' => 'atom',
      'name' => 'image',
      'label' => 'Image',
    ),
    'atom_organism' => array(
      'machine_name' => 'atom_organism',
      'entity_type' => 'atom',
      'name' => 'organism',
      'label' => 'Organism',
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
