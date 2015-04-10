<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class CoreController {
   
   /**
    * Register Core Settings with Stashbox.
    * 
    * @access public
    * @static
    * @param array $settings
    * @return array
    */
   public static function filter_stashbox_register_settings( $settings ) {
      $settings['sb_force_https'] = 'boolval';
      $settings['sb_enckeypath'] = 'sanitize_text_field';
      return $settings;
   }
   
   /**
    * Display the Core Settings fields.
    * 
    * @access public
    * @static
    * @param string $field_html
    * @return string
    */
   public static function filter_stashbox_settings_fields( $field_html ) {
      $tdata = array(
         'force_https'  => self::force_https(),
         'key_path'     => self::get_encryption_key_path(),
         'default_path' => sprintf( '%s/', realpath( $_SERVER['DOCUMENT_ROOT'].'/../' ) )
      );
      $field_html .= Template::make( 'core/row-settings', $tdata, false );
      return $field_html;
   }
   
   /**
    * Retrieve the Force HTTPS setting value.
    * 
    * @access public
    * @static
    * @return boolean
    */
   public static function force_https() {
      $force_https = get_option( 'sb_force_https' );
      return boolval( $force_https );
   }
   
   /**
    * Retrieve the path to the encryption key.
    * 
    * @access public
    * @static
    * @return boolean
    */
   public static function get_encryption_key_path() {
      $key_path = get_option( 'sb_enckeypath' );
      return is_string( $key_path ) ? $key_path : '';
   }
   
   /**
    * Load the Core JS object and script for Stashbox.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      $js_vars = array(
         'ajax_url' => admin_url( 'admin-ajax.php' )
      );
      $js_vars = apply_filters( 'stashbox_assign_js_vars', $js_vars );
      wp_register_script( 'stashbox-core', plugins_url( 'stashbox/js/stashbox.core.js' ), array( 'jquery' ), '1.0', true );
      wp_localize_script( 'stashbox-core', 'stashbox', $js_vars );
      wp_enqueue_script( 'stashbox-core' );
   }
   
   /**
    * Redirect non-HTTPS to HTTPS for Stashbox pages.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_init() {
      if( self::force_https() && !is_ssl() ) {
         $secure_url = admin_url( str_replace( '/wp-admin', '', $_SERVER['REQUEST_URI'] ), 'https' );
         wp_redirect( $secure_url, 301 );
         exit();
      }
   }
   
   public static function action_admin_notices() {
      //Attempt to generate the encryption key if the path is set and no key is generated.
      //Display an error if it fails.
      try {
         Encrypt::generate_key();
      } catch(\Exception $e) {
         echo sprintf( __( '<div class="error"><p>%s <a href="%s">Click here</a> to set the encryption key path.</p></div>', 'th' ), $e->getMessage(), admin_url( 'admin.php?page=stashbox-settings' ) );
         return;
      }
   }
   
}