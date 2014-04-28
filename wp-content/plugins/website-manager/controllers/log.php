<?php

class LogController extends WMCore {
   
   public function __construct() {
      parent::__construct();
   }
   
   public function index() {
      $tdata = array();
      $tdata['year'] = filter_input(INPUT_POST, 'year') == '' ? date('Y') : filter_input(INPUT_POST, 'year');
      $tdata['month'] = filter_input(INPUT_POST, 'month') == '' ? date('m') : filter_input(INPUT_POST, 'month');
      $tdata['date'] = filter_input(INPUT_POST, 'date') == '' ? date('d') : filter_input(INPUT_POST, 'date');
      $tdata['log_contents'] = explode( "\n", Log::read($tdata['year'], $tdata['month'], $tdata['date'], false) );
      $tdata['directories'] = glob( __DIR__.'/logs/*' , GLOB_ONLYDIR );
      $tdata['dir'] = __DIR__.'/logs/';
      $this->render( 'list_log.php', $tdata );
   }
   
}