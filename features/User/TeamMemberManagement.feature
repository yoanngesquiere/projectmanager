Feature: Team Members Management

  Scenario: Purge DB
	Given I remove "Team" with "name" "Behat Team For Team Members"
	Given I remove "User" with "first_name" "Behat Member 1 For Team Members"
	Given I remove "User" with "first_name" "Behat Member 2 For Team Members"
    Given I remove "Role" with "name" "Behat Role"

  Scenario: Team And User Creation
    Given I am on "/role"
    And I follow "New role"
    And I should not see "Behat Role"
    And I fill:
      | Name | Behat Role |
    And I press "Save"
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
    And I am on "/team"
    And I follow "New team"
    And I fill:
      | Name | Behat Team For Team Members |
    And I press "Create"

  Scenario: Purge DB for other scenarios
	Given I remove "Team" with "name" "Behat Team For Team Members"
	Given I remove "User" with "first_name" "Behat Member 1 For Team Members"
	Given I remove "User" with "first_name" "Behat Member 2 For Team Members"
    Given I remove "Role" with "name" "Behat Role"
