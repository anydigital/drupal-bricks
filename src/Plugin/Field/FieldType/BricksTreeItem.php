<?php

namespace Drupal\bricks\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\Core\TypedData\DataDefinition;

/**
 * @FieldType(
 *   id = "bricks",
 *   label = @Translation("Bricks"),
 *   description = @Translation("An entity field containing a tree of entity reference bricks."),
 *   category = @Translation("Reference"),
 *   default_widget = "bricks_tree_autocomplete",
 *   default_formatter = "bricks_nested",
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class BricksTreeItem extends EntityReferenceItem {

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['depth'] = DataDefinition::create('integer')
      ->setLabel(t('Depth'));

    $properties['options'] = DataDefinition::create('any')
      ->setLabel(t('Options'));

    return $properties;
  }

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    $schema['columns']['depth'] = array(
      'type' => 'int',
      'size' => 'tiny',
      'unsigned' => TRUE,
    );

    $schema['columns']['options'] = array(
      'type' => 'blob',
      'size' => 'normal',
      'not null' => FALSE,
      'serialize' => TRUE,
    );

    return $schema;
  }

}
