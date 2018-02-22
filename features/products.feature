Feature:
  In order to manage products
  As a reseller
  I need to be able to retrieve them trough the API

  @login
  Scenario: Retrieve the product list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/products"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 20 elements
    And the JSON node "hydra:totalItems" should exist
    And the JSON node "hydra:view" should exist

  @login
  Scenario: Retrieve a product details
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/products/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "id" should exist
    And the JSON node "name" should exist
    And the JSON node "description" should exist
    And the JSON node "price" should exist
