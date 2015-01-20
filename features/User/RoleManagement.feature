Feature: Role Management
  Scenario: Purge DB
    Given I remove "Role" with "name" "Behat Role"

  Scenario: Role HomePage
    Given I am on "/role"
    Then I should see "Team Management"
    And I should see "New role"
    And I should not see "Behat Role"

