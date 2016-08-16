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
class ListjsViewsContext extends RawDrupalContext implements SnippetAcceptingContext {

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
   * Asserts whether items with count and value found in region.
   *
   * @Then I should see :count item(s) with value :value as :field in :region
   *
   * @throws \Exception
   *   If items not found in the region.
   *   If items with specific count found in the region.
   *   If items with specific value not found in the region.
   *
   * @param int $count
   *   Number of items.
   * @param string $value
   *   Value of the items.
   * @param string $field
   *   Views field name.
   *   Example: `title`, `body`, etc.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertRowsVisibility($count, $value, $field, $region) {
    if (empty($this->minkContext->getRegion($region)->find('css', 'li'))) {
      throw new \Exception(sprintf('Items with value "%s" not found in the region "%s" on the page "%s"', $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }

    $item_count = count($this->minkContext->getRegion($region)->find('css', 'li'));
    if ($item_count != $count) {
      throw new \Exception(sprintf('"%d" items with value "%s" found in the region "%s" on the page "%s"', $item_count, $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }

    // Obtain the inner text based on field.
    if ($field == 'title') {
      $text = $this->minkContext->getRegion($region)->find('css', "li .views-field-$field")->getText();
    }
    else if ($field == 'body') {
      $text = $this->minkContext->getRegion($region)->find('css', "li .views-field-$field p")->getText();
    }

    if ($text != $value) {
      throw new \Exception(sprintf('Items with value "%s" not found in the region "%s" on the page "%s"', $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }
  }

  /**
   * Asserts whether items with count and value not found in region.
   *
   * @Then I should not see item(s) with value :value as :field in :region
   *
   * @throws \Exception
   *   If items found in the region.
   *
   * @param string $value
   *   Value of the items.
   * @param string $field
   *   Views field name.
   *   Example: `title`, `body`, etc.
   * @param string $region
   *   Behat region.
   *   @see `region_map` in `behat.yml`
   */
  public function assertNoRowsVisibility($value, $field, $region) {
    if (!empty($this->minkContext->getRegion($region)->find('css', 'li'))) {
      // Obtain the inner text based on field.
      if ($field == 'title') {
        $text = $this->minkContext->getRegion($region)->find('css', "li .views-field-$field")->getText();
      }
      else if ($field == 'body') {
        $text = $this->minkContext->getRegion($region)->find('css', "li .views-field-$field p")->getText();
      }

      if ($text == $value) {
        throw new \Exception(sprintf('Items with value "%s" found in the region "%s" on the page "%s"', $value, $region, $this->minkContext->getSession()->getCurrentUrl()));
      }
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

  /**
   * Asserts whether item with value is placed in position in the region.
   *
   * @Then I should see :value as :field at :position position in :region
   *
   * @throws \Exception
   *   If not items found.
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
    if (empty($this->minkContext->getRegion($region)->find('css', 'li'))) {
      throw new \Exception(sprintf('No items found'));
    }

    $elements = $this->minkContext->getRegion($region)->findAll('css', "li .views-field-$field");

    if ($elements[$position - 1]->getText() != $value) {
      throw new \Exception(sprintf('"%s" as "%s" found in "%d" position in "%s" region on the page "%s"', $elements[$position - 1]->getText(), $field, $position, $region, $this->minkContext->getSession()->getCurrentUrl()));
    }
  }

}
