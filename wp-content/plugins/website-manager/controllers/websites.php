<?php

namespace WebsiteManager;

class Websites extends WMController {
   
   /**
    * 
    */
   public static function edit_view() {
      $tdata = array();
      if( filter_input( INPUT_GET, 'id' ) == '') {
         $tdata['site'] = new Website;
         $tdata['db_credentials'] = array();
         $tdata['ftp_credentials'] = array();
         $tdata['notes'] = array();
      } else {
         $tdata['id'] = filter_input( INPUT_GET, 'id' );
         $tdata['site'] = new Website( $tdata['id'] );
         Log::info('Accessed website records for '.$tdata['site']->domain_name.'.');
         $tdata['db_credentials'] = Db_Credential::get_by_website( $tdata['id'] );
         $tdata['ftp_credentials'] = Ftp_Credential::get_by_website( $tdata['id'] );
         $tdata['notes'] = Note::get_by_website( $tdata['id'] );
      }
      self::render( 'edit_website', $tdata );
   }
   
   /**
    * 
    */
   public static function index() {
      Log::info('Accessed list of websites.');
      $tdata = array( 'website_ids' => Website::get_all() );
      self::render( 'list_websites', $tdata );
   }
   
   /**
    * 
    * @param string $response
    */
   public static function create_or_update( &$response ) {
      if( self::verify_nonce( 'website', 'Failed to authorize website save.' ) ){
         $new = filter_input(INPUT_POST, 'new_website');
         $id = filter_input(INPUT_POST, 'id');
         if( $new == 'no' ) {
            $website = new Website( $id );
         } else {
            $website = new Website;
            $website->id = $id;
         }
         $website->domain_name = filter_input(INPUT_POST, 'domain_name');
         $website->registrar = filter_input(INPUT_POST, 'registrar');
         $website->expiration_date = filter_input(INPUT_POST, 'expiration_date');
         $website->login_url = filter_input(INPUT_POST, 'login_url');
         $website->username = filter_input(INPUT_POST, 'username');
         $website->password = filter_input(INPUT_POST, 'password');
         $website->save();
         Log::info('Modified website information for '.$website->domain_name.'.');
         $response = 'success';
      }
   }
   
}