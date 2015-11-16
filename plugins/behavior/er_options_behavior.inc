<?php

/**
 * Define a behavior for the Entity reference options.
 */

$plugin = array(
  'title' => t('Entity reference options'),
  'class' => 'EROptionsBehavior',
  'description' => t('Allows to set custom CSS class and other options per referenced entity'),
  'weight' => 10,
  'behavior type' => 'field',
);
