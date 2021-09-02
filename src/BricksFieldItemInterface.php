<?php

namespace Drupal\bricks;

use Drupal\Core\Field\FieldItemInterface;

interface BricksFieldItemInterface extends FieldItemInterface {

  /**
   * @return int
   *   The depth.
   */
  public function getDepth();

  /**
   * @param $option
   *   The name of the option.
   * @param null $default
   *   The default.
   *
   * @return mixed
   *   The value of the option.
   */
  public function getOption($option, $default = NULL);
}
