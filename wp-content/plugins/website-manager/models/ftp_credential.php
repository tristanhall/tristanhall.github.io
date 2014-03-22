<?php

class Ftp_Credential {
   
   private $id;
   private $website_id;
   private $host;
   private $username;
   private $password;
   private $type;
   private $new = true;
   
   public function __construct( $id = null ) {
      global $wpdb;
      if($id === null) {
         //Set a new ID
         $this->id = uniqid('ftp.', true).'.'.time();
         $this->website_id = '';
         $this->host = '127.0.0.1';
         $this->username = '';
         $this->password = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $ftp_credential = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."wm_ftp_credentials` WHERE `id` = '".$id."'" ) );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $ftp_credential->website_id;
         $this->host = $ftp_credential->host;
         $this->username = $ftp_credential->username;
         $this->password = $ftp_credential->password;
         $this->last_modified = $ftp_credential->last_modified;
      }
   }
   
   public function __get($name) {
      switch($name) {
         case 'host':
         case 'username':
         case 'password':
         case 'type':
            return Encryption::decrypt($this->$name);
            break;
         case 'id':
         case 'website_id':
         case 'last_modified':
            return $this->$name;
            break;
      }
   }
   
   public function __set($name, $value) {
      switch($name) {
         case 'host':
         case 'db_name':
         case 'username':
         case 'password':
         case 'type':
            $this->$name = Encryption::encrypt($value);
            break;
         case 'id':
         case 'website_id':
         case 'last_modified':
            $this->$name = $value;
            break;
      }
   }
   
   public static function get_by_website( $website_id ) {
      global $wpdb;
      
   }
   
   public function save() {
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