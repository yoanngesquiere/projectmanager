Feature: Team Management

	Scenario: Purge DB
		Given I remove "Team" with "name" "Behat Team"

	Scenario: Team HomePage
		Given I am on "/team"
		Then I should see "Team Management"
		And I should see "Create a new team"
		And I should not see "Behat Team"

	Scenario: Team Creation Page
		Given I am on "/team"
		And I follow "Create a new team"
		Then I should see "Name"
		And I should see "Team creation"
		And I should see "Create"

	Scenario: Team Creation
		Given I am on "/team"
		And I follow "Create a new team"
		And I fill:
            | Name | Behat Team |
        And I press "Create"
        Then I should see "Behat Team"

    Scenario: Team Show
    	Given I am on "/team"
		And I follow "show" in "tr" with element "td" "Behat Team"
		Then I should see "Behat Team"
		And I should see "Back to the list"
		
  Scenario: User Update
        Given I am on "/team"
        And I follow "edit" in "tr" with element "td" "Behat Team"
        And I fill:
            | Name | Behat Team Edit |
        And I press "Update"
        And I follow "Back to the list"
        Then I should see "Team Management"
        And I should see "Create a new team"
        And I should see "Behat Team Edit"

    Scenario: User Deletion
        Given I am on "/team"
        And I follow "show" in "tr" with element "td" "Behat Team Edit"
        And I press "Delete"
        Then I should see "Team Management"
        And I should see "Create a new team"
        And I should not see "Behat Team"