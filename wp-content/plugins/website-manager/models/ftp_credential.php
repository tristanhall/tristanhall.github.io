<?php

namespace WebsiteManager;

class Ftp_Credential extends WMModel {
   
   protected static $id_field = 'id';
   protected static $table_name = 'wm_ftp_credentials';
   
   public $id;
   public $website_id;
   public $host;
   public $username;
   public $password;
   public $type;
   public $new = true;
   
   /**
    * 
    * @global object $wpdb
    * @param string $id
    */
   public function __construct( $id = null ) {
      global $wpdb;
      if($id === null) {
         //Set a new ID
         $this->id = uniqid('ftp.', true).'.'.time();
         $this->website_id = '';
         $this->host = '127.0.0.1';
         $this->username = '';
         $this->password = '';
         $this->type = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $ftp_credential = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."wm_ftp_credentials` WHERE `id` = '".$id."'" ) );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $ftp_credential->website_id;
         $this->host = $ftp_credential->host;
         $this->username = $ftp_credential->username;
         $this->password = $ftp_credential->password;
         $this->type = $ftp_credential->type;
         $this->last_modified = $ftp_credential->last_modified;
      }
   }
   
   /**
    * 
    * @global object $wpdb
    * @param string $website_id
    * @return array
    */
   public static function get_by_website( $website_id ) {
      global $wpdb;
      $ftp_credentials = $wpdb->get_col('SELECT * FROM `'.$wpdb->prefix.'wm_ftp_credentials` WHERE `website_id` = "'.$website_id.'"');
      return $ftp_credentials;
   }
   
   /**
    * 
    */
   public function save() {
      global $wpdb;
      if( $this->new === true ) {
         $wpdb->insert( 
         'wm_ftp_credentials', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'host' => $this->host,
               'username' => $this->username,
               'password' => $this->password,
               'type' => $this->type
            )
         );
      } else {
         $wpdb->update( 
            'wm_ftp_credentials', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'host' => $this->host,
               'username' => $this->username,
               'password' => $this->password,
               'type' => $this->type
            ), 
            array( 'id' => $this->id )
         );
      }
   }
   
   
}