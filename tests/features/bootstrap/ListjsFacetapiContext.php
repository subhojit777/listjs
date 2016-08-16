<?php

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\DrupalExtension\Context\DrushContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class ListjsFacetapiContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * @var \Drupal\DrupalExtension\Context\DrupalContext
   */
  protected $drupalContext;

  /**
   * @var \Drupal\DrupalExtension\Context\MinkContext
   */
  protected $minkContext;

  /**
   * Initializes context.
   */
  public function __construct() {
  }

  /** @BeforeSuite */
  public static function setup(BeforeSuiteScope $scope) {
    $environment = $scope->getEnvironment();

    //$this->minkContext = $environment->getContext('Drupal\DrupalExtension\Context\MinkContext');
    //$this->drupalContext = $environment->getContext('Drupal\DrupalExtension\Context\DrupalContext');
  }

}
