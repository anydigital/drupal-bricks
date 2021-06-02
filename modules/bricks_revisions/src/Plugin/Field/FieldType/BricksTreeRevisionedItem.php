<?php

namespace Drupal\bricks_revisions\Plugin\Field\FieldType;

use Drupal\bricks\BricksFieldTypeTrait;
use Drupal\entity_reference_revisions\Plugin\Field\FieldType\EntityReferenceRevisionsItem;

/**
 * {@inheritdoc}
 *
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

  use BricksFieldTypeTrait;

  /**
   * {@inheritdoc}
   */
  public static function getPreconfiguredOptions() {
    return [];
  }

}
