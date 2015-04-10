<?php
namespace TH\Stashbox;

class Website extends \TH\WPAtomic\Post {
   
   protected static $_post_type = 'th_website';
   
   protected static $_post_labels = array(
		'name'               => 'Websites',
		'singular_name'      => 'Website',
		'menu_name'          => 'Websites',
		'name_admin_bar'     => 'Website',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Website',
		'new_item'           => 'New Website',
		'edit_item'          => 'Edit Website',
		'view_item'          => 'View Website',
		'all_items'          => 'All Websites',
		'search_items'       => 'Search Websites',
		'parent_item_colon'  => 'Parent Websites:',
		'not_found'          => 'No websites found.',
		'not_found_in_trash' => 'No websites found in Trash.'
   );
   
   protected static $_post_args = array(
		'labels'             => array(),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => 'stashbox',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'website' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 3,
		'supports'           => array( 'title' )
	);
   
   /**
    * Get the Domain ID of a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return integer
    */
   public static function get_domain( $post_id ) {
      return intval( get_post_meta( $post_id, 'domain', true ) );
   }
   
   /**
    * Get the Version Control System URL for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_vcs_url( $post_id ) {
      return get_post_meta( $post_id, 'vcs_url', true );
   }
   
   /**
    * Get the Login URL for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_login_url( $post_id ) {
      return get_post_meta( $post_id, 'login_url', true );
   }
   
   /**
    * Get the Admin Username for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_admin_user( $post_id ) {
      $username = get_post_meta( $post_id, 'admin_user', true );
      if( empty( $username ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $username );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the Admin Password for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_admin_pass( $post_id ) {
      $password = get_post_meta( $post_id, 'admin_pass', true );
      if( empty( $password ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $password );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the FTP Username for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_ftp_user( $post_id ) {
      $username = get_post_meta( $post_id, 'ftp_user', true );
      if( empty( $username ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $username );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the FTP Password for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_ftp_pass( $post_id ) {
      $password = get_post_meta( $post_id, 'ftp_pass', true );
      if( empty( $password ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $password );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the FTP Port for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_ftp_port( $post_id ) {
      return get_post_meta( $post_id, 'ftp_port', true );
   }
   
   /**
    * Get the DB Host for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_db_host( $post_id ) {
      return get_post_meta( $post_id, 'db_host', true );
   }
   
   /**
    * Get the DB Name for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_db_name( $post_id ) {
      return get_post_meta( $post_id, 'db_name', true );
   }
   
   /**
    * Get the DB Username for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_db_user( $post_id ) {
      $username = get_post_meta( $post_id, 'db_user', true );
      if( empty( $username ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $username );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the DB Password for a website.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_db_pass( $post_id ) {
      $password = get_post_meta( $post_id, 'db_pass', true );
      if( empty( $password ) ) {
         return '';
      }
      try {
         $decrypt = Encrypt::decrypt( $password );
         return $decrypt;
      } catch(Exception $e) {
         return '';
      }
   }
   
   /**
    * Get the Client ID of a certificate.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return integer
    */
   public static function get_client( $post_id ) {
      return intval( get_post_meta( $post_id, 'client_id', true ) );
   }
   
}