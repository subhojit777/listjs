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
  public static $modules = array('listjs_theme_test');

  /**
   * The installation profile to use with this test.
   *
   * @var string
   */
  protected $profile = 'standard';

  /**
   * Drupal libraries path.
   *
   * @var string
   */
  private $drupalLibrariesPath = 'libraries';

  /**
   * List.js library URL.
   *
   * @var string
   */
  private $listjsLibraryUrl = 'https://github.com/javve/list.js/archive/v1.2.0.zip';

  /**
   * List.js library directory name.
   *
   * @var string
   */
  private $listjsLibraryDirectoryName = 'listjs';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    if (!file_exists("{$this->drupalLibrariesPath}/$this->listjsLibraryDirectoryName")) {
      file_prepare_directory($this->drupalLibrariesPath, FILE_CREATE_DIRECTORY);

      // Download and setup the library.
      file_put_contents("{$this->drupalLibrariesPath}/listjs.zip", fopen($this->listjsLibraryUrl, 'r'));
      chdir($this->drupalLibrariesPath);
      exec('unzip listjs.zip');
      rename('list.js-1.2.0', $this->listjsLibraryDirectoryName);

      chdir(DRUPAL_ROOT);
    }
  }

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
