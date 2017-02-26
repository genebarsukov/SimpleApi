<?php
include 'RequestHandler.php';
include 'ParamProcessor.php';
/**
 * Created by PhpStorm.
 * User: Gene
 * Date: 2/26/2017
 * Time: 11:17 AM
 */

/**
 * This is the central endpoint of the API
 *
 * It loads all of the classes used by the API, processes the request, and returns the response
 * PHP only has the $_GET and $POST super-globals
 * For a correctly built API we also need to handle $_PUT and $_DELETE (even though this example will only use GET)
 * To keep things consistent we will just use $_REQUEST to get the data
 * And then use the method type to define our GET, POST, PUT, DELETE behavior
 */
$request = $_REQUEST;
/**
 * The uri is usually used to specify what the user wants from the API request.
 * Since in this example we specify both the word and the max_value, we will handle this with /api/Search?word=...
 */
$uri = $_SERVER['REQUEST_URI'];
/**
 * In general, it could be one of: GET, POST, PUT, DELETE
 * In this example we just use GET however
 */
$method = $_SERVER['REQUEST_METHOD'];

// instantiate our handler with the received data
$request_handler = new RequestHandler($uri, $method, $request);

// handle the request
$request_handler->handleRequest();