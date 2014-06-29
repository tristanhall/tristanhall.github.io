<?php

namespace WebsiteManager;

class Website extends WMModel {
   
   protected static $id_field = 'id';
   protected static $table_name = 'wm_websites';
   protected $encryption_key;
   
   public $id;
   public $domain_name;
   public $registrar;
   public $exiration_date;
   public $login_url;
   public $username;
   public $password;
   public $last_modified;
   public $new = true;
   
   /**
    * 
    * @global object $wpdb
    * @param string $id
    */
   public function __construct( $id = null ) {
      global $wpdb;
      $this->encryption_key = file_get_contents(__DIR__.'/../data/wm_private.key');
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
         $query = sprintf('SELECT AES_DECRYPT(domain_name, "%1$s"), AES_DECRYPT(registrar, "%1$s"), AES_DECRYPT(expiration_date, "%1$s"), AES_DECRYPT(login_url, "%1$s"), AES_DECRYPT(username, "%1$s"), AES_DECRYPT(password, "%1$s"), last_modified FROM `%2$s` WHERE `id` = "%3$s"', $this->encryption_key, $wpdb->prefix.'wm_websites', $id);
         $website = $wpdb->get_row( $query, ARRAY_A );
         $this->new = false;
         $this->id = $id;
         $this->domain_name = $website['AES_DECRYPT(domain_name, "'.$this->encryption_key.'")'];
         $this->registrar =$website['AES_DECRYPT(registrar, "'.$this->encryption_key.'")'];
         $this->expiration_date = $website['AES_DECRYPT(expiration_date, "'.$this->encryption_key.'")'];
         $this->login_url = $website['AES_DECRYPT(login_url, "'.$this->encryption_key.'")'];
         $this->username = $website['AES_DECRYPT(username, "'.$this->encryption_key.'")'];
         $this->password = $website['AES_DECRYPT(password, "'.$this->encryption_key.'")'];
         $this->last_modified = $website->last_modified;
      }
   }
   
   /**
    * 
    * @global object $wpdb
    * @return array
    */
   public static function get_all() {
      global $wpdb;
      $website_ids = $wpdb->get_col('SELECT `id` FROM `'.$wpdb->prefix.'wm_websites`');
      return $website_ids;
   }
   
   /**
    * 
    * @global object $wpdb
    */
   public function save() {
      global $wpdb;
      if(LOGGING === TRUE) {
         $wpdb->show_errors();
      }
      if( $this->new === true ) {
         $query = sprintf('INSERT INTO `%1$s` (id, domain_name, registrar, expiration_date, login_url, username, password, last_modified) VALUES ("%9$s", AES_ENCRYPT("%2$s", "%8$s"), AES_ENCRYPT("%3$s", "%8$s"), AES_ENCRYPT("%4$s", "%8$s"), AES_ENCRYPT("%5$s", "%8$s"), AES_ENCRYPT("%6$s", "%8$s"), AES_ENCRYPT("%7$s", "%8$s"), "%10$s")',
           $wpdb->prefix.'wm_websites',
           $this->domain_name,
           $this->registrar,
           $this->expiration_date,
           $this->login_url,
           $this->username,
           $this->password,
           $this->encryption_key,
           $this->id,
           date('Y-m-d H:i:s')
         );
         $wpdb->query( $query );
      } else {
         $query = sprintf('UPDATE `%1$s` SET `domain_name` = AES_ENCRYPT("%2$s", "%8$s"), `registrar` = AES_ENCRYPT("%3$s", "%8$s"), `expiration_date` = AES_ENCRYPT("%4$s", "%8$s"), `login_url` = AES_ENCRYPT("%5$s", "%8$s"), `username` = AES_ENCRYPT("%6$s", "%8$s"), `password` = AES_ENCRYPT("%7$s", "%8$s") WHERE `id` = "%9$s"',
           $wpdb->prefix.'wm_websites',
           $this->domain_name,
           $this->registrar,
           $this->expiration_date,
           $this->login_url,
           $this->username,
           $this->password,
           $this->encryption_key,
           $this->id
         );
         $wpdb->query( $query );
      }
   }
   
   
}