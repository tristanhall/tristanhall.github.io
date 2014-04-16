<?php

class Db_Credential {
   
   public $id;
   public $website_id;
   public $host;
   public $db_name;
   public $username;
   public $password;
   public $phpmyadmin_url;
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
         $query = sprintf('SELECT website_id, AES_DECRYPT(host, "%1$s"), AES_DECRYPT(db_name, "%1$s"), AES_DECRYPT(username, "%1$s"), AES_DECRYPT(password, "%1$s"), AES_DECRYPT(phpmyadmin_url, "%1$s"), last_modified FROM `%2$s` WHERE `id` = "%3$s"', $this->encryption_key, $wpdb->prefix.'wm_db_credentials', $id);
         $db_credential = $wpdb->get_row( $query, ARRAY_A );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $db_credential['AES_DECRYPT(website_id, "'.$this->encryption_key.'")'];
         $this->host = $db_credential['AES_DECRYPT(host, "'.$this->encryption_key.'")'];
         $this->db_name = $db_credential['AES_DECRYPT(db_name, "'.$this->encryption_key.'")'];
         $this->username = $db_credential['AES_DECRYPT(username, "'.$this->encryption_key.'")'];
         $this->password = $db_credential['AES_DECRYPT(password, "'.$this->encryption_key.'")'];
         $this->phpmyadmin_url = $db_credential['AES_DECRYPT(phpmyadmin_url, "'.$this->encryption_key.'")'];
      }
   }
   
   /**
    * 
    * @global object $wpdb
    * @return array
    */
   public static function get_all() {
      global $wpdb;
      $db_credentials = $wpdb->get_col('SELECT `id` FROM `'.$wpdb->prefix.'wm_db_credentials`');
      return $db_credentials;
   }
   
   /**
    * 
    */
   public function save() {
      global $wpdb;
      if(LOGGING === TRUE) {
         $wpdb->show_errors();
      }
      if( $this->new === true ) {
         $query = sprintf('INSERT INTO `%1$s` (id, website_id, host, db_name, username, password, phpmyadmin_url, last_modified) VALUES ("%9$s", "%2$s", AES_ENCRYPT("%3$s", "%8$s"), AES_ENCRYPT("%4$s", "%8$s"), AES_ENCRYPT("%5$s", "%8$s"), AES_ENCRYPT("%6$s", "%8$s"), AES_ENCRYPT("%7$s", "%8$s"), "%10$s")',
           $wpdb->prefix.'wm_db_credentials',
           $this->website_id,
           $this->host,
           $this->db_name,
           $this->username,
           $this->password,
           $this->phpmyadmin_url,
           $this->encryption_key,
           $this->id,
           date('Y-m-d H:i:s')
         );
         $wpdb->query( $query );
      } else {
         $query = sprintf('UPDATE `%1$s` SET `website_id` = "%2$s", "%8$s", `host` = AES_ENCRYPT("%3$s", "%8$s"), `db_name` = AES_ENCRYPT("%4$s", "%8$s"), `username` = AES_ENCRYPT("%5$s", "%8$s"), `password` = AES_ENCRYPT("%6$s", "%8$s"), `phpmyadmin_url` = AES_ENCRYPT("%7$s", "%8$s") WHERE `id` = "%9$s"',
           $wpdb->prefix.'wm_db_credentials',
           $this->website_id,
           $this->host,
           $this->db_name,
           $this->username,
           $this->password,
           $this->phpmyadmin_url,
           $this->encryption_key,
           $this->id
         );
         $wpdb->query( $query );
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
      $db_credentials = $wpdb->get_col('SELECT `id` FROM `'.$wpdb->prefix.'wm_db_credentials` WHERE `website_id` = "'.$website_id.'"');
      return $db_credentials;
   }
   
}