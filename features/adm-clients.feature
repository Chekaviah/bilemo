Feature:
  In order to manage clients
  As an administrator
  I need to be able to create, update, retrieve and delete them trough the API

  @loginAdmin
  Scenario: Retrieve a client
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/clients/11"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "client-2"
    And the JSON node "email" should be equal to "client2@website.net"
    And the JSON node "address" should be equal to "2 rue de l'infini"
    And the JSON node "user" should be equal to "/api/users/4"

  @loginAdmin
  Scenario: Retrieve clients list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/clients"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 20 elements
    And the JSON node "hydra:totalItems" should exist
    And the JSON node "hydra:view" should exist

  @loginAdmin
  Scenario: Retrieve clients list for a reseller
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/clients?user=4"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 10 elements
    And the JSON node "hydra:totalItems" should exist
    And the JSON node "hydra:view" should exist
