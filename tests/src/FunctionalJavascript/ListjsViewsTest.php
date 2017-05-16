<?php

namespace Drupal\Tests\listjs\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;
use Drupal\simpletest\NodeCreationTrait;

/**
 * Tests listjs views style plugin.
 *
 * @ingroup listjs
 *
 * @group listjs
 */
class ListjsViewsTest extends JavascriptTestBase {

  use NodeCreationTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['listjs', 'listjs_views', 'listjs_test_views'];

  /**
   * The installation profile to use with this test.
   *
   * @var string
   */
  protected $profile = 'standard';

  /**
   * Test contents.
   *
   * @var array
   */
  private $contents = [
    [
      'title' => 'Max',
      'body' => 'The brave cat',
    ],
    [
      'title' => 'Chloe',
      'body' => 'The cute cat',
    ],
    [
      'title' => 'Angel',
      'body' => 'The holy cat',
    ],
    [
      'title' => 'Smokey',
      'body' => 'The wispy cat',
    ],
    [
      'title' => 'Felix',
      'body' => 'The lucky cat',
    ],
    [
      'title' => 'Mimi',
      'body' => 'The chinese cat',
    ],
    [
      'title' => 'Mau',
      'body' => 'The indian cat',
    ],
    [
      'title' => 'Grumpy',
      'body' => 'The grumpy cat',
    ],
    [
      'title' => 'Sylvester',
      'body' => 'The Looney Tunes cat',
    ],
    [
      'title' => 'Tom',
      'body' => 'The Tom and Jerry cat',
    ],
  ];

  /**
   * Randomly chosen index of test content.
   *
   * @var int
   */
  private $randomContent;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    foreach ($this->contents as $item) {
      $this->drupalCreateNode([
        'title' => $item['title'],
        'body' => [
          'value' => $item['body'],
          'format' => filter_default_format(),
        ],
      ]);
    }

    $this->randomContent = mt_rand(0, count($this->contents) - 1);
  }

  /**
   * Tests whether filter is working for title field.
   */
  public function testFilterTitleField() {
    $this->drupalGet('/listjs-views-test');
    $page = $this->getSession()->getPage();

    $page->fillField('listjs_test_views-page_1-wrapper-filter', $this->contents[$this->randomContent]['title']);

    $this->assertCount(1, $page->findAll('css', '.view-listjs-test-views li'));
    $this->assertEquals($page->find('css', '.view-listjs-test-views li .views-field-title')->getText(), $this->contents[$this->randomContent]['title']);
    $this->assertEquals($page->find('css', '.view-listjs-test-views li .views-field-body')->getText(), $this->contents[$this->randomContent]['body']);
  }

  /**
   * Tests whether filter is working for body field.
   */
  public function testFilterBodyField() {
    $this->drupalGet('/listjs-views-test');
    $page = $this->getSession()->getPage();

    $page->fillField('listjs_test_views-page_1-wrapper-filter', $this->contents[$this->randomContent]['body']);

    $this->assertCount(1, $page->findAll('css', '.view-listjs-test-views li'));
    $this->assertEquals($page->find('css', '.view-listjs-test-views li .views-field-body')->getText(), $this->contents[$this->randomContent]['body']);
    $this->assertEquals($page->find('css', '.view-listjs-test-views li .views-field-title')->getText(), $this->contents[$this->randomContent]['title']);
  }

  /**
   * Tests whether sort is working.
   */
  public function testSort() {
    $this->drupalGet('/listjs-views-test');
    $page = $this->getSession()->getPage();
    $content_count = count($this->contents);

    $page->findButton('Content: Title sort')->click();

    $this->assertCount($content_count, $page->findAll('css', '.view-listjs-test-views li'));

    $elements = $page->findAll('css', '.view-listjs-test-views li .views-field-title');

    $this->assertEquals($elements[0]->getText(), 'Angel');
    $this->assertEquals($elements[$content_count - 1]->getText(), 'Tom');
  }

  /**
   * Tests whether there are no result for non existing value.
   */
  public function testNoResult() {
    $this->drupalGet('/listjs-views-test');
    $page = $this->getSession()->getPage();

    $page->fillField('listjs_test_views-page_1-wrapper-filter', 'Octopuss');

    $this->assertNull($page->findAll('css', '.view-listjs-test-views li'));
  }

}
