Feature: User Management
	Scenario: Purge DB
		Given I remove "User" with "first_name" "Behat First Name"

	Scenario: User HomePage
		Given I am on "/user"
		Then I should see "Team Management"
		And I should see "Create a new person"
		And I should not see "Behat First Name"
		And I should not see "Behat Last Name"

	Scenario: User Creation Page
		Given I am on "/user"
		And I follow "Create a new person"
		Then I should see "First name"
		And I should see "Last name"
		And I should see "Save"

	Scenario: User Creation
		Given I am on "/user"
		And I follow "Create a new person"
		And I fill:
            | First name | Behat First Name |
            | Last name | Behat Last Name |
		And I press "Save"
		Then I should see "Behat First Name"
		And I should see "Behat Last Name"