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

      // first make sure the params are valid
      $invalid_params = $this->findInvalidParams($this->params);
      if ($invalid_params) {
         $processed['errors'] = $invalid_params;
         $processed['numbers'] = array();
      }
      // if the params are valid, get and return the result
      else {
         $processed['numbers'] = $this->computeResult($this->params['word'], $this->params['max_value']);
      }

      return $processed;
   }

   /**
    * Make sure all of the required params were included and that they fit the specifications
    *
    * @param $params: Request params
    * @return array: Empty array evaluating to false if valid or array or errors explaining what is wrong if not valid
    */
   public function findInvalidParams($params) {
      $errors = array();

      // missing values
      if ((! $params['word']) || (! $params['max_value'])) {
         if (! $params['word']) {
            $errors[] = 'Word not present or is empty.';
         }
         if (! $params['max_value']) {
            $errors[] = 'Max value not present or is empty or 0.';
         }
      }
      else {
         // max value is not the correct type or is not greater than 0
         if(! is_numeric($params['max_value']) || $params['max_value'] <= 0) {
            $errors[] = 'Max value must be an integer greater than 0';
         }
         // word is not one of the fizz buzz words
         if(! in_array($params['word'], array('fizz', 'buzz', 'fizzbuzz'))) {
            $errors[] = "Word must be one of: 'fizz', 'buzz', 'fizzbuzz'";
         }
      }

      return $errors;
   }

   /**
    * Compute the main fizz buzz program result
    * @param $word: one of 'fizz', 'buzz', 'fizzbuzz'
    * @param $max_value: value to build the list of numbers from
    * @return array: results array with 'numbers' key containing the result
    */
   public function computeResult($word, $max_value) {
      $result = array();
      $values = range(1, $max_value);

      // calculate the fizz buzz.
      switch ($word) {
         case 'fizzbuzz':
            $result = $this->calculateDivisible($values, 3, 5);
            break;
         case 'fizz':
            $result = $this->calculateDivisible($values, 3, 1);
            break;
         case 'buzz':
            $result = $this->calculateDivisible($values, 3, 1);
            break;
      }

      return $result;
   }

   /**
    * Calculate divisible values by using the modulo operator
    *
    * @param $values: Array of calues
    * @param $first_divisor: Number to check each of the values against
    * @param $second_divisor: Number to check each of the values against
    * @return array: Values divisible by divisor
    */
   public function calculateDivisible($values, $first_divisor, $second_divisor=1) {
      $result = array();

      // second number is 1 by default for single checks, so second check always passes
      foreach($values as $value) {
         if (($value % $first_divisor == 0) && ($value % $second_divisor == 0)) {
            $result[] = $value;
         }
      }

      return $result;
   }
}

