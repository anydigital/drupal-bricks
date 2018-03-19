<?php

namespace Drupal\bricks\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * @ingroup views_field_handlers
 *
 * @ViewsField("bricksdepth")
 */
class BricksDepth extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['style'] = ['default' => ''];
    $options['prefix'] = ['default' => ''];
    $options['suffix'] = ['default' => ''];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['style'] = [
      '#type' => 'select',
      '#title' => $this->t('Style'),
      '#options' => [
        '' => $this->t('Raw value'),
        'space' => $this->t('Spaces'),
        'line' => $this->t('Lines'),
        'tree' => $this->t('Tree'),
      ],
      '#default_value' => $this->options['style'],
    ];
    $form['prefix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Prefix'),
      '#default_value' => $this->options['prefix'],
      '#description' => $this->t('Text to put before the number, such as currency symbol.'),
    ];
    $form['suffix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Suffix'),
      '#default_value' => $this->options['suffix'],
      '#description' => $this->t('Text to put after the number, such as currency symbol.'),
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $raw_value = $this->getValue($values);

    switch($this->options['style']) {
      case 'space':
        $indentation = [
          '#theme' => 'indentation',
          '#size' => $raw_value,
        ];
        $value =\Drupal::service('renderer')->render($indentation);
        break;
      case 'tree':
        if($raw_value > 0) 
          $value = '&nbsp;&nbsp;' . str_repeat('&nbsp;', ($raw_value - 1) * 4) . '└';
        else 
          $value = '';
        break;
      case 'line':
        $value = '└' . str_repeat('─', $raw_value);
        break;
      default:
        $value = $raw_value;
        break;
    }

    return [
      '#markup' =>
        $this->sanitizeValue($this->options['prefix'], 'xss')
        . $value
        . $this->sanitizeValue($this->options['suffix'], 'xss'),
    ];
  }

//   /**
//    * {@inheritdoc}
//    */
//   public function clickSort($order) {
//     $this->query->addOrderBy('node_field_data', 'created', $order);
//   }
// 
}
