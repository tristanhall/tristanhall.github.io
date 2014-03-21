<?php

class Website {
   
   private $id;
   private $domain_name;
   private $registrar;
   private $exiration_date;
   private $login_url;
   private $username;
   private $password;
   private $last_modified;
   
   public function __construct() {
      //Set a new ID
      $this->id = uniqid('site.', true).'.'.time();
      $this->domain_name = '';
      $this->registrar = '';
      $this->expiration_date = '';
      $this->login_url = '';
      $this->username = '';
      $this->password = '';
   }
   
   public function __get($name) {
      switch($name) {
         case 'domain_name':
         case 'registrar':
         case 'expiration_date':
         case 'login_url':
         case 'username':
         case 'password':
            return Encryption::decrypt($this->$name);
            break;
         case 'id':
         case 'last_modified':
            return $this->$name;
            break;
      }
   }
   
   public function __set($name, $value) {
      switch($name) {
         case 'domain_name':
         case 'registrar':
         case 'expiration_date':
         case 'login_url':
         case 'username':
         case 'password':
            $this->$name = Encryption::encrypt($value);
            break;
         case 'id':
         case 'last_modified':
            $this->$name = $value;
            break;
      }
   }
   
   public static function find( $id ) {
      global $wpdb;
      
   }
   
   public static function get_all() {
      global $wpdb;
      
   }
   
   public static function save() {
      
   }
   
   
}