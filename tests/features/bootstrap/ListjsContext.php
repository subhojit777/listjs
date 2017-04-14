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
   * Mink context.
   *
   * @var \Drupal\DrupalExtension\Context\MinkContext
   */
  protected $minkContext;

  /**
   * Initializes contexts before running every scenario.
   *
   * @BeforeScenario
   */
  public function gatherContexts(BeforeScenarioScope $scope) {
    $this->minkContext = $scope->getEnvironment()->getContext('Drupal\DrupalExtension\Context\MinkContext');
  }

  /**
   * Creates screenshot is step fails.
   *
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
   * @param int $count
   *   Number of items.
   * @param string $region
   *   Behat region.
   *
   * @Then I should see :count item(s) in :region
   */
  public function assertRowCount($count, $region) {
    PHPUnit_Framework_Assert::assertCount($count, $this->minkContext->getRegion($region)->findAll('css', "li"));
  }

}
