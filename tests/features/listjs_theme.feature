@api
Feature: ListJs theme
  Test ListJs theme

  Background:
    Given I run drush "en -y listjs_test_theme"

  @javascript
  Scenario: Test whether filter is working for house field
    Given I am an anonymous user
    When I visit "listjs-theme-test"
    And I enter "sin" for "mykittens-are-unique-filter"
    Then I should see "1" item in "theme_list_items_wrapper"
    And I should see item with value "Singh's" as "house" in "theme_list_items_wrapper"
    And I should see item with value "Tabby" as "cat" in "theme_list_items_wrapper"
    But I should not see item with value "Binky" as "cat" in "theme_list_items_wrapper"

  @javascript
  Scenario: Test whether filter is working for cat field
    Given I am an anonymous user
    When I visit "listjs-theme-test"
    And I enter "chink" for "mykittens-are-unique-filter"
    Then I should see "1" item in "theme_list_items_wrapper"
    And I should see item with value "Paul's" as "house" in "theme_list_items_wrapper"
    And I should see item with value "Chinky" as "cat" in "theme_list_items_wrapper"
    But I should not see item with value "Kitty" as "cat" in "theme_list_items_wrapper"

  @javascript
  Scenario: Test whether sort is working
    Given I am an anonymous user
    When I visit "listjs-theme-test"
    Then I press "Sort kittens" in the "theme_list_items_wrapper"
    And I should see "4" items in "theme_list_items_wrapper"
    And I should see "Binky" as "cat" at "1" position in "theme_list_items_wrapper"
    And I should see "Tabby" as "cat" at "4" position in "theme_list_items_wrapper"

  @javascript
  Scenario: Test whether disable sort setting is working
    Given I am an anonymous user
    When I visit "listjs-theme-test"
    And I should not see the "Sort House" button
