<?php

namespace Drupal\Tests\bricks\Functional;

use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\taxonomy\Traits\TaxonomyTestTrait;

/**
 * Class BricksTest
 *
 * @group bricks
 */
class BricksTest extends BrowserTestBase {

  use TaxonomyTestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['field_ui', 'block', 'node', 'taxonomy', 'bricks'];

  /**
   * @var \Drupal\taxonomy\VocabularyInterface
   */
  protected $vocabulary;

  /**
   * @var string
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->drupalLogin($this->rootUser);

    $this->vocabulary = $this->createVocabulary();

    // Place the actions and title block.
    $this->drupalPlaceBlock('page_title_block', ['region' => 'content', 'weight' => -5]);
    $this->drupalPlaceBlock('local_tasks_block', ['region' => 'content', 'weight' => -10]);
    $this->drupalPlaceBlock('local_actions_block', ['region' => 'content', 'weight' => -12]);

    // Create an article content type that we will use for testing.
    $type =\Drupal::service('entity_type.manager')->getStorage('node_type')
      ->create([
        'type' => 'article',
        'name' => 'Article',
      ]);
    $type->save();

    $this->drupalGet('admin/structure/types/manage/article/fields');
    $this->clickLink('Add field');
    $edit = [
      'new_storage_type' => 'field_ui:entity_reference:taxonomy_term',
      'label' => 'Brick field',
      'field_name' => 'brick',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save and continue');
    $edit = [
      'cardinality' => -1,
    ];
    $this->drupalPostForm(NULL, $edit, 'Save field settings');

    $edit = [
      'settings[handler_settings][auto_create]' => TRUE,
      'settings[handler_settings][target_bundles][' . $this->vocabulary->id() . ']' => TRUE,
    ];
    $this->drupalPostForm(NULL, $edit, 'Save settings');
  }

  /**
   * Tests creating a brick.
   */
  public function testBricks() {
    // Create a node.
    $edit = [];
    $edit['title[0][value]'] = 'Llamas are cool';
    $edit['field_brick[0][target_id]'] = 'Camelid';
    $this->drupalPostForm("node/add/article", $edit, 'Save');
    $this->assertText('Article Llamas are cool has been created.');
  }

}
