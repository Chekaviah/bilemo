Feature:
  In order to manage users
  As an administrator
  I need to be able to retrieve, create, update and delete them trough the API

  @loginAdmin
  Scenario: Retrieve users list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/users"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 12 elements
    And the JSON node "hydra:totalItems" should exist

  @loginAdmin
  Scenario: Create a user
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/users" with body:
    """
    {
      "username": "user-test",
      "email": "user-test@website.net",
      "password": "user"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "username" should be equal to "user-test"
    And the JSON node "email" should be equal to "user-test@website.net"

  @loginAdmin
  Scenario: Retrieve a user
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/users/13"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "username" should be equal to "user-test"
    And the JSON node "email" should be equal to "user-test@website.net"

  @loginAdmin
  Scenario: Update a user
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "PUT" request to "/api/users/13" with body:
    """
    {
      "username": "user-test",
      "email": "user-test-edited@website.net"
    }
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "username" should be equal to "user-test"
    And the JSON node "email" should be equal to "user-test-edited@website.net"

  @loginAdmin
  Scenario: Delete a client
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "DELETE" request to "/api/users/13"
    Then the response status code should be 204
    And the response should be empty