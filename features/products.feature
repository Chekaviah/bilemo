Feature:
  In order to manage products
  As a reseller
  I need to be able to retrieve them trough the API.

  @fixtures @login
  Scenario: Retrieve the product list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/products"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"