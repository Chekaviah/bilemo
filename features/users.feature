Feature:
  In order to manage my details
  As a reseller
  I need to be able to retrieve them trough the API

  @login
  Scenario: Retrieve own details
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/users/3"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/User",
      "@id": "/api/users/3",
      "@type": "User",
      "id": 3,
      "username": "reseller-0",
      "email": "reseller0@website.net"
    }
    """
