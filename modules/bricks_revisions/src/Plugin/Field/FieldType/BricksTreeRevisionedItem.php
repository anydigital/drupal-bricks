<?php

namespace Drupal\bricks_revisions\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\entity_reference_revisions\Plugin\Field\FieldType\EntityReferenceRevisionsItem;

/**
 * @FieldType(
 *   id = "bricks_revisioned",
 *   label = @Translation("Bricks (revisioned)"),
 *   description = @Translation("An entity field containing a tree of revisioned entity reference bricks."),
 *   category = @Translation("Reference revisions"),
 *   default_widget = "bricks_tree_autocomplete",
 *   default_formatter = "bricks_nested",
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class BricksTreeRevisionedItem extends EntityReferenceRevisionsItem {

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    _bricks_field_properties_alter($properties);

    return $properties;
  }

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    _bricks_field_schema_alter($schema);

    return $schema;
  }

}
