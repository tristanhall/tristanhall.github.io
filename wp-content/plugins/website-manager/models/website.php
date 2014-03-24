<?php

class Website {
   
   public $id;
   public $domain_name;
   public $registrar;
   public $exiration_date;
   public $login_url;
   public $username;
   public $password;
   public $last_modified;
   public $new = true;
   
   public function __construct( $id = null ) {
      global $wpdb;
      if($id === null) {
         //Set a new ID if we aren't given one.
         $this->id = uniqid('site.', true).'.'.time();
         $this->domain_name = '';
         $this->registrar = '';
         $this->expiration_date = '';
         $this->login_url = '';
         $this->username = '';
         $this->password = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $website = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."wm_websites` WHERE `id` = '".$id."'" ) );
         $this->new = false;
         $this->id = $id;
         $this->domain_name = $website->domain_name;
         $this->registrar = $website->registrar;
         $this->expiration_date = $website->expiration_date;
         $this->login_url = $website->login_url;
         $this->username = $website->username;
         $this->password = $website->password;
         $this->last_modified = $website->last_modified;
      }
   }
   
   public function __get($name) {
      switch($name) {
         case 'domain_name':
         case 'registrar':
         case 'login_url':
         case 'username':
         case 'password':
            return Encryption::decrypt($this->$name);
            break;
         case 'id':
         case 'expiration_date':
         case 'last_modified':
            return $this->$name;
            break;
      }
   }
   
   public function __set($name, $value) {
      switch($name) {
         case 'domain_name':
         case 'registrar':
         case 'login_url':
         case 'username':
         case 'password':
            $this->$name = Encryption::encrypt($value);
            break;
         case 'id':
         case 'expiration_date':
         case 'last_modified':
         case 'new':
            $this->$name = $value;
            break;
      }
   }
   
   public function get_all() {
      global $wpdb;
      $website_ids = $wpdb->get_col('SELECT `id` FROM `'.$wpdb->prefix.'wm_websites`');
      return $website_ids;
   }
   
   public function save() {
      if( $this->new === true ) {
         $wpdb->insert( 
            'wm_websites', 
            array( 
               'id' => $this->id,
               'domain_name' => Encryption::encrypt( $this->domain_name ),
               'domain_name' => Encryption::encrypt( $this->domain_name ),
               'registrar' => Encryption::encrypt( $this->registrar ),
               'expiration_date' => Encryption::encrypt( $this->expiration_date ),
               'login_url' => Encryption::encrypt( $this->login_url ),
               'username' => Encryption::encrypt( $this->username ),
               'password' => Encryption::encrypt( $this->password )
            )
         );
      } else {
         $wpdb->update( 
            'wm_websites', 
            array( 
               'id' => $this->id,
               'domain_name' => $this->domain_name,
               'domain_name' => $this->domain_name,
               'registrar' => $this->registrar,
               'expiration_date' => $this->expiration_date,
               'login_url' => $this->login_url,
               'username' => $this->username,
               'password' => $this->password
            ), 
            array( 'id' => $this->id )
         );
      }
   }
   
   
}