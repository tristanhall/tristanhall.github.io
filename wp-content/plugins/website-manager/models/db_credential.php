<?php

class Db_Credential {
   
   private $id;
   private $website_id;
   private $host;
   private $db_name;
   private $username;
   private $password;
   private $phpmyadmin_url;
   private $last_modified;
   private $new = true;
   
   public function __construct( $id = null ) {
      global $wpdb;
      if($id === null) {
         //Set a new ID
         $this->id = uniqid('db.', true).'.'.time();
         $this->website_id = '';
         $this->host = '127.0.0.1';
         $this->db_name = '';
         $this->username = 'root';
         $this->password = '';
         $this->phpmyadmin_url = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $db_credential = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."wm_db_credentials` WHERE `id` = '".$id."'" ) );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $db_credential->website_id;
         $this->host = $db_credential->host;
         $this->db_name = $db_credential->db_name;
         $this->username = $db_credential->username;
         $this->password = $db_credential->password;
         $this->phpmyadmin_url = $db_credential->phpmyadmin_url;
      }
   }
   
   public function __get($name) {
      switch($name) {
         case 'host':
         case 'db_name':
         case 'username':
         case 'password':
         case 'phpmyadmin_url':
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
         case 'phpmyadmin_url':
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
      if( $this->new === true) {
         $wpdb->insert( 
            'wm_db_credentials', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'host' => $this->host,
               'db_name' => $this->db_name,
               'username' => $this->username,
               'password' => $this->password,
               'phpmyadmin_url' => $this->phpmyadmin_url
            )
         );
      } else {
         $wpdb->update( 
            'wm_db_credentials', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'host' => $this->host,
               'db_name' => $this->db_name,
               'username' => $this->username,
               'password' => $this->password,
               'phpmyadmin_url' => $this->phpmyadmin_url
            ), 
            array( 'id' => $this->id )
         );
      }
   }
   
   
}