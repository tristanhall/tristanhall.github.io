<?php

namespace WebsiteManager;

abstract class WMController {
   
   /**
    * Validate an nonce field in Website Manager. Adds logging for failed nonce's.
    * @param string $action
    * @param string $failmessage
    * @param constant $method
    * @return boolean
    */
   public static function verify_nonce($action, $failmessage, $method = INPUT_POST) {
      if( !wp_verify_nonce( filter_input( $method, 'wm_nonce' ), $action ) ) {
         Log::warning( $failmessage );
         return false;
      } else {
         return true;
      }
   }
   
   /**
    * Display a view for a controller function and pass data to it.
    * @param string $template_file
    * @param array $template_data
    */
   public static function render( $template_file, $template_data = array() ) {
      if( file_exists( __DIR__.'/../views/'.$template_file.'.php' ) ) {
         extract( $template_data );
         include( __DIR__.'/../views/'.$template_file.'.php' );
      } else {
         Log::error( 'Failed to load template file: '.$template_file.'.' );
         echo '<h1>Failed to load template file: '.$template_file.'</h1>';
      }
   }
   
}