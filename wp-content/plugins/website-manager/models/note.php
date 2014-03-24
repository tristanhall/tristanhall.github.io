<?php

class Note {
   
   public $id;
   public $website_id;
   public $author_id;
   public $note_contents;
   public $new = true;
   
   public function __construct( $id = null ) {
      global $wpdb;
      if($id === null) {
         //Set a new ID if we aren't given one.
         $this->id = uniqid('note.', true).'.'.time();
         $this->website_id = '';
         $this->author_id = get_current_user_id();
         $this->note_contents = '';
         $this->last_modified = current_time( 'mysql' );
      } else {
         $note = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."wm_notes` WHERE `id` = '".$id."'" ) );
         $this->new = false;
         $this->id = $id;
         $this->website_id = $note->website_id;
         $this->author_id = $note->author_id;
         $this->note_contents = $note->note_contents;
         $this->last_modified = $note->last_modified;
      }
   }
   
   public function __get($name) {
      switch($name) {
         case 'note_contents':
            return Encryption::decrypt($this->$name);
            break;
         case 'id':
         case 'website_id':
         case 'last_modified':
            return $this->$name;
            break;
      }
   }
   
   public function __set($name, $value) {
      switch($name) {
         case 'note_contents':
            $this->$name = Encryption::encrypt($value);
            break;
         case 'id':
         case 'website_id':
         case 'last_modified':
            $this->$name = $value;
            break;
      }
   }
   
   public static function get_by_website( $website_id ) {
      global $wpdb;
      $notes = $wpdb->get_col('SELECT * FROM `'.$wpdb->prefix.'wm_notes` WHERE `website_id` = "'.$website_id.'"');
      return $notes;
   }
   
   public function save() {
      if( $this->new === true ) {
         $wpdb->insert( 
            'wm_notes', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'author_id' => $this->author_id,
               'note_contents' => $this->note_contents
            )
         );
      } else {
         $wpdb->update( 
            'wm_notes', 
            array( 
               'id' => $this->id,
               'website_id' => $this->website_id,
               'author_id' => $this->author_id,
               'note_contents' => $this->note_contents
            ), 
            array( 'id' => $this->id )
         );
      }
   }
   
   
}