<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class SettingsController {
   
   /**
    * Register Stashbox settings.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_init() {
      $settings = array();
      $settings = apply_filters( 'stashbox_register_settings', $settings );
      foreach( $settings as $key => $filter ) {
         //Force prefixing of settings with 'sb'
         if( substr( $key, 0, 3 ) !== 'sb_' ) {
            $key = 'sb_'.$key;
         }
         register_setting( 'stashbox', $key, $filter );
      }
   }
   
   /**
    * Add the Settings submenu page.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_menu() {
      add_submenu_page( 'stashbox', __( 'Stashbox Settings', 'th' ), __( 'Settings', 'th' ), 'manage_options', 'stashbox-settings', array( __CLASS__, 'route_settings' ) );
   }
   
   /**
    * Aggregates the settings fields and displays the Settings page.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function route_settings() {
      $settings_fields = '';
      $settings_fields = apply_filters( 'stashbox_settings_fields', $settings_fields );
      $tdata = array(
         'settings_updated' => filter_input( INPUT_GET, 'settings-updated', FILTER_VALIDATE_BOOLEAN ),
         'settings_fields'  => $settings_fields
      );
      Template::make( 'settings/form-settings', $tdata );
   }
   
}