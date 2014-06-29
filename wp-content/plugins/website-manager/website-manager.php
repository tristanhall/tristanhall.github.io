<?php
/**
 * Plugin Name: Website Manager
 * Plugin URI: http://tristanhall.com
 * Description: Keeps track of websites, MySQL credentials, FTP credentials, etc. complete with 128-bit encryption.
 * Author: Tristan Hall
 * Version: 1.0
 * License: Commercial
 */

namespace WebsiteManager;

//ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );

define( 'LOGGING', true );

require_once( __DIR__.'/helpers/string.php' );
require_once( __DIR__.'/models/wmmodel.php' );
require_once( __DIR__.'/models/log.php' );
require_once( __DIR__.'/models/website.php' );
require_once( __DIR__.'/models/ftp_credential.php' );
require_once( __DIR__.'/models/db_credential.php' );
require_once( __DIR__.'/models/note.php' );
require_once( __DIR__.'/controllers/wmcontroller.php' );
require_once( __DIR__.'/controllers/websites.php' );
require_once( __DIR__.'/controllers/db_credentials.php' );
require_once( __DIR__.'/controllers/ftp_credentials.php' );
require_once( __DIR__.'/controllers/notes.php' );
require_once( __DIR__.'/controllers/log.php' );

class WebsiteManager {
   
   const db_version = 1.0;
   
