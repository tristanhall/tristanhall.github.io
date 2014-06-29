<?php

namespace WebsiteManager;

class Db_Credential extends WMModel {
   
   protected static $id_field = 'id';
   protected static $table_name = 'wm_db_credentials';
   protected $encryption_key;
   
   public $id;
   public $website_id;
   public $host;
   public $db_name;
   public $username;
   public $password;
   public $phpmyadmin_url;
   public $last_modified;
   public $associated_domain_name;
   public $new = true;
   
   /**
    * 
    * @global object $wpdb
    * @param string $id
    */
   public function __construct( $id = null ) {
      global $wpdb;
      $this->encryption_key = file_get_contents(__DIR__.'/../data/wm_private.key');
      if( $id === null ) {
         //Set a new ID
         $this->id = uniqid( 'db.', true ).'.'.time();
         $this->website_id = '';
         $this->host = '127.0.0.1';
         $this->db_name = '';
         $this->username = 'root';
         $this->password = '';
         $this->phpmyadmin_url = '';
         $this->associated_domain_name = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $query = sprintf( 'SELECT %2$s.id, %2$s.website_id, AES_DECRYPT(%2$s.host, "%1$s"), AES_DECRYPT(%2$s.db_name, "%1$s"), AES_DECRYPT(%2$s.username, "%1$s"), AES_DECRYPT(%2$s.password, "%1$s"), AES_DECRYPT(%2$s.phpmyadmin_url, "%1$s"), %2$s.last_modified, AES_DECRYPT(%4$s.domain_name, "%1$s") FROM `%2$s`, `%4$s` WHERE `%2$s`.'.static::$id_field.' = "%3$s" AND `%2$s`.website_id = `%4$s`.id', $this->encryption_key, $wpdb->prefix.static::$table_name, $id, $wpdb->prefix.'wm_websites' );
         $db_credential = $wpdb->get_row( $query, ARRAY_A );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $db_credential['website_id'];
         $this->host = $db_credential['AES_DECRYPT('.$wpdb->prefix.static::$table_name.'.host, "'.$this->encryption_key.'")'];
         $this->db_name = $db_credential['AES_DECRYPT('.$wpdb->prefix.static::$table_name.'.db_name, "'.$this->encryption_key.'")'];
         $this->username = $db_credential['AES_DECRYPT('.$wpdb->prefix.static::$table_name.'.username, "'.$this->encryption_key.'")'];
         $this->password = $db_credential['AES_DECRYPT('.$wpdb->prefix.static::$table_name.'.password, "'.$this->encryption_key.'")'];
         $this->phpmyadmin_url = $db_credential['AES_DECRYPT('.$wpdb->prefix.static::$table_name.'.phpmyadmin_url, "'.$this->encryption_key.'")'];
         $this->associated_domain_name = $db_credential['AES_DECRYPT('.$wpdb->prefix.'wm_websites'.'.domain_name, "'.$this->encryption_key.'")'];
      }
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
   
   /**
    * Deletes a database credential and the current object.
    * @param string $id
    * @return boolean
    */
   public static function delete( $id ) {
      global $wpdb;
      $delete = $wpdb->delete( $wpdb->prefix.'wm_db_credentials', array( 'id' => $id ), array( '%s' ) );
      return $delete;
   }
}