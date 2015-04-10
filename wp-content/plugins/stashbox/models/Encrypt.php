<?php
namespace TH\Stashbox;

use TH\Stashbox\CoreController as Core;

use \Illuminate\Encryption\Encrypter;

class Encrypt {
   
   private static $key_file = 'stashbox_encrypt.key';
   
   /**
    * Generate a key and lock it down.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function generate_key() {
      $key_path = Core::get_encryption_key_path();
      $key_filepath = sprintf( '%s/%s', rtrim( $key_path, '/' ), self::$key_file );
      if( empty( $key_path ) ) {
         throw new \Exception( 'The path to your encryption key is not set! Your data will not be encrypted.' );
      }
      if( !is_dir( $key_path ) ) {
         throw new \Exception( 'The path to your encryption key is not a valid directory or the directory does not exist.' );
      }
      if( !file_exists( $key_filepath ) ) {
         $key = sha1( mt_rand().uniqid(true).time() );
         $fs_result = file_put_contents( $key_filepath, $key, LOCK_EX );
         if( !$fs_result ) {
            throw new \Exception( 'Failed to write <code>'.$key.'</code> to <code>'.$key_filepath.'</code>.' );
         }
         return true;
      }
   }
   
   /**
    * Retrieve the key. Return false if no key is set.
    * 
    * @access private
    * @static
    * @return string
    */
   private static function get_key() {
      $key_path = Core::get_encryption_key_path();
      $key_filepath = sprintf( '%s/%s', rtrim( $key_path, '/' ), self::$key_file );
      if( !file_exists( $key_filepath ) ) {
         return false;
      }
      $key = file_get_contents( $key_filepath );
      if( is_string( $key ) && !empty( $key ) ) {
         return $key;
      } else {
         return false;
      }
   }
   
   /**
    * Encrypt a value.
    * 
    * @access public
    * @static
    * @param string $value
    * @return string
    */
   public static function encrypt( $value ) {
      $key = self::get_key();
      if( empty( $value ) || $key === false ) {
         return $value;
      }
      $crypter = new \Illuminate\Encryption\Encrypter( $key );
      return $crypter->encrypt( $value );
   }
   
   /**
    * Decrypt a value.
    * 
    * @access public
    * @static
    * @param string $value
    * @return string
    */
   public static function decrypt( $value ) {
      $key = self::get_key();
      if( empty( $value ) || $key === false ) {
         return $value;
      }
      $crypter = new \Illuminate\Encryption\Encrypter( $key );
      return $crypter->decrypt( $value );
   }
   
}