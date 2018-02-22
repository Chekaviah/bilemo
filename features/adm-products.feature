Feature:
  In order to manage products
  As an administrator
  I need to be able to retrieve, create, update and delete them trough the API

  @loginAdmin
  Scenario: Retrieve products list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/products"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "hydra:member" should exist
    And the JSON node "hydra:member" should have 20 elements
    And the JSON node "hydra:totalItems" should exist
    And the JSON node "hydra:view" should exist

  @loginAdmin
  Scenario: Create a product
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/products" with body:
    """
    {
      "name": "product-test",
      "description": "product description",
      "price": "100.00"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "product-test"
    And the JSON node "description" should be equal to "product description"
    And the JSON node "price" should be equal to "100.00"

  @loginAdmin
  Scenario: Retrieve a product
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/products/201"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "product-test"
    And the JSON node "description" should be equal to "product description"
    And the JSON node "price" should be equal to "100.00"

  @loginAdmin
  Scenario: Update a product
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "PUT" request to "/api/products/201" with body:
    """
    {
      "name": "product-test",
      "description": "product description edited",
      "price": "99.00"
    }
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "name" should be equal to "product-test"
    And the JSON node "description" should be equal to "product description edited"
    And the JSON node "price" should be equal to "99.00"

  @loginAdmin
  Scenario: Delete a product
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "DELETE" request to "/api/products/201"
    Then the response status code should be 204
    And the response should be empty