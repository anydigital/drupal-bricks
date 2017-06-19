<?php

namespace Drupal\bricks_inline\Plugin\Field\FieldWidget;

use Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormComplex;

/**
 * @FieldWidget(
 *   id = "bricks_tree_inline",
 *   label = @Translation("Bricks tree (Inline entity form)"),
 *   description = @Translation("A tree of inline entity forms."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   },
 *   multiple_values = true
 * )
 */
class BricksTreeInlineWidget extends InlineEntityFormComplex {
}
