<?php

namespace Drupal\bricks;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

trait BricksFieldTypeTrait {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);
    $schema['columns']['depth'] = [
      'type' => 'int',
      'size' => 'tiny',
      'unsigned' => TRUE,
    ];

    $schema['columns']['options'] = [
      'type' => 'blob',
      'size' => 'normal',
      'not null' => FALSE,
      'serialize' => TRUE,
    ];
    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);
    $properties['depth'] = DataDefinition::create('integer')
      ->setLabel(t('Depth'));

    $properties['options'] = DataDefinition::create('any')
      ->setLabel(t('Options'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function getPreconfiguredOptions() {
    $options = parent::getPreconfiguredOptions();
    array_walk($options, function (array &$option) {
      $option['label'] .= ' (bricks)';
    });
    return $options;
  }

}
