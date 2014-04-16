<?php
/**
 * Plugin Name: Website Manager
 * Plugin URI: http://tristanhall.com
 * Description: Keeps track of websites, MySQL credentials, FTP credentials, etc. complete with 128-bit encryption.
 * Author: Tristan Hall
 * Version: 1.0
 * License: Commercial
 */



define('LOGGING', true);

require_once(__DIR__.'/helpers/string.php');
require_once(__DIR__.'/models/log.php');
require_once(__DIR__.'/models/website.php');
require_once(__DIR__.'/models/ftp_credential.php');
require_once(__DIR__.'/models/db_credential.php');
require_once(__DIR__.'/models/note.php');

class WebsiteManager {
   
   const db_version = 1.0;
   
   /**
    * Constructor function
    */
   public function __construct() {
      
   }
   
   /**
    * Install or upgrade the databse
    * @global object $wpdb
    */
   public function install() {
      global $wpdb;
      $installed_version = get_option('_wm_db_version_');
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
      if(self::db_version != (int) $installed_version) {
         //Compile the queries
         $queries = implode('', $sql);
         require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
         //Let 'em loose
         foreach($sql as $query) {
            dbDelta( $query );
         }
         update_option('_wm_db_version_', 1.0);
         Log::info('Database updated to v'.self::db_version.'.');
      }
   }

   /**
    * Setup the admin menus
    */
   public function register_menu_page() {
       add_menu_page( 'TH Admin', 'TH Admin', 'manage_options', 'wm-dashboard', array('WebsiteManager', 'init'), plugins_url( 'website-manager/images/icon.png' ), 3 );
      add_submenu_page( 'wm-dashboard', 'Websites', 'Websites', 'manage_options', 'wm-websites', array('WebsiteManager', 'websites') );
      add_submenu_page( 'wm-dashboard', 'FTP Credentials', 'FTP Credentials', 'manage_options', 'wm-ftp-credentials', array('WebsiteManager', 'ftp_credentials') );
      add_submenu_page( 'wm-dashboard', 'DB Credentials', 'DB Credentials', 'manage_options', 'wm-db-credentials', array('WebsiteManager', 'db_credentials') );
      add_submenu_page( 'wm-dashboard', 'Security Log', 'Security Log', 'manage_options', 'wm-log', array('WebsiteManager', 'log') );
   }
   
   /**
    * Register and queue up the styles and scripts
    */
   public function load_admin_assets() {
      wp_register_style( 'wm_styles', plugins_url( 'website-manager/css/website_manager.css' ), false, '1.0' );
      wp_enqueue_style( 'wm_styles' );
      wp_register_script( 'wm_scripts', plugins_url( 'website-manager/js/jquery.functions.js' ), false, '1.0' );
      wp_enqueue_script( 'wm_scripts' );
   }
      
   /**
    * Dashboard page handler
    */
   public function init() {
      Log::info('Accessed the dashboard.');
      include(__DIR__.'/views/dashboard.php');
   }
   
