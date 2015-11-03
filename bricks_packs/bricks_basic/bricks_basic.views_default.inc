<?php
/**
 * @file
 * bricks_basic.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function bricks_basic_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'brick_selector';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'eck_brick';
  $view->human_name = 'Brick selector';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['use_ajax'] = TRUE;
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Field: Brick: Id */
  $handler->display->display_options['fields']['id']['id'] = 'id';
  $handler->display->display_options['fields']['id']['table'] = 'eck_brick';
  $handler->display->display_options['fields']['id']['field'] = 'id';
  /* Filter criterion: Brick: brick type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'eck_brick';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['exposed'] = TRUE;
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['filters']['type']['expose']['remember_roles'] = array(
    2 => '2',
    1 => 0,
  );

  /* Display: Reference dialog Search */
  $handler = $view->new_display('references_dialog', 'Reference dialog Search', 'dialog');
  $handler->display->display_options['defaults']['style_options'] = FALSE;
  $handler->display->display_options['defaults']['row_plugin'] = FALSE;
  $handler->display->display_options['row_plugin'] = 'entity';
  $handler->display->display_options['row_options']['view_mode'] = 'teaser';
  $handler->display->display_options['defaults']['row_options'] = FALSE;
  $handler->display->display_options['attach'] = array(
    0 => 'node:field_header:page',
    1 => 'node:field_content:page',
    2 => 'brick:field_content:section',
  );
  $export['brick_selector'] = $view;

  return $export;
}
