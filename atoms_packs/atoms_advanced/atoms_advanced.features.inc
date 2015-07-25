<?php
/**
 * @file
 * atoms_advanced.features.inc
 */

/**
 * Implements hook_eck_bundle_info().
 */
function atoms_advanced_eck_bundle_info() {
  $items = array(
    'atom_organism' => array(
      'machine_name' => 'atom_organism',
      'entity_type' => 'atom',
      'name' => 'organism',
      'label' => 'Organism',
    ),
    'atom_unit' => array(
      'machine_name' => 'atom_unit',
      'entity_type' => 'atom',
      'name' => 'unit',
      'label' => 'Unit',
    ),
  );
  return $items;
}
