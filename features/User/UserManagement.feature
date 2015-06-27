Feature: User Management
  Scenario: Purge DB
	Given I remove "User" with "first_name" "Behat First Name"
    Given I remove "User" with "first_name" "Behat First Name Edit"

  Scenario: User HomePage
	Given I am on "/user"
	Then I should see "Team Management"
	And I should see "New user"
	And I should not see "Behat First Name"
	And I should not see "Behat Last Name"

  Scenario: User Creation Page
	Given I am on "/user"
	And I follow "New user"
	Then I should see "First name"
	And I should see "Last name"
	And I should see "Save"

  Scenario: User Creation
	Given I am on "/user"
	And I follow "New user"
	And I fill:
      | First name | Behat First Name  |
      | Last name  | Behat Last Name   |
      | Username   | BehatUser         |
      | Password   | BehatPassword     |
      | Email      | bahat@example.org |
	And I press "Save"
	Then I should see "Behat First Name"
	And I should see "Behat Last Name"
	And I should see "New user"

  Scenario: User Update
   	Given I am on "/user"
   	And I follow " Edit" in "tr" with element "td" "Behat First Name"
   	And I fill:
   	  | First name | Behat First Name Edit  |
   	  | Last name  | Behat Last Name Edit   |
   	And I press "Save"
   	Then I should see "Behat First Name Edit"
   	And I should see "Behat Last Name Edit"
   	And I should see "New user"

  @javascript
  Scenario: User Delete:
   	Given I am on "/web/app_dev.php/user"
   	And I press "Delete" in "tr" with element "td" "Behat First Name Edit"
    And I wait for the modal
    And I press "Delete" in the modal
   	Then I should see "User list"
   	And I should see "New user"
   	And I should not see "Behat First Name Edit"
   	And I should not see "Behat Last Name Edit"
