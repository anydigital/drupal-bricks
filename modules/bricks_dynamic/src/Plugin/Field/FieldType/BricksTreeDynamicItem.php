<?php

namespace Drupal\bricks_dynamic\Plugin\Field\FieldType;

use Drupal\bricks\BricksFieldItemInterface;
use Drupal\bricks\BricksFieldTypeTrait;
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
class BricksTreeDynamicItem extends DynamicEntityReferenceItem implements BricksFieldItemInterface {

  use BricksFieldTypeTrait;

}
