<?php

namespace Drupal\bricks_dynamic\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\dynamic_entity_reference\Plugin\Field\FieldType\DynamicEntityReferenceItem;

/**
 * {@inheritdoc}
 *
 * @FieldType(
 *   id = "bricks_dynamic",
 *   label = @Translation("Bricks (dynamic)"),
 *   description = @Translation("An entity field containing a tree of dynamic entity reference bricks."),
 *   category = @Translation("Dynamic Reference"),
 *   default_widget = "bricks_tree_dynamic",
 *   default_formatter = "bricks_nested_dynamic",
 *   list_class = "\Drupal\dynamic_entity_reference\Plugin\Field\FieldType\DynamicEntityReferenceFieldItemList",
 * )
 */
class BricksTreeDynamicItem extends DynamicEntityReferenceItem {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    _bricks_field_properties_alter($properties);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    _bricks_field_schema_alter($schema);

    return $schema;
  }

}
