<?php

namespace Drupal\Tests\listjs\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;

/**
 * Tests listjs theme integration.
 *
 * @ingroup listjs
 *
 * @group listjs
 */
class ListjsThemeTest extends JavascriptTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['listjs_lib', 'listjs', 'listjs_theme_test'];

  /**
   * The installation profile to use with this test.
   *
   * @var string
   */
  protected $profile = 'standard';

  /**
   * Test whether filter is working for house field.
   */
  public function testFilterHouseField() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    $page->fillField('mykittens-are-unique-filter', 'sin');

    $this->assertCount(1, $page->findAll('css', '.mykittens li'));
    $this->assertEquals($page->find('css', '.mykittens li .value_name-house')->getText(), "Singh's");
    $this->assertEquals($page->find('css', '.mykittens li .value_name-cat')->getText(), 'Tabby');
    $this->assertNotEquals($page->find('css', '.mykittens li .value_name-cat')->getText(), 'Binky');
  }

  /**
   * Test whether filter is working for cat field.
   */
  public function testFilterCatField() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    $page->fillField('mykittens-are-unique-filter', 'chink');

    $this->assertCount(1, $page->findAll('css', '.mykittens li'));
    $this->assertEquals($page->find('css', '.mykittens li .value_name-house')->getText(), "Paul's");
    $this->assertEquals($page->find('css', '.mykittens li .value_name-cat')->getText(), 'Chinky');
    $this->assertNotEquals($page->find('css', '.mykittens li .value_name-cat')->getText(), "Jones's");
  }

  /**
   * Test whether sort is working.
   */
  public function testSort() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    $page->findButton('Sort Kittens')->click();

    $this->assertCount(4, $page->findAll('css', '.mykittens li'));

    $elements = $page->findAll('css', '.mykittens li .value_name-cat');

    $this->assertEquals($elements[0]->getText(), 'Binky');
    $this->assertEquals($elements[3]->getText(), 'Tabby');
  }

  /**
   * Test whether disable sort setting is working.
   */
  public function testDisableSort() {
    $this->drupalGet('/listjs-theme-test');
    $page = $this->getSession()->getPage();

    $this->assertNull($page->findButton('Sort House'));
  }

}
