<?php

//Set the maximum 
define( 'STASHBOX_MAX_PORT_NUMBER', 65535 );

if( !function_exists( 'boolval' ) ) {
   /**
    * Drop-in replacement for boolval() for systems that don't yet support it.
    * 
    * @access public
    * @param mixed $value
    * @return boolean
    */
   function boolval( $value ) {
      return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
   }
}

/**
 * Helper function for generating US State dropdown menus.
 * 
 * @access public
 * @param string $name
 * @param string $id (default: '')
 * @param string $selected (default: '')
 * @return string
 */
function stashbox_state_dropdown( $name, $id = '', $selected = '' ) {
   $states = array(
      'AL' => 'Alabama',
      'AK' => 'Alaska',
      'AZ' => 'Arizona',
      'AR' => 'Arkansas',
      'CA' => 'California',
      'CO' => 'Colorado',
      'CT' => 'Connecticut',
      'DE' => 'Delaware',
      'DC' => 'District of Columbia',
      'FL' => 'Florida',
      'GA' => 'Georgia',
      'HI' => 'Hawaii',
      'ID' => 'Idaho',
      'IL' => 'Illinois',
      'IN' => 'Indiana',
      'IA' => 'Iowa',
      'KS' => 'Kansas',
      'KY' => 'Kentucky',
      'LA' => 'Louisiana',
      'ME' => 'Maine',
      'MD' => 'Maryland',
      'MA' => 'Massachusetts',
      'MI' => 'Michigan',
      'MN' => 'Minnesota',
      'MS' => 'Mississippi',
      'MO' => 'Missouri',
      'MT' => 'Montana',
      'NE' => 'Nebraska',
      'NV' => 'Nevada',
      'NH' => 'New Hampshire',
      'NJ' => 'New Jersey',
      'NM' => 'New Mexico',
      'NY' => 'New York',
      'NC' => 'North Carolina',
      'ND' => 'North Dakota',
      'OH' => 'Ohio',
      'OK' => 'Oklahoma',
      'OR' => 'Oregon',
      'PA' => 'Pennsylvania',
      'RI' => 'Rhode Island',
      'SC' => 'South Carolina',
      'SD' => 'South Dakota',
      'TN' => 'Tennessee',
      'TX' => 'Texas',
      'UT' => 'Utah',
      'VT' => 'Vermont',
      'VA' => 'Virginia',
      'WA' => 'Washington',
      'WV' => 'West Virginia',
      'WI' => 'Wisconsin',
      'WY' => 'Wyoming',
   );

   if( empty( $id ) ) {
      $id = $name;
   }
   $html = '<select name="'.$name.'" id="'.$id.'">';
   foreach( $states as $val => $state ) {
      $html .= '<option value="'.$val.'"';
      $html .= ( $val === $selected ) ? ' selected="selected"' : '';
      $html .= '>'.$state.'</option>';
   }
   $html .= '</select>';
   return $html;
}