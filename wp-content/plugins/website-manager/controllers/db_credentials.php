<?php

class DBCredentials extends WMCore {
   
   /**
    * 
    */
   public function __construct() {
      parent::__construct();
   }
   
   public function index() {
      
   }
   
   public function edit_view() {
      
   }
   
   /**
    * Create or update a database credential.
    * @param string $response
    * @return boolean
    */
   public function create_or_update( &$response ) {
      if( !$this->verify_nonce( 'db', 'Failed to authorize database credential save.' ) ) {
         $response['status'] = 'no_auth';
         return false;
      }
      $new = filter_input(INPUT_POST, 'new_db');
      $id = filter_input(INPUT_POST, 'db_id');
      if( $new === 'no' ) {
         $db = new Db_Credential( $id );
      } else {
         $db = new Db_Credential();
         if( !empty( $id ) ) {
            $db->id = $id;
         }
      }
      $db->host = filter_input(INPUT_POST, 'db_host');
      $db->db_name = filter_input(INPUT_POST, 'db_name');
      $db->username = filter_input(INPUT_POST, 'db_username');
      $db->password = filter_input(INPUT_POST, 'db_password');
      $db->phpmyadmin_url = filter_input(INPUT_POST, 'phpmyadmin_url');
      $db->website_id = filter_input(INPUT_POST, 'website_id');
      $db->save();
      Log::info('Modified credentials for '.$db->host.'.');
      $response['status'] = 'success';
      $response['id'] = $db->id;
      return true;
   }
   
   /**
    * Delete a database credential.
    * @param string $response
    * @return boolean
    */
   public function delete( &$response ) {
      if( !$this->validate_nonce('db', 'Failed to authorize database credential save.') ) {
         $response['status'] = 'no_auth';
         return false;
      }
      $id = filter_input(INPUT_POST, 'db_id');
      $delete = Db_Credential::delete( $id );
      $response['debug'] = $delete;
      if($delete) {
         Log::info('Deleted DB credential '.$id.'.');
         $response['status'] = 'success';
      } else {
         $response['status'] = 'failure';
      }
      return true;
   }
   
}