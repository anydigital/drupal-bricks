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
  public function testBricks(array $tree) {
    $paragraphs = [];
    $n = max(array_keys($tree));
    for ($i = 1; $i <= $n; $i++) {
      $string = "testplain $i";
      $paragraph = Paragraph::create([
        'type' => 'test',
        'testplain' => $string,
        'test' => array_intersect_key($paragraphs, $tree[$i] ?? []),
        'id' => $i,
      ]);
      $paragraph->enforceIsNew();
      $paragraph->save();
      $paragraphs[$i] = $paragraph;
    }
    $node = Node::create([
      'type' => 'test',
      'title' => 'test',
      'test' => array_intersect_key($paragraphs, $tree),
    ]);
    $node->save();
    $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view($node);
    $contents = (string) \Drupal::service('renderer')->renderPlain($build);
    $crawler = new Crawler($contents);
    $bricks = $crawler->filter('.brick--id--1')->parents()->children();
    $total = $this->recurseBricks($tree, $bricks);
    $this->assertSame($n, $total);
  }

  /**
   * @param array $tree
   * @param \Symfony\Component\DomCrawler\Crawler $bricks
   * @return int
   */
  protected function recurseBricks(array $tree, Crawler $bricks): int {
    $total = count($tree);
    foreach (array_keys($tree) as $delta => $paragraph_id) {
      $brick = $bricks->eq($delta);
      // This is just <div><div> but DOM is clumsy.
      $content = $brick
        ->children()->first()
        ->children()->first();
      $this->assertSame("testplain $paragraph_id", $content->text());
      $total += $this->recurseBricks($tree[$paragraph_id], $brick->children()->filter('.paragraph'));
    }
    return $total;
  }

  public function getTrees(): array {
    // Keys are the paragraph ID of parents, the values are subtrees.
    return [
      [[
        1 => [],
        4 => [2 => [], 3 => []],
        6 => [5 => []],
      ]],
    ];
  }

}
