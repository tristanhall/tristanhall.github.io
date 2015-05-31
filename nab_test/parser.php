#!/usr/bin/php
<?php

class FileParser {
   
   /**
    * Store the current file as an object.
    * 
    * @var SplFileObject
    * @access private
    */
   private $file;
   
   /**
    * Stores the PHP accessible data from the file.
    * 
    * @var mixed
    * @access private
    */
   private $payload;
   
   /**
    * Execute a parsing function based on the file's extension.
    * 
    * @access private
    * @return void
    */
   private function parse() {
      switch( $this->file->getExtension() ) {
         case 'csv':
            $this->parse_csv();
            break;
         case 'xml':
            $this->parse_xml();
            break;
         case 'json':
            $this->parse_json();
            break;
      }
   }
   
   /**
    * Load the decoded contents of an XML string into the payload variable.
    * 
    * @access private
    * @return void
    */
   private function parse_xml() {
      $contents = $this->file->fread( $this->file->getSize() );
      $this->payload = simplexml_load_string( $contents );
   }
   
   /**
    * Load the decoded contents of a json file into the payload variable.
    * 
    * @access private
    * @return void
    */
   private function parse_json() {
      $contents = $this->file->fread( $this->file->getSize() );
      $this->payload = json_decode( $contents );
   }
   
   /**
    * Load the rows of a CSV into the payload variable.
    * 
    * @access private
    * @return void
    */
   private function parse_csv() {
      $this->file->setFlags( SplFileObject::READ_CSV );
      $this->payload = array();
      foreach( $this->file as $row ) {
         list( $id, $name, $quantity, $category ) = $row;
         $categories = $words = preg_split( '/(?<=\s)|(?<=\w)(?=[.,:;!?()-])|(?<=[.,!()?\x{201C}])(?=[^ ])/u', $category );
         $this->payload[] = array(
            'id'         => $id,
            'name'       => $name,
            'quantity'   => $quantity,
            'categories' => implode( ', ', $categories )
         );
      }
   }
   
   /**
    * Load up a file object and fileinfo object, then parse the data.
    * 
    * @access public
    * @param string $filename
    * @return void
    */
   public function __construct( $filename ) {
      if( !file_exists( $filename ) ) {
         throw new RuntimeException( sprintf( 'Could not find %s.', $filename ) );
      }
      $this->file = new SplFileObject( $filename );
      $this->parse();
   }
   
   /**
    * Return the extension of the loaded file.
    * 
    * @access public
    * @return string
    */
   public function extension() {
      return $this->fileinfo->getExtension();
   }
   
   /**
    * Return the size of the loaded file.
    * 
    * @access public
    * @return string
    */
   public function size() {
      return $this->fileinfo->getSize();
   }
   
   /**
    * Reload the data.
    * 
    * @access public
    * @return void
    */
   public function reload() {
      if( !file_exists( $filename ) ) {
         throw new RuntimeException( sprintf( 'The file %s no longer exists.', $filename ) );
      }
      $this->parse();
   }
   
   /**
    * Print out the parsed data.
    * 
    * @access public
    * @return void
    */
   public function print_data() {
      switch( gettype( $this->payload ) ) {
         case 'object':
            foreach( get_object_vars( $this->payload ) as $k => $v ) {
               echo sprintf( "%s:", $k );
               echo str_repeat( '=', strlen( $k ) );
               echo "\n";
               if( is_array( $val ) ) {
                  foreach( $val as $v ) {
                     print_r( $v );
                     echo "\t";
                  }
               } else {
                  print_r( $v );
               }
               echo "\n";
            }
            break;
         case 'array':
            foreach( $this->payload as $val ) {
               if( is_array( $val ) ) {
                  foreach( $val as $v ) {
                     print_r( $v );
                     echo "\t";
                  }
               } else {
                  print_r( $v );
               }
               echo "\n";
            }
            break;
      }
   }
   
}

$args = getopt( 'f:' );
$parser = new FileParser( $args['f'] );
$parser->print_data();
exit(0);