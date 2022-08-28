<?php

namespace Drupal\Tests\bricks\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\user\Entity\User;
use Symfony\Component\DomCrawler\Crawler;

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
    'layout_discovery',
    'layout_test'
  ];

  protected function setUp(): void {
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
  public function testBricks(array $tree) {
    $paragraphs = [];
    $n = max(
      array_keys(
        iterator_to_array(
          new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($tree),
            // It doesn't matter whether SELF_FIRST or CHILD_FIRST but if none
            // is given then LEAVES_ONLY is the default and all our leaves are
            // empty.
            \RecursiveIteratorIterator::CHILD_FIRST
          )
        )
      )
    );
    for ($i = 1; $i <= $n; $i++) {
      $paragraph = Paragraph::create([
        'type' => 'test',
        'testplain' => "testplain $i",
        'id' => $i,
      ]);
      $paragraph->enforceIsNew();
      $paragraph->save();
      $paragraphs[$i] = $paragraph;
    }
    $node = Node::create([
      'type' => 'test',
      'title' => 'test',
    ]);
    $this->arrangeParagraphs($tree, $node, $paragraphs);
    $node->save();
    $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view($node);
    $contents = (string) \Drupal::service('renderer')->renderPlain($build);
    $crawler = new Crawler($contents);
    $bricks = $crawler->filter('.brick--id--1')->ancestors()->children();
    $total = $this->recurseBricks($tree, $bricks);
    $this->assertSame($n, $total);
  }

  public function arrangeParagraphs($tree, $node, $paragraphs, $depth = 0) {
    foreach ($tree as $id => $children) {
      [$paragraph_id, $layout] = explode(':', $id) + [1 => ''];
      $node->test->appendItem([
        'entity' => $paragraphs[$paragraph_id],
        'depth' => $depth,
        'options' => ['layout' => $layout],
      ]);
      $this->arrangeParagraphs($children, $node, $paragraphs, $depth + 1);
    }
  }

  /**
   * @param array $tree
   * @param \Symfony\Component\DomCrawler\Crawler $bricks
   * @return int
   */
  protected function recurseBricks(array $tree, Crawler $bricks): int {
    $total = count($tree);
    foreach (array_keys($tree) as $delta => $key) {
      [$paragraph_id, $layout] = explode(':', $key) + [1 => ''];
      $brick = $bricks->eq($delta);
      if ($layout) {
        $regions = \Drupal::service('plugin.manager.core.layout')
          ->createInstance($layout)
          ->getPluginDefinition()
          ->getRegionNames();
      }
      else {
        $regions = [''];
      }
      foreach ($regions as $region) {
        $child_bricks_container = $brick;
        // This unset()ensures the test blows up if $tree does not contain the
        // same amount of children as the layout it intends to use.
        unset($subtree);
        if ($region) {
          // @TODO assert $paragraph_id here.
          $child_bricks_container = $child_bricks_container->filter(".region-$region");
          // array_shift with key does not exist, so this ugly here needs to
          // suffice.
          foreach ($tree[$key] as $k => $v) {
            $subtree = [$k => $v];
            [$paragraph_id] = explode(':', $k);
            unset($tree[$key][$k]);
            break;
          }
        }
        else {
          $subtree = $tree[$key];
        }
        // This is just <div><div> but DOM is clumsy.
        $content = $child_bricks_container
          ->children()->first()
          ->children()->first();
        $this->assertSame("testplain $paragraph_id", $content->text());
        $total += $this->recurseBricks($subtree, $child_bricks_container->children()->filter('.paragraph'));
      }
    }
    return $total;
  }

  public function getTrees(): array {
    // Keys are the paragraph ID of parents, the values are subtrees.
    return [
      [[
        1 => [],
        2 => [3 => [], 4 => [5 => []]],
        6 => [7 => []],
      ]],
      [[
        1 => [],
        '2:layout_test_2col' => [
          3 => [4 => [], 5 => []],
          6 => [7 => []],
        ]
      ]],
    ];
  }

}
