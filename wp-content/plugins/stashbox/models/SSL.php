<?php
namespace TH\Stashbox;

class SSL extends \TH\WPAtomic\Post {
   
   protected static $_post_type = 'th_sslcertificate';
   
   protected static $_post_labels = array(
		'name'               => 'SSL Certificates',
		'singular_name'      => 'SSL Certificate',
		'menu_name'          => 'SSL Certificates',
		'name_admin_bar'     => 'SSL Certificate',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New SSL Certificate',
		'new_item'           => 'New SSL Certificate',
		'edit_item'          => 'Edit SSL Certificate',
		'view_item'          => 'View SSL Certificate',
		'all_items'          => 'All SSL Certificates',
		'search_items'       => 'Search SSL Certificates',
		'parent_item_colon'  => 'Parent SSL Certificates:',
		'not_found'          => 'No certificates found.',
		'not_found_in_trash' => 'No certificates found in Trash.'
   );
   
   protected static $_post_args = array(
		'labels'             => array(),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => 'stashbox',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'certificate' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 3,
		'supports'           => array( 'title' )
	);
   
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
   
   /**
    * Get the Domain ID of a certificate.
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
    * Get the CSR value for a certificate.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_csr( $post_id ) {
      return get_post_meta( $post_id, 'csr', true );
   }
   
   /**
    * Get the expiration date for a certificate.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_expiration( $post_id ) {
      return get_post_meta( $post_id, 'expiration', true );
   }
   
   /**
    * Retrieve a list of all published SSL posts and their expiration dates.
    * 
    * @access public
    * @static
    * @return array
    */
   public static function get_ssl_expirations() {
      global $wpdb;
      $query = 'SELECT p.ID, pm.meta_value AS expiration FROM `'.$wpdb->posts.'` p LEFT JOIN `'.$wpdb->postmeta.'` pm ON pm.post_id = p.ID WHERE pm.meta_key = "expiration" AND p.post_status = "publish" AND p.post_type = "th_sslcertificate" ORDER BY p.ID ASC';
      $posts = $wpdb->get_results( $query );
      return is_array( $posts ) ? $posts : array();
   }
   
}