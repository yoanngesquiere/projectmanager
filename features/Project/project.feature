Feature: Project Management

  Scenario: Purge DB
    Given I remove "Project" with "name" "Behat Project"
    Given I remove "Project" with "name" "Behat Project Edit"

  Scenario: Project HomePage
    Given I am on "/project"
    Then I should see "Team Management"
    And I should see "New project"
    And I should not see "Behat Project"

  Scenario: Project Creation
    Given I am on "/project"
    Then I should see "Team Management"
    And I follow "New project"
    And I should not see "Behat Project"
    And I fill:
      | Name | Behat Project |
    And I press "Save"
    Then I should see "Behat Project"

  Scenario: Project Update
    Given I am on "/project"
    And I follow " Edit" in "tr" with element "td" "Behat Project"
    And I fill:
      | Name | Behat Project Edit |
    And I press "Save"
    Then I should see "Team Management"
    And I should see "New project"
    And I should see "Behat Project Edit"

  @javascript
  Scenario: Project Deletion
    Given I am on "/project"
    And I press "Delete" in "tr" with element "td" "Behat Project Edit"
    And I wait for the modal
    And I press "Delete" in the modal
    Then I should see "Team Management"
    And I should see "New project"
    And I should not see "Behat Project"
