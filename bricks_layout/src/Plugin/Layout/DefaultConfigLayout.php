<?php

/**
 * @file
 * Default configurable layout definition. See bricks_layout_layout_alter() for a sample use case.
 *
 * Refs:
 * - https://git.drupalcode.org/project/layouts/blob/8.x-1.x/src/Plugin/Layout/DefaultConfigLayout.php
 * - https://www.drupal.org/docs/8/api/layout-api/how-to-register-layouts#using-class-key
 */

namespace Drupal\bricks_layout\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

class DefaultConfigLayout extends LayoutDefault implements PluginFormInterface {
  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
    $form = [];
    // $form['extra_classes'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Extra classes'),
    //   '#default_value' => $configuration['extra_classes'],
    // ];
    return $form;
  }

  /**
   * @inheritdoc
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    // any additional form validation that is required
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    // $this->configuration['extra_classes'] = $form_state->getValue('extra_classes');
  }
}
