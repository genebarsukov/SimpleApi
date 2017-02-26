***********************************************************
* README                                                  *
***********************************************************
The usage has been slightly modified a bit from the original specs
The /search option must be included in the URI
This is just slightly more inline with the best practices for building RESTful API's

'/search' must be included in the URI for the API to get the correct response

*** Usages ***

To view the API Documentation:
http://codewrencher.com/api/about

To use the API
http://codewrencher.com/api/search?word=fizzbuzz&max_value=30

*** Project Structure ***

- .htaccess file directs all /api* URI's to the api.php endpoint
- api.php is the main endpoint
- RequestHandler is the main class that decides what to do with all request types
- ParamProcessor is responsible for processing the GET request parameters for this example

*** Application Workflow ***

1. .htaccess routes all requests to api.php
2. api.php instantiated RequestHandler with the uri, request, and api methods variables
3. RequestHandler processes the request and instantiates ParamProcessor to process a GET request
4. ParamProcessor checks for valid parameters, calculates the result,a nd passes it to RequestHandler
5. RequestHandler returns the response with the results and appropriate headers