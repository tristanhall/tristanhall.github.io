<?php

namespace WebsiteManager;

abstract class WMModel {
   
   protected static $id_field = 'id';
   protected static $table_name = 'wm_websites';
   
   /**
    * Retrieve all records from the table.
    * @global object $wpdb
    * @return array
    */
   public static function get_all() {
      global $wpdb;
      $results = $wpdb->get_results('SELECT * FROM `'.$wpdb->prefix.static::$table_name.'`');
      return $results;
   }
   
   /**
    * Retrieve a record by its ID
    * @global object $wpdb
    * @param mixed $id
    * @return object
    */
   public static function get_by_id( $id ) {
      global $wpdb;
      $record = $wpdb->get_row('SELECT * FROM `'.$wpdb->prefix.static::$table_name.'` WHERE `'.static::$id_field.'` = "'.$id.'"');
      return $record;
   }
   
}