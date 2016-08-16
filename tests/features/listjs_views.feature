@api
Feature: ListJs Views
	Test ListJs Views integration

	Background:
		Given "page" content:
			| title    	| body     							|
			| Max				| The brave cat					|
			| Chloe			| The cute cat 					|
			| Angel			| The holy cat 					|
			| Smokey		| The wispy cat 				|
			| Felix			| The lucky cat 				|
			| Mimi			| The chinese cat 			|
			| Mau				| The indian cat 				|
			| Grumpy		| The grumpy cat 				|
			| Sylvester	| The Looney Tunes cat 	|
			| Tom				| The Tom and Jerry cat |
		Given I run drush "en -y features"
		Given I run drush "en -y views"
		Given I run drush "en -y views_ui"
		Given I run drush "en -y listjs_test_views"

  Scenario: Test whether "sort text" settings for views is working
    Given I am logged in as an "administrator"
    Given I am at "admin/structure/views/view/listjs_test_views/edit"
		When I click "Settings" in the "views_settings_format" region
		Given I enter "Sort Title" for "style_options[filterable_fields][title][sort_text]"
		When I press the "Apply" button
		When I press the "Save" button
		When I visit "listjs-views-test"
		Then I should see the "Sort Title" button

  Scenario: Test whether "sortable" settings for views is working
		Given I run drush "fr -y listjs_test_views"
    Given I am logged in as an "administrator"
    Given I am at "admin/structure/views/view/listjs_test_views/edit"
		When I click "Settings" in the "views_settings_format" region
		And I uncheck the box "style_options[filterable_fields][title][sort]"
		When I press the "Apply" button
		When I press the "Save" button
		When I visit "listjs-views-test"
		Then I should not see the "Content: Title sort" button

  Scenario: Test whether "filterable" settings for views is working - First
		Given I run drush "fr -y listjs_test_views"
		Given I am logged in as an "administrator"
		Given I am at "admin/structure/views/view/listjs_test_views/edit"
		When I click "Settings" in the "views_settings_format" region
		And I uncheck the box "style_options[filterable_fields][body][filterable]"
		When I press the "Apply" button
		When I press the "Save" button

	@javascript
  Scenario: Test whether "filterable" settings for views is working - Second
		When I visit "listjs-views-test"
		Given I enter "indian" for "listjs_test_views-wrapper-filter"
		And I should not see item with value "The indian cat" as "body" in "views_list_wrapper"

	@javascript
  Scenario: Test whether filter is working for title field
		Given I run drush "fr -y listjs_test_views"
		Given I am an anonymous user
		When I visit "listjs-views-test"
		Given I enter "Felix" for "listjs_test_views-wrapper-filter"
		Then I should see "1" item with value "Felix" as "title" in "views_list_wrapper"
		And I should not see item with value "Sylvester" as "title" in "views_list_wrapper"

	@javascript
  Scenario: Test whether filter is working for body field
		Given I run drush "fr -y listjs_test_views"
		Given I am an anonymous user
		When I visit "listjs-views-test"
		Given I enter "holy" for "listjs_test_views-wrapper-filter"
		Then I should see "1" item with value "The holy cat" as "body" in "views_list_wrapper"
		And I should not see item with value "The grumpy cat" as "body" in "views_list_wrapper"

	@javascript
  Scenario: Test whether sort is working
		Given I run drush "fr -y listjs_test_views"
		Given I am an anonymous user
		When I visit "listjs-views-test"
		Then I press "Content: Title sort" in the "views_list_wrapper"
		Then I should see "10" items in "views_list_wrapper"
		And I should see "Angel" as "title" at "1" position in "views_list_wrapper"
		And I should see "Tom" as "title" at "10" position in "views_list_wrapper"

	@javascript
	Scenario: Test whether there are no rows for non existing value
		Given I run drush "fr -y listjs_test_views"
		Given I am an anonymous user
		When I visit "listjs-views-test"
		Given I enter "unicat" for "listjs_test_views-wrapper-filter"
		Then I should see "0" items in "views_list_wrapper"
