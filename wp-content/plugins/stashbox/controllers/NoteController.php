<?php 
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class NoteController {
   
   /**
    * Set which post types to enable Notes for.
    * 
    * @var array
    * @access private
    * @static
    */
   private static $post_types = array(
      'th_client',
      'th_domain',
      'th_server',
      'th_sslcertificate',
      'th_website'
   );
   
   /**
    * Callback for the stashbox_assign_js_vars filter.
    * This adds Note related variables to the Stashbox object.
    * 
    * @access public
    * @static
    * @param array $js_vars
    * @return array
    */
   public static function filter_stashbox_assign_js_vars( $js_vars ) {
      $note_vars = array(
         'note' => array(
            'security' => wp_create_nonce( 'stashbox-note' ),
            'lang'     => array(
               'create_note'    => __( 'Create Note', 'th' ),
               'confirm_delete' => __( 'Are you sure you want to delete this note?', 'th' ),
               'create_error'   => __( 'There was a problem saving your note. Please try again later.', 'th' ),
               'delete_error'   => __( 'There was a problem deleting that note. Please try again later.', 'th' )
            )
         )
      );
      return array_merge( $js_vars, $note_vars );
   }
   
   /**
    * Load JS files for Stashbox Notes.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      wp_register_script( 'stashbox-note', plugins_url( 'stashbox/js/stashbox.note.js' ), array( 'jquery', 'stashbox-core' ), '1.0', true );
      wp_enqueue_script( 'stashbox-note' );
      wp_register_style( 'stashbox-note', plugins_url( 'stashbox/css/stashbox.note.css' ), array( 'dashicons' ) );
      wp_enqueue_style( 'stashbox-note' );
   }
   
   /**
    * Enable the Notes metabox for a specific post type.
    * 
    * @access public
    * @static
    * @param string $post_type
    * @return void
    */
   public static function action_add_meta_boxes() {
      foreach( self::$post_types as $post_type ) {
         add_meta_box( 'stashbox-notes', __( 'Notes', 'th' ), array( __CLASS__, 'mb_notes' ), $post_type, 'normal', 'core' );
      }
   }
   
   /**
    * AJAX handler for creating notes.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_wp_ajax_stashbox_create_note() {
      check_ajax_referer( 'stashbox-note', 'stashbox_nonce' );
      $text = nl2br( filter_input( INPUT_POST, 'text', FILTER_SANITIZE_STRING ) );
      $post_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
      $post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );
      $comment_id = Note::create( $text, $post_type, $post_id );
      if( is_numeric( $comment_id ) ) {
         $tdata = get_comment( $comment_id, ARRAY_A );
         $comment_row = Template::make( 'notes/row-note', $tdata, false );
         Template::makejson( array( 'status' => 'success', 'comment_id' => $comment_id, 'comment_row' => $comment_row ) );
      } else {
         Template::makejson( array( 'status' => 'failure' ) );
      }
   }
   
   /**
    * AJAX handler for deleting notes.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_wp_ajax_stashbox_delete_note() {
      check_ajax_referer( 'stashbox-note', 'stashbox_nonce' );
      $comment_id = filter_input( INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT );
      $deleted = Note::delete( $comment_id );
      if( $deleted ) {
         Template::makejson( array( 'status' => 'success', 'comment_id' => $comment_id ) );
      } else {
         Template::makejson( array( 'status' => 'failure' ) );
      }
   }
   
   /**
    * Callback function for the Notes metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_notes( $post ) {
      add_thickbox();
      $tdata = array(
         'notes'     => Note::get_by_post( $post->ID ),
         'post_type' => $post->post_type,
         'post_id'   => $post->ID
      );
      Template::make( 'notes/mb-notes', $tdata );
   }
   
}