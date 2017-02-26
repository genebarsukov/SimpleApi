<?php
/**
 * Created by PhpStorm.
 * User: Gene
 * Date: 2/26/2017
 * Time: 11:10 AM
 */

/**
 * Class RequestHandler
 *
 * This is a general handler
 * Logic to process all of the common API methods is included
 * only get is used in this example
 */
class RequestHandler {
   private $uri;
   private $method;
   private $request;
   private $format;

   /**
    * RequestHandler constructor.
    *
    * @param $uri: The endpoint path - specifies what the user wants
    * @param $method: The request method type: one of: GET, POST, PUT, DELETE
    * @param $request: Contains the request parameters
    */
   public function __construct($uri, $method, $request) {
      $this->uri = $uri;
      $this->method = $method;
      $this->request = $request;
   }

   /**
    * Handles the request using data specified in the constructor
    *
    * Figures out what the user wants and performs the appropriate action
    */
   public function handleRequest() {
      $status = 'ok';

      // try to get the requested data
      try {
         switch ($this->method) {
            case 'GET':
               $data = $this->doGet($this->request, $this->uri);
               break;
            case 'POST':
               $data = $this->doPost($this->request, $this->uri);
               break;
            case 'PUT':
               $data = $this->doPut($this->request, $this->uri);
               break;
            case 'DELETE':
               $data = $this->doDelete($this->request, $this->uri);
               break;
         }
      } catch (Exception $e) {
         $status = 'server_error';
         $data = $e->getMessage();
      }

      // build the final response
      $response = $this->buildResponse($data, $status, $this->format);

      // set the response headers
      $this->setResponseHeader($this->format, $status);

      // output the response
      echo $response;
   }

   /**
    * Build the final response based on output data and the status
    *
    * @param $data: The requested content
    * @param $status: The response status: ok, error, or server_error
    * @param string $format: The format to encode the response in
    * @return array|string: The encoded response
    */
   private function buildResponse($data, $status, $format='json') {
      if (! $data or $data['error_msg']) {
         $status = 'error';
      }
      if ($format == 'text') {
         $response = $data;
      }
      else {
         $response = array(
            'status' => $status,
            'output' => $data);
      }

      if ($format == 'json') {
         $response = json_encode($response);
      }
      return $response;
   }

   /**
    * GET
    *
    * @param $request: Request params
    * @param $uri: Request URI
    * @return string: Returned response
    */
   private function doGet($request, $uri) {
      $response = array();

      // split the uri up to see what the user wants
      // in this example a 'search' option will denote that we want to process this request
      $uri_options = array_filter(explode('/', $uri), create_function('$arg', 'return $arg;'));

      // returns help text
      if (in_array('about', $uri_options)) {
         $this->format = 'text';
         $response = file_get_contents('README.txt');
      }
      // returns main application data
      else if (in_array('search', $uri_options)) {
         $this->format = 'json';
         $param_processor = new ParamProcessor($request);
         $response = $param_processor->processParams();
      }

      return $response;
   }
   /**
    * POST
    *
    * @param $request: Request params
    * @param $uri: Request URI
    * @return string: Returned response
    */
   private function doPost($request, $uri) {
      $response = array();
      return $response;
   }
   /**
    * PUT
    *
    * @param $request: Request params
    * @param $uri: Request URI
    * @return string: Returned response
    */
   private function doPut($request, $uri) {
      $response = array();
      return $response;
   }
   /**
    * DELETE
    *
    * @param $request: Request params
    * @param $uri: Request URI
    * @return string: Returned response
    */
   private function doDelete($request, $uri) {
      $response = array();
      return $response;
   }

   /**
    * Sets the response header based on the response type and response status
    *
    * @param string $format: Currently only JSON is used, but could also be XML or HTML
    * @param string $status: Currently only 'ok': 200 or 'error': 400.
    */
   private function setResponseHeader($format='JSON', $status='ok') {
      $status_codes = array(
         'ok' => 200,
         'error' => 400,
         'server_error' => 500
      );
      $format = strtoupper($format);

      header("Format: $format");
      header("HTTP status: $status_codes[$status]");
   }
}