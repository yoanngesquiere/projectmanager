Feature: Role Management
  Scenario: Purge DB
    Given I remove "Role" with "name" "Behat Role"
    Given I remove "Role" with "name" "Behat Role Edit"

  Scenario: Role HomePage
    Given I am on "/role"
    Then I should see "Role Management"
    And I should see "New role"
    And I should not see "Behat Role"

  Scenario: Role Creation
    Given I am on "/role"
    And I follow "New role"
    And I should not see "Behat Role"
    And I fill:
      | Name | Behat Role |
    And I press "Save"
    Then I should see "Behat Role"

  Scenario: Role Update
    Given I am on "/role"
    And I follow " Edit" in "tr" with element "td" "Behat Role"
    And I fill:
      | Name | Behat Role Edit |
    And I press "Save"
    Then I should see "Role Management"
    And I should see "New role"
    And I should see "Behat Role Edit"

  @javascript
  Scenario: Role Deletion
    Given I am on "/web/app_dev.php/role"
    And I press "Delete" in "tr" with element "td" "Behat Role Edit"
    And I wait for the modal
    And I press "Delete" in the modal
    Then I should see "Role Management"
    And I should see "New Role"
    And I should not see "Behat Role"