   /**
    * Install or upgrade the databse
    * @global object $wpdb
    */
   public static function install() {
      global $wpdb;
      $installed_version = get_option( '_wm_db_version_' );
      $sql = array();
      //Set the website's permanent key for determining the master password.
      //Website table
      $sql['wm_websites'] = "CREATE TABLE ".$wpdb->prefix."wm_websites (
         id varchar(50) NOT NULL,
         domain_name varbinary(255) NOT NULL,
         registrar varbinary(255) NOT NULL,
         expiration_date date NOT NULL,
         login_url varbinary(255) NOT NULL,
         username varbinary(255) NOT NULL,
         password varbinary(255) NOT NULL,
         last_modified timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         UNIQUE KEY  (id)
      );";
      //FTP logins table
      $sql['wm_ftp_credentials'] = "CREATE TABLE ".$wpdb->prefix."wm_ftp_credentials (
         id varchar(50) NOT NULL,
         website_id varchar(50) NOT NULL,
         host varbinary(255) NOT NULL,
         username varbinary(255) NOT NULL,
         password varbinary(255) NOT NULL,
         type varbinary(255) NOT NULL,
         last_modified timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         UNIQUE KEY  (id)
      );";
      //Database logins table
      $sql['wm_db_credentials'] = "CREATE TABLE ".$wpdb->prefix."wm_db_credentials (
         id varchar(50) NOT NULL,
         website_id varchar(50) NOT NULL,
         host varbinary(255) NOT NULL,
         db_name varbinary(255) NOT NULL,
         username varbinary(255) NOT NULL,
         password varbinary(255) NOT NULL,
         phpmyadmin_url varbinary(255) NOT NULL,
         last_modified timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         UNIQUE KEY  (id)
      );";
      //Table for notes
      $sql['wm_notes'] = "CREATE TABLE ".$wpdb->prefix."wm_notes (
         id varchar(50) NOT NULL,
         website_id varchar(50) NOT NULL,
         author_id integer(11) NOT NULL,
         note_contents blob NOT NULL,
         last_modified timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         UNIQUE KEY  (id)
      );";
      //Only do this if the database versions don't match
      if( self::db_version != (int) $installed_version ) {
         //Compile the queries
         $queries = implode( '', $sql );
         require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
         //Let 'em loose
         foreach( $sql as $query ) {
            dbDelta( $query );
         }
         update_option( '_wm_db_version_', 1.0 );
         Log::info( 'Database updated to v'.self::db_version.'.' );
      }
   }

   /**
    * Setup the admin menus
    */
   public static function register_menu_pages() {
       add_menu_page( 'TH Admin', 'TH Admin', 'manage_options', 'wm-dashboard', array( 'WebsiteManager\WebsiteManager', 'init' ), 'dashicons-lightbulb', 3 );
      add_submenu_page( 'wm-dashboard', 'Websites', 'Websites', 'manage_options', 'wm-websites', array( 'WebsiteManager\WebsiteManager', 'websites' ) );
      add_submenu_page( 'wm-dashboard', 'FTP Credentials', 'FTP Credentials', 'manage_options', 'wm-ftp-credentials', array( 'WebsiteManager\WebsiteManager', 'ftp_credentials' ) );
      add_submenu_page( 'wm-dashboard', 'DB Credentials', 'DB Credentials', 'manage_options', 'wm-db-credentials', array( 'WebsiteManager\WebsiteManager', 'db_credentials' ) );
      add_submenu_page( 'wm-dashboard', 'Security Log', 'Security Log', 'manage_options', 'wm-log', array( 'WebsiteManager\WebsiteManager', 'log' ) );
   }
   
   /**
    * Register and queue up the styles and scripts
    */
   public static function load_admin_assets() {
      wp_register_style( 'wm_styles', plugins_url( 'website-manager/css/website_manager.css' ), false, '1.0' );
      wp_enqueue_style( 'wm_styles' );
      wp_register_script( 'wm_functions', plugins_url( 'website-manager/js/jquery.functions.js' ), false, '1.0' );
      wp_register_script( 'wm_plugins', plugins_url( 'website-manager/js/jquery.plugins.js' ), false, '1.0' );
      wp_enqueue_script( 'wm_plugins' );
      wp_enqueue_script( 'wm_scripts', plugins_url( 'website-manager/js/jquery.functions.js' ), array( 'wm_plugins' ) );
   }
      
   /**
    * Dashboard page handler
    */
   public static function init() {
      Log::info( 'Accessed the dashboard.' );
      include( __DIR__.'/views/dashboard.php' );
   }
   
   /**
    * Website page handler
    */
   public static function websites() {
      $Websites = new Websites();
      if( empty( filter_input( INPUT_POST, 'wm_nonce' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         Websites::edit_view();
      } elseif( !empty( filter_input( INPUT_POST, 'wm_nonce' ) ) ) {
         Websites::create_or_update();
      } else {
         Websites::index();
      }
   }
   
   /**
    * FTP Crdentials page handler
    */
   public static function ftp_credentials() {
      if( empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         if( filter_input( INPUT_POST, 'id' ) == '') {
            $site = new Ftp_Credential();
         } else {
            $site = new Ftp_Credential( filter_input( INPUT_POST, 'id' ) );
         }
         include(__DIR__.'/views/edit_ftp_credential.php');
      } elseif( !empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) ) {
         if( !wp_verify_nonce( $_POST['wm_nonce_field'] ) ) {
            Log::warning('Failed to authorize form submission.');
            exit('Failed to authorize form submission. Please try again.');
         } else {
            $action = filter_input(INPUT_POST, 'id');
            if( !empty( $action ) ) {
               $id = filter_input(INPUT_POST, 'id');
               $ftp_credentials = new Ftp_Credential( $id );
            } else {
               $ftp_credentials = new Ftp_Credential;
            }
            $ftp_credentials->host = filter_input(INPUT_POST, 'domain_name');
            $ftp_credentials->username = filter_input(INPUT_POST, 'username');
            $ftp_credentials->password = filter_input(INPUT_POST, 'password');
            $ftp_credentials->type = filter_input(INPUT_POST, 'type');
            $ftp_credentials->save();
         }
      } else {
         FTPCredentials::index();
      }
   }
   
   /**
    * DB Credentials page handler
    */
   public static function db_credentials() {
      if( empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         DBCredentials::edit_view();
      } elseif( !empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) ) {
         if( !wp_verify_nonce( $_POST['wm_nonce_field'] ) ) {
            Log::warning( 'Failed to authorize form submission.' );
            new WP_Error( 'no_auth', __( 'Failed to authorize form submission. Please try again.', 'website-manager' ) );
         } else {
            DBCredentials::create_or_update();
         }
      } else {
         DBCredentials::index();
      }
   }
   
   /**
    * Security Log page handler
    */
   public static function log() {
      Log::info( 'Accessed the security log for '.$year.'-'.$month.'-'.$date.'.' );
      LogController::index();
   }
   
   public static function websites_ajax() {
      $response = '';
      Websites::create_or_update( $response );
      echo $response;
      die();
   }
   
   public static function ftp_ajax() {
      global $wpdb;
      die();
   }
   
   public static function db_ajax() {
      $response = array();
      DBCredentials::create_or_update( $response );
      header( 'Content-type: text/json' );
      echo json_encode( $response );
      die();
   }
   
   public static function db_delete_ajax() {
      $response = array();
      DBCredentials::delete( $response );
      header( 'Content-type: text/json' );
      echo json_encode( $response );
      die();
   }
   
   public static function add_actions() {
      add_action( 'admin_menu', array( 'WebsiteManager\WebsiteManager', 'register_menu_pages' ) );
      add_action( 'admin_enqueue_scripts', array( 'WebsiteManager\WebsiteManager', 'load_admin_assets' ) );

      //AJAX Routes
      add_action( 'wp_ajax_wm_websites', array( 'WebsiteManager\WebsiteManager', 'websites_ajax' ) );
      add_action( 'wp_ajax_wm_db', array( 'WebsiteManager\WebsiteManager', 'db_ajax' ) );
      add_action( 'wp_ajax_wm_db_delete', array( 'WebsiteManager\WebsiteManager', 'db_delete_ajax' ) );
      add_action( 'wp_ajax_wm_ftp', array( 'WebsiteManager\WebsiteManager', 'ftp_ajax' ) );
   }
   
}

//Register the plugin activation function and add the admin actions
register_activation_hook( __FILE__, array( 'WebsiteManager\WebsiteManager', 'install' ) );
WebsiteManager::add_actions();