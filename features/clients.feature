Feature:
  In order to manage my clients
  As a reseller
  I need to be able to create, update, retrieve and delete them trough the API

  @login
  Scenario: Create a client
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/clients" with body:
    """
    {
      "name": "client-test",
      "email": "client-test@website.net",
      "address": "client address"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "client-test"
    And the JSON node "email" should be equal to "client-test@website.net"
    And the JSON node "address" should be equal to "client address"
    And the JSON node "user" should be equal to "/api/users/3"

  @login
  Scenario: Retrieve a client
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/clients/101"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "client-test"
    And the JSON node "email" should be equal to "client-test@website.net"
    And the JSON node "address" should be equal to "client address"
    And the JSON node "user" should be equal to "/api/users/3"

  @login
  Scenario: Update a client
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "PUT" request to "/api/clients/101" with body:
    """
    {
      "name": "client-test",
      "email": "client-test@website.net",
      "address": "client address edited"
    }
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "client-test"
    And the JSON node "email" should be equal to "client-test@website.net"
    And the JSON node "address" should be equal to "client address edited"
    And the JSON node "user" should be equal to "/api/users/3"

  @login
  Scenario: Delete a client
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "DELETE" request to "/api/clients/101"
    Then the response status code should be 204
    And the response should be empty

  @login
  Scenario: Retrieve own clients list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/clients?user=3"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 10 elements
    And the JSON node "hydra:totalItems" should exist
