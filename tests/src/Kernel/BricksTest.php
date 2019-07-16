<?php

namespace Drupal\Tests\bricks\Kernel;


use Drupal\Component\Utility\Html;
use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\user\Entity\User;
use PHPUnit\Framework\ExpectationFailedException;
use QueryPath;

/**
 * Class BricksTest
 *
 * @group bricks
 */
class BricksTest extends KernelTestBase {

  protected static $modules = [
    'system',
    'user',
    'text',
    'node',
    'file',
    'field',
    'paragraphs',
    'entity_reference_revisions',
    'bricks',
    'bricks_revisions',
    'bricks_test',
  ];

  protected function setUp() {
    parent::setUp();
    $this->installSchema('system', 'sequences');
    $this->installSchema('node', 'node_access');
    array_map([$this, 'installEntitySchema'], ['node', 'paragraph', 'user']);
    array_map([$this, 'installConfig'], ['bricks_test', 'system']);
    // bricks_test sets the aunthenticated user to have access content
    // permission.
    $author = User::create(['name' => 'author']);
    $author->save();
    \Drupal::service('account_switcher')->switchTo($author);
  }

  /**
   * @dataProvider getTrees
   */
  public function testBricks($tree) {
    $paragraphs = [];
    $strings = [];
    for ($i = 0; $i <= max(array_keys($tree)); $i++) {
      // Fighting escape rules of both QueryPath and PhpUnit is not fun and is
      // not a goal of this test so $this->>randomString() is not used.
      $string = $this->randomMachineName();
      $paragraph = Paragraph::create([
        'type' => 'test',
        'testplain' => $string,
        'test' => array_intersect_key($paragraphs, array_flip($tree[$i] ?? [])),
      ]);
      $paragraph->save();
      $paragraphs[$i] = $paragraph;
      $strings[] = $string;
    }
    $node = Node::create([
      'type' => 'test',
      'title' => 'test',
      'test' => array_intersect_key($paragraphs, $tree),
    ]);
    $node->save();
    $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view($node);
    $contents = (string) \Drupal::service('renderer')->renderPlain($build);
    $keys = array_keys($tree);
    /** @var \QueryPath\DOMQuery $qp */
    $qp = QueryPath::withHTML5($contents);
    /** @var \QueryPath\DOMQuery $paragraphElement*/
    foreach ($qp->firstChild()->lastChild()->firstChild()->lastChild()->lastChild()->children() as $paragraphElement) {
      $key = array_shift($keys);
      $this->assertTrue($paragraphElement->hasClass('brick--id--' . $paragraphs[$key]->id()));
      $this->assertSame($strings[$key], $paragraphElement->lastChild()->lastChild()->lastChild()->text());
      unset($strings[$key]);
      /** @var \QueryPath\DOMQuery $childElement */
      foreach ($paragraphElement->firstChild()->children()->children()->children('.paragraph') as $childElement) {
        $childKey = array_shift($tree[$key]);
        $this->assertSame($strings[$childKey], $childElement->lastChild()->lastChild()->lastChild()->text());
        unset($strings[$childKey]);
      }
    }
    $this->assertEmpty($keys);
    $this->assertEmpty(array_filter($tree));
    $this->assertEmpty($strings);
  }

  public function getTrees() {
    // Keys are parents, values are child indexes.
    return [
      [[
        0 => [],
        3 => [1, 2],
        5 => [4],
      ]],
    ];
  }

}
