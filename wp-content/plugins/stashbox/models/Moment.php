<?php
namespace TH\Stashbox;

class Moment extends \Moment\Moment {
   
   /**
    * Modifier of the Moment constructor function to automatically use WordPress's timezone.
    * 
    * @access public
    * @param string $time (default: '')
    * @param string $tz (default: '')
    * @return void
    */
   public function __construct( $dateTime = 'now', $timezone = null ) {
      self::setLocale( get_locale() );
      if( empty( $timezone ) ) {
         $timezone = get_option( 'timezone_string' );
         if( empty( $timezone ) ) {
            $timezone = 'UTC';
         }
         parent::__construct( $dateTime, $timezone );
         $this->setTimezone( $timezone );
      } else {
         parent::__construct( $dateTime, $timezone );
      }
   }
   
}