<?php

namespace Drupal\bricks\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;

/**
 * {@inheritdoc}
 *
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
