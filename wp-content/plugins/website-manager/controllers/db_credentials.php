<?php

namespace WebsiteManager;

class DBCredentials extends WMController {
   
   public static function index() {
      Log::info( 'Accessed list of database credentials.' );
      $tdata = array( 'db_credentials' => Db_Credential::get_all() );
      self::render( 'list_db_credentials', $tdata );
   }
   
   public static function edit_view() {
      $tdata = array();
      if( filter_input( INPUT_GET, 'id' ) == '') {
         $tdata['db'] = new Db_Credential();
      } else {
         $tdata['id'] = filter_input( INPUT_GET, 'id' );
         $tdata['db'] = new Db_Credential( $tdata['id'] );
         Log::info( 'Accessed DB Credential for '.$tdata['site']->domain_name.'.' );
      }
      self::render( 'edit_db_credential', $tdata );
   }
   
   /**
    * Create or update a database credential.
    * @param string $response
    * @return boolean
    */
   public static function create_or_update( &$response ) {
      if( !self::verify_nonce( 'db', 'Failed to authorize database credential save.' ) ) {
         $response['status'] = 'no_auth';
         return false;
      }
      $new = filter_input( INPUT_POST, 'new_db' );
      $id = filter_input( INPUT_POST, 'id' );
      if( $new === 'no' ) {
         $db = new Db_Credential( $id );
      } else {
         $db = new Db_Credential();
         if( !empty( $id ) ) {
            $db->id = $id;
         }
      }
      $db->host = filter_input( INPUT_POST, 'db_host' );
      $db->db_name = filter_input( INPUT_POST, 'db_name' );
      $db->username = filter_input( INPUT_POST, 'db_username' );
      $db->password = filter_input( INPUT_POST, 'db_password' );
      $db->phpmyadmin_url = filter_input( INPUT_POST, 'phpmyadmin_url' );
      $db->save();
      Log::info( 'Modified credentials for '.$db->host.'.' );
      $response['status'] = 'success';
      $response['id'] = $db->id;
      return true;
   }
   
   /**
    * Delete a database credential.
    * @param string $response
    * @return boolean
    */
   public static function delete( &$response ) {
      $id = filter_input( INPUT_POST, 'db_id' );
      $delete = Db_Credential::delete( $id );
      $response['debug'] = $delete;
      if($delete) {
         Log::info( 'Deleted DB credential '.$id.'.' );
         $response['status'] = 'success';
      } else {
         $response['status'] = 'failure';
      }
      return true;
   }
   
}