   /**
    * Website page handler
    */
   public function websites() {
      if( empty( filter_input( INPUT_POST, 'wm_nonce' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         if( filter_input(INPUT_GET, 'id') == '') {
            $site = new Website;
            $db_credentials = array();
            $ftp_credentials = array();
            $notes = array();
         } else {
            $id = filter_input(INPUT_GET, 'id');
            $site = new Website( $id );
            Log::info('Accessed website records for '.$site->domain_name.'.');
            $db_credentials = Db_Credential::get_by_website( $id );
            $ftp_credentials = Ftp_Credential::get_by_website( $id );
            $notes = Note::get_by_website( $id );
         }
         include(__DIR__.'/views/edit_website.php');
      } elseif( !empty( filter_input( INPUT_POST, 'wm_nonce' ) ) ) {
         if( wp_verify_nonce( $_POST['wm_nonce_field'] ) ) {
            Log::warning('Failed to authorize website save.');
            exit('Failed to authorize form submission. Please try again.');
         } else {
            $action = filter_input(INPUT_POST, 'action');
            $id = filter_input(INPUT_POST, 'id');
            if( $action == 'update' ) {
               $website = new Website( $id );
            } else {
               $website = new Website;
               $website->id = $id;
            }
            $website->domain_name = filter_input(INPUT_POST, 'domain_name');
            $website->registrar = filter_input(INPUT_POST, 'registrar');
            $website->expiration_date = filter_input(INPUT_POST, 'expiration_date');
            $website->login_url = filter_input(INPUT_POST, 'login_url');
            $website->username = filter_input(INPUT_POST, 'username');
            $website->password = filter_input(INPUT_POST, 'password');
            $website->save();
            Log::info('Modified website information for '.$website->domain_name.'.');
         }
      } else {
         Log::info('Accessed list of websites.');
         $website_ids = Website::get_all();
         include(__DIR__.'/views/list_websites.php');
      }
   }
   
   /**
    * FTP Crdentials page handler
    */
   public function ftp_credentials() {
      if( empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         if( filter_input(INPUT_POST, 'id') == '') {
            $site = new Ftp_Credential();
         } else {
            $site = new Ftp_Credential( filter_input(INPUT_POST, 'id') );
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
         Log::info('Accessed list of FTP credentials.');
         $ftp_credential_ids = Ftp_Credential::get_all();
         include(__DIR__.'/views/list_ftp_credentials.php');
      }
   }
   
   /**
    * DB Credentials page handler
    */
   public function db_credentials() {
      if( empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) && filter_input( INPUT_GET, 'action' ) == 'edit' ) {
         if( filter_input(INPUT_POST, 'id') == '') {
            $site = new Db_Credential();
         } else {
            $site = new Db_Credential( filter_input(INPUT_POST, 'id') );
         }
         include(__DIR__.'/views/edit_db_credential.php');
      } elseif( !empty( filter_input( INPUT_POST, 'wm_nonce_field' ) ) ) {
         if( !wp_verify_nonce( $_POST['wm_nonce_field'] ) ) {
            Log::warning('Failed to authorize form submission.');
            exit('Failed to authorize form submission. Please try again.');
         } else {
            $action = filter_input(INPUT_POST, 'id');
            if( !empty( $action ) ) {
               $id = filter_input(INPUT_POST, 'id');
               $db_credentials = new Db_Credential( $id );
            } else {
               $db_credentials = new Db_Credential;
            }
            $db_credentials->host = filter_input(INPUT_POST, 'domain_name');
            $db_credentials->database = filter_input(INPUT_POST, 'database');
            $db_credentials->username = filter_input(INPUT_POST, 'username');
            $db_credentials->password = filter_input(INPUT_POST, 'password');
            $db_credentials->phpmyadmin_url = filter_input(INPUT_POST, 'phpmyadmin_url');
            $db_credentials->save();
         }
      } else {
         Log::info('Accessed list of database credentials.');
         $db_credential_ids = Db_Credential::get_all();
         include(__DIR__.'/views/list_db_credentials.php');
      }
   }
   
   /**
    * Security Log page handler
    */
   public function log() {
      Log::info('Accessed the security log for '.$year.'-'.$month.'-'.$date.'.');
      $year = filter_input(INPUT_POST, 'year') == '' ? date('Y') : filter_input(INPUT_POST, 'year');
      $month = filter_input(INPUT_POST, 'month') == '' ? date('m') : filter_input(INPUT_POST, 'month');
      $date = filter_input(INPUT_POST, 'date') == '' ? date('d') : filter_input(INPUT_POST, 'date');
      $log_contents = explode( "\n", Log::read($year, $month, $date, false) );
      $directories = glob( __DIR__.'/logs/*' , GLOB_ONLYDIR );
      $dir = __DIR__.'/logs/';
      include(__DIR__.'/views/list_log.php');
   }
   
   public function websites_ajax() {
      $response = '';
      if( !wp_verify_nonce( $_POST['wm_nonce'], 'website' ) ) {
         Log::warning('Failed to authorize website save.');
         $response = 'no_auth';
      } else {
         $new = $_POST['new_website'];
         $id = $_POST['id'];
         if( $new == 'no' ) {
            $website = new Website( $id );
         } else {
            $website = new Website;
            $website->id = $id;
         }
         $website->domain_name = filter_input(INPUT_POST, 'domain_name');
         $website->registrar = filter_input(INPUT_POST, 'registrar');
         $website->expiration_date = filter_input(INPUT_POST, 'expiration_date');
         $website->login_url = filter_input(INPUT_POST, 'login_url');
         $website->username = filter_input(INPUT_POST, 'username');
         $website->password = filter_input(INPUT_POST, 'password');
         $website->save();
         Log::info('Modified website information for '.$website->domain_name.'.');
         $response = 'success';
      }
      echo $response;
      die();
   }
   
   public function ftp_ajax() {
      global $wpdb;
      die();
   }
   
   public function db_ajax() {
      global $wpdb;
      $response = array();
      if( !wp_verify_nonce( $_POST['wm_nonce'], 'db' ) ) {
         Log::warning('Failed to authorize database credential save.');
         $response['status'] = 'no_auth';
      } else {
         $new = filter_input(INPUT_POST, 'new_db');
         $id = filter_input(INPUT_POST, 'db_id');
         if( $new === 'no' ) {
            $db = new Db_Credential( $id );
         } else {
            $db = new Db_Credential();
            if( !empty( $id ) ) {
               $db->id = $id;
            }
         }
         $db->host = filter_input(INPUT_POST, 'db_host');
         $db->db_name = filter_input(INPUT_POST, 'db_name');
         $db->username = filter_input(INPUT_POST, 'db_username');
         $db->password = filter_input(INPUT_POST, 'db_password');
         $db->phpmyadmin_url = filter_input(INPUT_POST, 'phpmyadmin_url');
         $db->website_id = filter_input(INPUT_POST, 'website_id');
         $db->save();
         Log::info('Modified credentials for '.$db->host.'.');
         $response['status'] = 'success';
      }
      header('Content-type: text/json');
      echo json_encode( $response );
      die();
   }
   
}

//Register the plugin activation function and add the admin actions
register_activation_hook( __FILE__, array('WebsiteManager', 'install') );
add_action( 'admin_menu', array('WebsiteManager', 'register_menu_page') );
add_action( 'admin_enqueue_scripts', array('WebsiteManager', 'load_admin_assets') );

//AJAX Routes
add_action( 'wp_ajax_wm_websites', array('WebsiteManager', 'websites_ajax') );
add_action( 'wp_ajax_wm_db', array('WebsiteManager', 'db_ajax') );
add_action( 'wp_ajax_wm_ftp', array('WebsiteManager', 'ftp_ajax') );