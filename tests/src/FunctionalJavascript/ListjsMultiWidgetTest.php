<?php

namespace Drupal\Tests\listjs\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;
use Drupal\simpletest\NodeCreationTrait;

/**
 * Tests multiple listjs widgets in a single page.
 *
 * @ingroup listjs
 *
 * @group listjs
 */
class ListjsMultiWidgetTest extends JavascriptTestBase {

  use NodeCreationTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'listjs',
    'listjs_views',
    'listjs_multi_widget_test',
    'listjs_theme_test',
  ];

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
   * Tests whether theme widget filter does not affects listing in views widget.
   */
  public function testOnlyThemeWidgetFilter() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    /* --- Start: Check whether theme widget filter is working --- */
    $page->fillField('mykittens-are-unique-filter', 'sin');

    $this->assertCount(1, $page->findAll('css', '.mykittens li'));
    $this->assertEquals($page->find('css', '.mykittens li .value_name-house')->getText(), "Singh's");
    /* --- End: Check whether theme widget filter is working --- */

    // Check whether views widget is not affected.
    $this->assertCount(count($this->contents), $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li'));
  }

  /**
   * Tests whether views widget filter does not affects listing in theme widget.
   */
  public function testOnlyViewsWidgetFilter() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    /* --- Start: Check whether theme widget filter is working --- */
    $page->fillField('listjs_test_views_block-block_1-wrapper-filter', $this->contents[$this->randomContent]['title']);

    $this->assertCount(1, $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li'));
    $this->assertEquals($page->find('css', '#listjs_test_views_block-block_1-wrapper li .views-field-title')->getText(), $this->contents[$this->randomContent]['title']);
    $this->assertEquals($page->find('css', '#listjs_test_views_block-block_1-wrapper li .views-field-body')->getText(), $this->contents[$this->randomContent]['body']);
    /* --- End: Check whether theme widget filter is working --- */

    // Check whether theme widget is not affected.
    $this->assertCount(4, $page->findAll('css', '.mykittens li'));
  }

  /**
   * Tests whether theme widget sort does not affects listing in views widget.
   */
  public function testOnlyThemeWidgetSort() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    // Capture the views widget state before sorting theme widget.
    $content_count = count($this->contents);
    $elements = $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li .views-field-title');
    $widget_first_item_title = $elements[0]->getText();
    $widget_last_item_title = $elements[$content_count - 1]->getText();

    /* --- Start: Check whether theme widget sort is working --- */
    $page->findButton('Sort Kittens')->click();

    $this->assertCount(4, $page->findAll('css', '.mykittens li'));

    $elements = $page->findAll('css', '.mykittens li .value_name-cat');

    $this->assertEquals($elements[0]->getText(), 'Binky');
    $this->assertEquals($elements[3]->getText(), 'Tabby');
    /* --- End: Check whether theme widget sort is working --- */

    /* --- Start: Check whether views widget is not affected --- */
    $elements = $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li .views-field-title');

    $this->assertCount($content_count, $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li .views-field-title'));
    $this->assertEquals($widget_first_item_title, $elements[0]->getText());
    $this->assertEquals($widget_last_item_title, $elements[$content_count - 1]->getText());
    /* --- End: Check whether views widget is not affected --- */
  }

  /**
   * Tests whether views widget sort does not affects listing in theme widget.
   */
  public function testOnlyViewsWidgetSort() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();
    $content_count = count($this->contents);

    // Capture the theme widget state before sorting views widget.
    $elements = $page->findAll('css', '.mykittens li .value_name-cat');
    $widget_first_item_title = $elements[0]->getText();
    $widget_last_item_title = $elements[3]->getText();

    /* --- Start: Check whether views widget sort is working --- */
    $page->findButton('Content: Title sort')->click();

    $this->assertCount($content_count, $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li'));

    $elements = $page->findAll('css', '#listjs_test_views_block-block_1-wrapper li .views-field-title');

    $this->assertEquals($elements[0]->getText(), 'Angel');
    $this->assertEquals($elements[$content_count - 1]->getText(), 'Tom');
    /* --- End: Check whether views widget sort is working --- */

    /* --- Start: Check whether theme widget is not affected --- */
    $elements = $page->findAll('css', '.mykittens li .value_name-cat');

    $this->assertCount(4, $page->findAll('css', '.mykittens li .value_name-cat'));
    $this->assertEquals($widget_first_item_title, $elements[0]->getText());
    $this->assertEquals($widget_last_item_title, $elements[3]->getText());
    /* --- End: Check whether theme widget is not affected --- */
  }

}
