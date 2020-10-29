Feature: Test Ingredient JSON API endpoint GET
    
    Scenario: Je peux récuperer un ingrédient 
        Given the request body is:
        """
        {
            "name": "Ahtanum",
            "unitFactor": 1000,
            "comment": "Un houblon aromatique",
            "unit": "kg",
            "childName": "other",
            "type": "rien pour le moment"
        }
        """
        When I request "/api/ingredient" using HTTP POST
        Then the response code is 201
        And I save the "id"
        When I request "/api/ingredient/" with "id" using HTTP GET
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "id": "@regExp(/[0-9]+/)",
            "name": "Ahtanum",
            "comment": "Un houblon aromatique",
            "unit": "kg",
            "unitFactor": 1000,
            "childName": "other",
            "type": "rien pour le moment",
            "ingredientStocks": []
        }
        """
        And the response body has 8 fields
        Then I request "/api/ingredients" using HTTP GET
        Then the response code is 200
        And the response body contains JSON:
        """
        [{
            "id": "@regExp(/[0-9]+/)",
            "name": "Ahtanum",
            "comment": "Un houblon aromatique",
            "unit": "kg",
            "unitFactor": 1000,
            "childName": "other",
            "type": "rien pour le moment",
            "ingredientStocks": []
        }]
        """
        And the response body is a JSON array of length 1

    Scenario: Je peux récupérer un ingrédient créer à moitié
        Given the request body is:
        """
        {
            "name": "Admiral",
            "unitFactor": 1000,
            "childName": "other",
            "type": "un type"
        }
        """
        When I request "/api/ingredient" using HTTP POST
        Then the response code is 201
        And I save the "id"
        When I request "/api/ingredient/" with "id" using HTTP GET
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "id": "@regExp(/[0-9]+/)",
            "name": "Admiral",
            "unitFactor": 1000,
            "childName": "other",
            "type": "un type",
            "ingredientStocks": []
        }
        """
        And the response body has 6 fields
        Then the request body is:
        """
        {
            "name": "Ahtanum",
            "unitFactor": 1000,
            "comment": "Un houblon aromatique",
            "unit": "kg",
            "childName": "other",
            "type": "rien pour le moment"
        }
        """
        When I request "/api/ingredient" using HTTP POST
        Then I request "/api/ingredients" using HTTP GET
        Then the response code is 200
        And the response body is a JSON array of length 2
        And the response body contains JSON:
        """
        [
        {
            "id": "@regExp(/[0-9]+/)",
            "name": "Ahtanum",
            "unitFactor": 1000,
            "comment": "Un houblon aromatique",
            "unit": "kg",
            "childName": "other",
            "type": "rien pour le moment",
            "ingredientStocks": []
        }, {
            "id": "@regExp(/[0-9]+/)",
            "name": "Admiral",
            "unitFactor": 1000,
            "childName": "other",
            "type": "un type",
            "ingredientStocks": []
        }]
        """
