<?php

/**
 * Class: Validate
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */

class Validate {

   /**
    * Checks to see if an input field is filled out or if the checkboxes have been selected.
    * Accepts strings, arrays and an integer for the minimum number of boxes to be checked.
    * @param mixed $input
    * @param integer $min_selection
    */
   public static function required($input, $min_selection = 1) {
      //If it's empty then return false
      if(empty($input)) {
            return false;
      //If it's checkboxes make sure the number of items checked is the minimum
      } elseif(is_array($input)) {
         
      //Otherwise just check for empty values
      } else {
         
      }
   }
   
}