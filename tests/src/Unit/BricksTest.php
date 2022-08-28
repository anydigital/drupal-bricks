<?php

namespace Drupal\Tests\bricks\Unit;

use Drupal\bricks\Bricks;
use Drupal\bricks\BricksFieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Class BricksTest
 *
 * @group bricks
 */
class BricksTest extends UnitTestCase {

  /**
   * @dataProvider depthsProvider
   */
  public function testfindParentItems($depths, $expected_parents) {
    $a = new \ArrayObject();
    foreach ($depths as $depth) {
      $item = $this->prophesize(BricksFieldItemInterface::class);
      $item->getDepth()->willReturn($depth);
      $a[] = $item->reveal();
    }
    $item_list = $this->prophesize(FieldItemListInterface::class);
    $item_list->willImplement(\IteratorAggregate::class);
    $item_list->getIterator()->willReturn($a);
    $rc = new \ReflectionClass(Bricks::class);
    $root_object = $this->callMethod($rc, 'getRootObject');
    $this->assertSame(-1, $root_object->getDepth());
    $parents = $this->callMethod($rc, 'findParentItems', $item_list->reveal(), $root_object);
    foreach ($a as $i => $item) {
      $this->assertSame($a[$expected_parents[$i]] ?? $root_object, $parents[$item], "at index $i");
    }
  }

  /**
   * Data provider for testParentItems.
   *
   * @return \int[][][]
   *   A list of test cases. Each test case are two arrays, the first is a list
   *   of depth, the second is a list of expected parents based on those
   *   depths. This list contains keys of the first list and -1 for the root.
   */
  public function depthsProvider(): array {
    return [
      // This is a normal case.
      [[0, 1, 1, 2, 2, 0, 0, 1, 2, 0], [-1, 0, 0, 2, 2, -1, -1, 6, 7, -1]],
      // Has depth jumps of 2.
      [[0, 2, 0, 0, 2, 0], [-1, 0, -1, -1, 3, -1]],
      // Even more jumps.
      [[0, 2, 4, 2, 0], [-1, 0, 1, 0, -1]],
      // This is exceptionally broken.
      [[1, 3, 2], [-1, 0, 0]],
    ];
  }

  /**
   * Call a protected method on an object.
   *
   * @param \ReflectionClass $rc
   *   The object.
   * @param $method_name
   *   The method name on the object.
   * @param ...$args
   *   Arguments to pass to the method.
   *
   * @return mixed
   *   Return value from the method.
   */
  protected function callMethod(\ReflectionClass $rc, $method_name, ... $args): mixed {
    $method = $rc->getMethod($method_name);
    $method->setAccessible(TRUE);
    return $method->invokeArgs(NULL, $args);
  }

}
