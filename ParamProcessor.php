<?php
/**
 * Created by PhpStorm.
 * User: Gene
 * Date: 2/26/2017
 * Time: 1:26 PM
 */

/**
 * Class ArgumentProcessor
 * 
 * This processes the parameters in the URL sting, everything after the '?' and contained in the $_REQUEST super global
 * Makes sure the required parameters exist
 * Make sure they fit the criteria specified
 * Performs processing logic to get the response
 */
class ParamProcessor {
   private $params;

   /**
    * ParamProcessor constructor.
    * 
    * Sets the params to process
    * @param $params: Params retrieved from the request
    */
   public function __construct($params) {
      $this->params = $params;
   }

   /**
    * Processes the prams passed in
    * 
    * Makes sure the required parameters exist
    * Make sure they fit the criteria specified
    * Performs processing logic to get the response
    * @return array: Returns either an array of processed params or an empty array if something went wrong
    */
   public function processParams() {
      $processed = array();

      $invalid_params = $this->findInvalidParams();

      if ($invalid_params) {
         $processed['error_msg'] = $invalid_params;
      }
      else {
         $processed['numbers'] =
      }
      return $processed;
   }

   /**
    * @param $params
    * @return bool
    */
   public function findInvalidParams($params) {
      return false;

   }

   public function computeResult($word, $max_value) {
      $result = array();

      return $result;
   }
}