<?php

/**
 * @file
 * Behat views context.
 */

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Defines application features from the specific context.
 */
class ListjsThemeContext extends RawDrupalContext implements SnippetAcceptingContext {

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
   * Asserts whether item with value found in region.
   *
   * @Then I should see item with value :value as :field in :region
   *
   * @throws \Exception
   *   If item with specific value not found in the region.
   *
   * @param string $value
   *   Value of the items.
   * @param string $field
   *   Field name.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertRowValueVisibility($value, $field, $region) {
    $text = $this->minkContext->getRegion($region)->find('css', "li .value_name-$field")->getText();

    if ($text !== $value) {
      throw new \Exception(sprintf('Item with value "%s" not found in the region "%s" on the page "%s"', $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }
  }

  /**
   * Asserts whether item with value not found in region.
   *
   * @Then I should not see item with value :value as :field in :region
   *
   * @throws \Exception
   *   If item with specific value found in the region.
   *
   * @param string $value
   *   Value of the items.
   * @param string $field
   *   Field name.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertNoRowValueVisibility($value, $field, $region) {
    if (!empty($this->minkContext->getRegion($region)->find('css', 'li'))) {
      $text = $this->minkContext->getRegion($region)->find('css', "li .value_name-$field")->getText();

      if ($text === $value) {
        throw new \Exception(sprintf('Item with value "%s" found in the region "%s" on the page "%s"', $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
      }
    }
  }

  /**
   * Asserts whether item with value is placed in position in the region.
   *
   * @Then I should see :value as :field at :position position in :region
   *
   * @throws \Exception
   *   If item with incorrect value found in the position.
   *
   * @param string $value
   *   Item value.
   * @param string $field
   *   Views field name.
   *   Example: `title`, `body`, etc.
   * @param int $position
   *   Position of the item in list.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertRowPosition($value, $field, $position, $region) {
    $elements = $this->minkContext->getRegion($region)->findAll('css', "li .value_name-$field");

    if ($elements[$position - 1]->getText() !== $value) {
      throw new \Exception(sprintf('"%s" as "%s" found in "%d" position in "%s" region on the page "%s"', $elements[$position - 1]->getText(), $field, $position, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }
  }

}
