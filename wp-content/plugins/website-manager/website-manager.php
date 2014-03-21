<?php
/**
 * Plugin Name: Website Manager
 * Plugin URI: http://tristanhall.com
 * Description: Keeps track of websites, MySQL credentials, FTP credentials, etc. complete with 256-bit encryption.
 * Author: Tristan Hall
 * Version: 1.0
 * License: Commercial
 */

require_once(__DIR__.'/includes/encryption.php');
require_once(__DIR__.'/models/website.php');
require_once(__DIR__.'/models/ftp_credential.php');
require_once(__DIR__.'/models/db_credential.php');
require_once(__DIR__.'/models/note.php');

class WebsiteManager {
   
   const db_version = 1.0;
   
   public function __construct() {
      
   }
   
   public function wm_install() {
      global $wpdb;
      $installed_version = get_option('_wm_db_version_');
      $sql = array();
      //Website table
      $sql['wm_websites'] = "CREATE TABLE ".$wpdb->prefix."wm_websites (
         id varchar(50) NOT NULL,
         domain_name varbinary(255) NOT NULL,
         registrar varbinary(255) NOT NULL,
         expiration_date varbinary(255) NOT NULL,
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
      }
   }
   
}

register_activation_hook( __FILE__, array('WebsiteManager', 'wm_install') );
