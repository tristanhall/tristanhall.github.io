<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class DashboardController {
   
   /**
    * Add the Dashboard menu item.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_menu() {
      add_menu_page( __( 'Stashboard', 'th' ), __( 'Stashbox', 'th' ), 'read', 'stashbox', array( __CLASS__, 'route_dashboard' ), 'dashicons-vault', 29 );
   }
   
   /**
    * Display the Dashboard page.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function route_dashboard() {
      Template::make( 'dashboard' );
   }
   
}