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
   
   public function __construct() {
      //Set a new ID
      $this->id = uniqid('site.', true).'.'.time();
      $this->website_id = '';
      $this->host = '127.0.0.1';
      $this->db_name = '';
      $this->username = 'root';
      $this->password = '';
      $this->phpmyadmin_url = '';
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
   
   public static function find( $id ) {
      global $wpdb;
   }
   
   public static function get_by_website( $website_id ) {
      global $wpdb;
      
   }
   
   public function save() {
      
   }
   
   
}