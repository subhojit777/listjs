@api
Feature: Listjs Facetapi
	Test Listjs Facetapi integration

	Background:
		# @TODO
		# Do the setup here.
		# Create terms
		# Enable facetapi listjs test module
		# Create page content
		# Create article content
		# Index content
		# Place search exposed form block
		# Place term facet block
		# Place type facet block
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
		Given I run drush "en -y listjs_test_views"

  Scenario: Test whether "sort text" settings for views is working
    Given I am logged in as administrator
    Given I am at x path
		When I click link "Settings" in "Format" section
		Then I wait for AJAX to complete
		And I enter "Custom Title" in sort text field
		And I save the settings
		Then I wait for AJAX to complete
		And I save the settings
		Then I am at "x" path
		And I see button with "Custom Title"

  Scenario: Test whether "sortable" settings for views is working
    Given I am logged in as administrator
    Given I am at x path
		When I click link "Settings" in "Format" section
		Then I wait for AJAX to complete
		And I "uncheck" "sortable" in "title" section
		And I save the settings
		Then I wait for AJAX to complete
		And I save the settings
		Then I am at "x" path
		And I should not see the "sortable" button

  Scenario: Test whether "filterable" settings for views is working
    Given I am logged in as administrator
    Given I am at x path
		When I click link "Settings" in "Format" section
		Then I wait for AJAX to complete
		And I "uncheck" "filterable" in "body" section
		And I save the settings
		Then I wait for AJAX to complete
		And I save the settings
		Then I am at "x" path
    When I enter y value in z field
		Then I should see only rows with y value
		And I should not see rows with y value

  Scenario: Test filtering for views for title field
		Given "feature" is in "default" state
		Given I am anonymous user
    Given I am at x path
    When I enter y value in z field
    Then I should see only rows with y value

  Scenario: Test filtering for views for body field
		Given "feature" is in "default" state
		Given I am anonymous user
    Given I am at x path
    When I enter y value in z field
    Then I should see only rows with y value

  Scenario: Test filtering for views for non existing value
		Given "feature" is in "default" state
		Given I am anonymous user
    Given I am at x path
    When I enter "unique" value in z field
    Then I should see no rows

  Scenario: Test filtering and sorting for views for non existing value
		Given "feature" is in "default" state
		Given I am anonymous user
    Given I am at x path
    When I enter "unique" value in z field
    Then I should see no rows
