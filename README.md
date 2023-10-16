Pandascrow SDK PHP

Description:
A PHP SDK to connect, send and recieve data from the pandascrow API.
 
This project features:

multiple requests to an endpoint.

Good routing system for endpoints.

Requirement:

Install Rakit\Validation package from composer.

User Guide:
This is a step by step guide on how to use this project.

i. Your configuration file is located at Pandascrow\App\config.php.

   Fill in your app details.

   
   ![Screenshot (70)](https://github.com/bofa26/pandascrow-php-sdk/assets/127630429/caf8f16e-9306-409b-9acd-2997b0d5110b)

ii. GET Requests:

    The Scrow->get() method handles GET requests. It takes an endpoint and an array request body as its parameters.
    
    Picture below is a GET request to the /bank/list/ endpoint to fetch a list of all the banks in Nigeria.    
   
   ![Screenshot (79)](https://github.com/bofa26/pandascrow-php-sdk/assets/127630429/0c1b9898-3275-4d53-9135-35374ebf0e0d)



iii. POST Requests:

      The Scrow->post() method handles POST Requests. It takes an endpoint and an array request body as its parameters.

       


iv. Batch Requests:
    
    This project supports batch request to an endpoint. The example below shows how to handle a batch request.



    Note: The response is returned as an array of keys and values. Where the id of each request sent in the batch is the key of the response.