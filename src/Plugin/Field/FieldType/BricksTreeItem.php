<?php

namespace Drupal\bricks\Plugin\Field\FieldType;

use Drupal\bricks\BricksFieldTypeTrait;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;

/**
 * {@inheritdoc}
 *
 * @FieldType(
 *   id = "bricks",
 *   label = @Translation("Bricks"),
 *   description = @Translation("An entity field containing a tree of entity reference bricks."),
 *   category = @Translation("Reference"),
 *   default_widget = "entity_reference_autocomplete",
 *   default_formatter = "bricks_nested",
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class BricksTreeItem extends EntityReferenceItem {

  use BricksFieldTypeTrait;

  /**
   * {@inheritdoc}
   */
  public static function getPreconfiguredOptions() {
    return [];
  }

}
