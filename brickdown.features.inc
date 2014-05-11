<?php
/**
 * @file
 * brickdown.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function brickdown_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "twig" && $api == "default_twig_templates") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function brickdown_node_info() {
  $items = array(
    'stack' => array(
      'name' => t('Stack'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
