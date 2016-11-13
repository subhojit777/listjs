@api
Feature: ListJs Views
  Test ListJs Views integration

  Background:
    Given "page" content:
      | title     | body                  |
      | Max       | The brave cat         |
      | Chloe     | The cute cat          |
      | Angel     | The holy cat          |
      | Smokey    | The wispy cat         |
      | Felix     | The lucky cat         |
      | Mimi      | The chinese cat       |
      | Mau       | The indian cat        |
      | Grumpy    | The grumpy cat        |
      | Sylvester | The Looney Tunes cat  |
      | Tom       | The Tom and Jerry cat |
    And I run drush "en -y features"
    And I run drush "en -y views"
    And I run drush "en -y views_ui"
    And I run drush "en -y listjs_test_views"
    # Reset everything before every scenario.
    And I run drush "fr -y listjs_test_views"

  Scenario: Test whether "sort text" settings for views is working
    Given I am logged in as an "administrator"
    And I am at "admin/structure/views/view/listjs_test_views/edit"
    When I click "Settings" in the "views_settings_format" region
    And I enter "Sort Title" for "style_options[filterable_fields][title][sort_text]"
    And I press the "Apply" button
    And I press the "Save" button
    And I visit "listjs-views-test"
    Then I should see the "Sort Title" button

  Scenario: Test whether "sortable" settings for views is working
    Given I am logged in as an "administrator"
    And I am at "admin/structure/views/view/listjs_test_views/edit"
    When I click "Settings" in the "views_settings_format" region
    And I uncheck the box "style_options[filterable_fields][title][sort]"
    And I press the "Apply" button
    And I press the "Save" button
    And I visit "listjs-views-test"
    Then I should not see the "Content: Title sort" button

  @javascript
  Scenario: Test whether "filterable" settings for views is working
    Given I am logged in as an "administrator"
    And I am at "admin/structure/views/view/listjs_test_views/edit"
    When I click "Settings" in the "views_settings_format" region
    And I wait for AJAX to finish
    And I uncheck the box "style_options[filterable_fields][body][filterable]"
    And I press the "Apply" button
    And I wait for AJAX to finish
    And I press the "Save" button
    And I visit "listjs-views-test"
    And I enter "indian" for "listjs_test_views-page-wrapper-filter"
    Then I should not see item with value "The indian cat" as "body" in "views_list_page_wrapper"

  @javascript
  Scenario: Test whether filter is working for title field
    Given I am an anonymous user
    When I visit "listjs-views-test"
    And I enter "Felix" for "listjs_test_views-page-wrapper-filter"
    Then I should see "1" item in "views_list_page_wrapper"
    And I should see item with value "Felix" as "title" in "views_list_page_wrapper"
    But I should not see item with value "Sylvester" as "title" in "views_list_page_wrapper"

  @javascript
  Scenario: Test whether filter is working for body field
    Given I am an anonymous user
    When I visit "listjs-views-test"
    And I enter "holy" for "listjs_test_views-page-wrapper-filter"
    Then I should see "1" item in "views_list_page_wrapper"
    And I should see item with value "The holy cat" as "body" in "views_list_page_wrapper"
    But I should not see item with value "The grumpy cat" as "body" in "views_list_page_wrapper"

  @javascript
  Scenario: Test whether sort is working
    Given I am an anonymous user
    When I visit "listjs-views-test"
    Then I press "Content: Title sort" in the "views_list_page_wrapper"
    And I should see "10" items in "views_list_page_wrapper"
    And I should see "Angel" as "title" at "1" position in "views_list_page_wrapper"
    And I should see "Tom" as "title" at "10" position in "views_list_page_wrapper"

  @javascript
  Scenario: Test whether there are no rows for non existing value
    Given I am an anonymous user
    When I visit "listjs-views-test"
    And I enter "unicat" for "listjs_test_views-page-wrapper-filter"
    Then I should see "0" items in "views_list_page_wrapper"

  @javascript
  Scenario: Test whether mutiple widgets are working in same page
    Given I am logged in as an "administrator"
    And I am at "admin/structure/block/manage/views/listjs_test_views-block_1/configure"
    And I enter "sidebar_second" for "regions[bartik]"
    And I enter "1" for "visibility"
    And I enter "listjs-views-test" for "pages"
    And I press the "Save block" button
    And I am an anonymous user
    When I visit "listjs-views-test"
    And I enter "holy" for "listjs_test_views-page-wrapper-filter"
    And I enter "brave" for "listjs_test_views-block_1-wrapper-filter"
    Then I should see "1" item in "views_list_page_wrapper"
    And I should see item with value "The holy cat" as "body" in "views_list_page_wrapper"
    And I should see "1" item in "views_list_block_wrapper"
    And I should see item with value "Max" as "title" in "views_list_block_wrapper"
