<?php

/**
 * @file
 * Main listjs Behat context.
 */

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;

/**
 * Defines application features from the specific context.
 */
class ListjsContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * @var \Drupal\DrupalExtension\Context\MinkContext
   */
  protected $minkContext;

  /**
   * @BeforeScenario
   */
  public function gatherContexts(BeforeScenarioScope $scope) {
    $this->minkContext = $scope->getEnvironment()->getContext('Drupal\DrupalExtension\Context\MinkContext');
  }

  /**
   * @AfterStep
   */
  public function dumpInfoAfterFailedStep(AfterStepScope $scope) {
    if ($scope->getTestResult()->getResultCode() === TestResult::FAILED) {
      $screenshot_path = getcwd() . '/screenshots';
      $driver = $this->getSession()->getDriver();

      if (!file_exists($screenshot_path)) {
        mkdir($screenshot_path);
      }

      if (!$driver instanceof Selenium2Driver) {
        return;
      }

      $screenshot_file_path = $screenshot_path . '/' . date('d-m-y') . '-' . uniqid() . '.png';
      $screenshot = $driver->getScreenshot();
      file_put_contents($screenshot_file_path, $screenshot);
      print "Screenshot at: $screenshot_file_path";
    }
  }

  /**
   * Asserts whether items with count found in region.
   *
   * @Then I should see :count item(s) in :region
   *
   * @throws \Exception
   *   If items with incorrect count found in the region.
   *
   * @param int $count
   *   Number of items.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertRowCount($count, $region) {
    if (count($this->minkContext->getRegion($region)->findAll('css', "li")) != $count) {
      throw new \Exception(sprintf('"%d" rows found in "%s" region on the page "%s"', count($this->minkContext->getRegion($region)->findAll('css', "li")), $region, $this->minkContext->getSession()->getCurrentUrl()));
    }
  }

}
