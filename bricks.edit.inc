<?php

/**
 * Implements hook_theme().
 */
function bricks_theme() {
  return array(
    'bricks_tree_value_form' => array(
      'render element' => 'element',
    ),
  );
}

/**
 * Implements hook_field_attach_form().
 */
function bricks_field_attach_form($entity_type, $entity, &$form, &$form_state, $langcode) {
  if (module_exists('treeable')) return;

  // Determine the list of instances to iterate on.
  list(, , $bundle) = entity_extract_ids($entity_type, $entity);
  $instances = _field_invoke_get_instances($entity_type, $bundle);

  // Iterate through the instances and collect results.
  foreach ($instances as $instance) {
    $field_name = $instance['field_name'];
    $field = field_info_field($field_name);

    if (!empty($field['settings']['handler_settings']['behaviors']['treeable_behavior']['status'])) {
      $form[$field_name][$langcode]['#theme'] = 'bricks_tree_value_form';
    }
  }
}

/**
 * Returns HTML for a field tree element.
 *
 * @see theme_field_multiple_value_form()
 */
function theme_bricks_tree_value_form($variables) {
  $element = $variables['element'];
  $output = '';

  if ($element['#cardinality'] > 1 || $element['#cardinality'] == FIELD_CARDINALITY_UNLIMITED) {
    $table_id = drupal_html_id($element['#field_name'] . '_values');
    $order_class = $element['#field_name'] . '-delta-order';
    $required = !empty($element['#required']) ? theme('form_required_marker', $variables) : '';

    $header = array(
      array(
        'data' => '<label>' . t('!title !required', array('!title' => $element['#title'], '!required' => $required)) . "</label>",
        'colspan' => 3,
        'class' => array('field-label'),
      ),
      t('Order'),
    );
    $rows = array();

    // Sort items according to '_weight' (needed when the form comes back after
    // preview or failed validation)
    $items = array();
    foreach (element_children($element) as $key) {
      if ($key === 'add_more') {
        $add_more_button = &$element[$key];
      }
      else {
        $items[] = &$element[$key];
      }
    }
    usort($items, '_field_sort_items_value_helper');

    // Add the items as table rows.
    foreach ($items as $key => $item) {
      $item['_weight']['#attributes']['class'] = array($order_class);
      $delta_element = drupal_render($item['_weight']);
      $depth_element = $item['depth'];
      unset($item['depth']);

      $cells = array(
        theme('indentation', array('size' => $depth_element['#value'])),
        drupal_render($depth_element),
        array('data' => drupal_render($item), 'class' => array('treeable-form-item')),
        array('data' => $delta_element, 'class' => array('delta-order')),
      );
      $rows[] = array(
        'data' => $cells,
        'class' => array('draggable'),
      );
    }

    $output = '<div class="form-item">';
    $output .= theme('table', array('header' => $header, 'rows' => $rows, 'attributes' => array('id' => $table_id, 'class' => array('field-multiple-table'))));
    $output .= $element['#description'] ? '<div class="description">' . $element['#description'] . '</div>' : '';
    $output .= '<div class="clearfix">' . drupal_render($add_more_button) . '</div>';
    $output .= '</div>';

    drupal_add_tabledrag($table_id, 'order', 'all', $order_class);
    drupal_add_tabledrag($table_id, 'depth', 'group', $element['#field_name'] . '-depth');
    // Fake call to enable indentation:
    drupal_add_tabledrag($table_id, 'match', 'parent', $order_class);
  }
  else {
    foreach (element_children($element) as $key) {
      $output .= drupal_render($element[$key]);
    }
  }

  return $output;
}
