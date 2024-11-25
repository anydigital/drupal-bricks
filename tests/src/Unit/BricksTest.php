<?php

namespace Drupal\Tests\bricks\Unit;

use Prophecy\PhpUnit\ProphecyTrait;
use Drupal\bricks\Bricks;
use Drupal\Tests\UnitTestCase;

/**
 * Class BricksTest
 *
 * @group bricks
 */
class BricksTest extends UnitTestCase {

  use ProphecyTrait;
  /**
   * @dataProvider depthsProvider
   */
  public function testFixDepths($depths, $expected_depths) {
    $a = new \ArrayObject();
    foreach ($depths as $depth) {
      $a[] = new class($depth) {
        function __construct(protected $depth) {}
        function getDepth() {
          return $this->depth;
        }
        function setDepth($depth): self {
          $this->depth = $depth;
          return $this;
        }
      };
    }
    Bricks::correctDepths($a);
    $this->assertSame($expected_depths, array_map(fn ($x) => $x->getDepth(), iterator_to_array($a)));
  }

  public static function depthsProvider() {
    return [
      // This is a normal case.
      [[0, 1, 1, 2, 2, 0, 0, 1, 2, 0], [0, 1, 1, 2, 2, 0, 0, 1, 2, 0]],
      // This needs correction.
      [[0, 2, 0, 0, 2, 0], [0, 1, 0, 0, 1, 0]],
      // This even more so.
      [[0, 2, 4, 2, 0], [0, 1, 2, 1, 0]],
      // This is so broken it's hard to say what it even *should* be.
      [[0, 2, 1], [0, 1, 1]],
    ];
  }

}
