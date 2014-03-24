<?php

class Log {
   
   /**
    * 
    * @param string $message
    * @return boolean
    */
   public static function debug( $message ) {
      $current_user = wp_get_current_user();
      $log_message = 'DEBUG - '.date('Y-m-d H:i:s').' - '.$current_user->user_login.' - '.$message."\n";
      $wrote = self::write( $log_message );
      if( $wrote ) {
         return true;
      } else {
         return false;
      }
   }
   
   /**
    * 
    * @param string $message
    * @return boolean
    */
   public static function error( $message ) {
      $current_user = wp_get_current_user();
      $log_message = 'ERRPR - '.date('Y-m-d H:i:s').' - '.$current_user->user_login.' - '.$message."\n";
      $wrote = self::write( $log_message );
      if( $wrote ) {
         return true;
      } else {
         return false;
      }
   }
   
   /**
    * 
    * @param string $message
    * @return boolean
    */
   public static function info( $message ) {
      $current_user = wp_get_current_user();
      $log_message = 'INFO - '.date('Y-m-d H:i:s').' - '.$current_user->user_login.' - '.$message."\n";
      $wrote = self::write( $log_message );
      if( $wrote ) {
         return true;
      } else {
         return false;
      }
   }
   
   /**
    * 
    * @param string $message
    * @return boolean
    */
   public static function warning( $message ) {
      $current_user = wp_get_current_user();
      $log_message = 'WARNING - '.date('Y-m-d H:i:s').' - '.$current_user->user_login.' - '.$message."\n";
      $wrote = self::write( $log_message );
      if( $wrote ) {
         return true;
      } else {
         return false;
      }
   }
   
   /**
    * 
    * @param string $message
    * @return void
    */
   private static function write( $message ) {
      //Do we have logging enabled?
      if( !defined('LOGGING') || LOGGING === false ) {
         return;
      }
      //First check for the logs folder.
      if( !file_exists( __DIR__.'/../logs' ) ) {
         exit('Logs folder does not exist');
      }
      $year = date('Y');
      $month = date('m');
      $date = date('d');
      //Create the y/m/d directory structure
      if( !file_exists( __DIR__.'/../logs/'.$year ) ) {
         mkdir( __DIR__.'/../logs/'.$year, 0777 );
      }
      if( !file_exists( __DIR__.'/../logs/'.$year.'/'.$month ) ) {
         mkdir( __DIR__.'/../logs/'.$year.'/'.$month, 0777 );
      }
      $filename = __DIR__.'/../logs/'.$year.'/'.$month.'/'.$date.'.txt';
      if ( file_exists( $filename ) ) {
         $fh = fopen( $filename, 'a' );
         fwrite( $fh, $message );
      } else {
         $fh = fopen( $filename, 'w' );
         fwrite( $fh, $message );
      }
      fclose( $fh );
   }
   
   /**
    * 
    * @param integer $year
    * @param integer $month
    * @param integer $date
    * @param boolean $nl2br
    * @return string
    */
   public static function read( $year, $month, $date, $nl2br = true ) {
      $filename = __DIR__.'/../logs/'.$year.'/'.$month.'/'.$date.'.txt';
      if( file_exists( $filename ) ) {
         $contents = file_get_contents( $filename );
         if( $nl2br === true ) {
            $contents = str_replace("\n", '<br>', $contents);
         }
      } else {
         $contents = "No log file found.";
      }
      return $contents;
   }
   
}