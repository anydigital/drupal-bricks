<?php

/**
 * @file
 * Copy-paste from inline_entity_form.module.
 */

function _brickdown_inline_entity_form_entity_table_data($variables) {
  $form = $variables['form'];
  $entity_type = $form['#entity_type'];
  $fields = $form['#table_fields'];
  // Sort the fields by weight.
  uasort($fields, 'drupal_sort_weight');
  // If one of the rows is in form context, disable tabledrag.
  $has_tabledrag = TRUE;
  foreach (element_children($form) as $key) {
    if (!empty($form[$key]['form'])) {
      $has_tabledrag = FALSE;
    }
  }

  $header = array();
  if ($has_tabledrag) {
    $header[] = array('data' => '', 'class' => array('ief-tabledrag-header'));
    $header[] = array('data' => t('Sort order'), 'class' => array('ief-sort-order-header'));
  }
  // Add header columns for each field.
  $first = TRUE;
  foreach ($fields as $field_name => $field) {
    $column = array('data' => $field['label']);
    // The first column gets a special class.
    if ($first) {
      $column['class'] = array('ief-first-column-header');
      $first = FALSE;
    }
    $header[] = $column;
  }
  $header[] = t('Operations');

  // Build an array of entity rows for the table.
  $rows = array();
  foreach (element_children($form) as $key) {
    $entity = $form[$key]['#entity'];
    list($entity_id) = entity_extract_ids($entity_type, $entity);
    // Many field formatters (such as the ones for files and images) need
    // certain data that might be missing on unsaved entities because the field
    // load hooks haven't run yet. Because of that, those hooks are invoked
    // explicitly. This is the same trick used by node_preview().
    if ($form[$key]['#needs_save']) {
      _field_invoke_multiple('load', $entity_type, array($entity_id => $entity));
    }

    $row_classes = array('ief-row-entity');
    $cells = array();
    if ($has_tabledrag) {
      $cells[] = array('data' => '', 'class' => array('ief-tabledrag-handle'));
      $cells[] = drupal_render($form[$key]['delta']);
      $row_classes[] = 'draggable';
    }
    // Add a special class to rows that have a form underneath, to allow
    // for additional styling.
    if (!empty($form[$key]['form'])) {
      $row_classes[] = 'ief-row-entity-form';
    }

    // Add fields that represent the entity.
    $wrapper = entity_metadata_wrapper($entity_type, $entity);
    foreach ($fields as $field_name => $field) {
      $data = '';
      if ($field['type'] == 'property') {
        $property = $wrapper->{$field_name};
        // label() returns human-readable versions of token and list properties.
        $data = $property->label() ? $property->label() : $property->value();
        $data = check_plain($data);
      }
      elseif ($field['type'] == 'field' && isset($entity->{$field_name})) {
        $display = array(
          'label' => 'hidden',
        ) + $field;
        // The formatter needs to be under the 'type' key.
        if (isset($display['formatter'])) {
          $display['type'] = $display['formatter'];
          unset($display['formatter']);
        }

        $renderable_data = field_view_field($entity_type, $entity, $field_name, $display);
        // The field has specified an exact delta to display.
        if (isset($field['delta'])) {
          if (!empty($renderable_data[$field['delta']])) {
            $renderable_data = $renderable_data[$field['delta']];
          }
          else {
            // The field has no value for the specified delta, show nothing.
            $renderable_data = array();
          }
        }
        $data = drupal_render($renderable_data);
      }

      $cells[] = array('data' => $data, 'class' => array('inline-entity-form-' . $entity_type . '-' . $field_name));
    }
    // Add the buttons belonging to the "Operations" column.
    $cells[] = drupal_render($form[$key]['actions']);
    // Create the row.
    $rows[] = array('data' => $cells, 'class' => $row_classes);

    // If the current entity array specifies a form, output it in the next row.
    if (!empty($form[$key]['form'])) {
      $row = array(
        array('data' => drupal_render($form[$key]['form']), 'colspan' => count($fields) + 1),
      );
      $rows[] = array('data' => $row, 'class' => array('ief-row-form'), 'no_striping' => TRUE);
    }
  }

  if (!empty($rows)) {
    $id = 'ief-entity-table-' . $form['#id'];
    if ($has_tabledrag) {
      // Add the tabledrag JavaScript.
      // drupal_add_tabledrag($id, 'order', 'sibling', 'ief-entity-delta');
    }

    // Return the themed table.
    $table_attributes = array(
      'id' => $id,
      'class' => array('ief-entity-table'),
    );
    return array('header' => $header, 'rows' => $rows, 'sticky' => FALSE, 'attributes' => $table_attributes, 'has_tabledrag' => $has_tabledrag);
  }
}
