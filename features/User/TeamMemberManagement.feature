Feature: Team Members Management

	Scenario: Purge DB
		Given I remove "Team" with "name" "Behat Team For Team Members"
		Given I remove "User" with "first_name" "Behat Member 1 For Team Members"
		Given I remove "User" with "first_name" "Behat Member 2 For Team Members"

	Scenario: Team HomePage
		Given I am on "/team"
		Then I should see "Team Management"
		And I should see "New team"
		And I should not see "Behat Team For Team Members"

	Scenario: User HomePage
		Given I am on "/user"
		Then I should see "Team Management"
		And I should see "New user"
		And I should not see "Behat Member 1 For Team Members"
		And I should not see "Behat Member 2 For Team Members"

	Scenario: Team And User Creation
		Given I am on "/team"
		And I follow "New team"
		And I fill:
            | Name | Behat Team For Team Members |
        And I press "Create"
        And I am on "/user"
        And I follow "New user"
		And I fill:
            | First name | Behat Member 1 For Team Members |
            | Last name | Behat Member 1 For Team Members Name |
		And I press "Save"
		And I am on "/user"
        And I follow "New user"
		And I fill:
            | First name | Behat Member 2 For Team Members |
            | Last name | Behat Member 2 For Team Members Name |
		And I press "Save"
		
	Scenario: Purge DB for other scenarios
		Given I remove "Team" with "name" "Behat Team For Team Members"
		Given I remove "User" with "first_name" "Behat Member 1 For Team Members"
		Given I remove "User" with "first_name" "Behat Member 2 For Team Members"