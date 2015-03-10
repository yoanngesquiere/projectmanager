Feature: Team Management

  Scenario: Purge DB
	Given I remove "Team" with "name" "Behat Team"
  	Given I remove "Team" with "name" "Behat Team Edit"

  Scenario: Team HomePage
	Given I am on "/team"
	Then I should see "Team Management"
	And I should see "New team"
	And I should not see "Behat Team"

  Scenario: Team Creation Page
	Given I am on "/team"
	And I follow "New team"
	Then I should see "Name"
	And I should see "Team creation"
	And I should see "Create"

  Scenario: Team Creation
	Given I am on "/team"
	And I follow "New team"
	And I fill:
           | Name | Behat Team |
    And I press "Create"
    Then I should see "Behat Team"

  Scenario: Team Update
    Given I am on "/team"
    And I follow "Edit" in "tr" with element "td" "Behat Team"
    And I fill:
        | Name | Behat Team Edit |
    And I press "Update"
    And I follow "Back to the list"
    Then I should see "Team Management"
    And I should see "New team"
    And I should see "Behat Team Edit"

  @javascript
  Scenario: Team Deletion
    Given I am on "/team"
    And I press "Delete" in "tr" with element "td" "Behat Team Edit"
    And I wait for the modal
    And I press "Delete" in the modal
    Then I should see "Team Management"
    And I should see "New team"
    And I should not see "Behat Team"