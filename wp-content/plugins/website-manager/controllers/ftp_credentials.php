<?php

namespace WebsiteManager;

class FTPCredentials extends WMController {
   
   public static function index() {
      Log::info('Accessed list of FTP credentials.');
      $tdata = array( 'ftp_credentials' => Ftp_Credential::get_all() );
      self::render( 'list_ftp_credentials', $tdata );
   }
   
}