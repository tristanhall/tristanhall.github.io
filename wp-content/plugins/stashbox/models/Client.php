<?php
namespace TH\Stashbox;

class Client extends \TH\WPAtomic\Post {
   
   protected static $_post_type = 'th_client';
   
   protected static $_post_labels = array(
		'name'               => 'Clients',
		'singular_name'      => 'Client',
		'menu_name'          => 'Clients',
		'name_admin_bar'     => 'Client',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Client',
		'new_item'           => 'New Client',
		'edit_item'          => 'Edit Client',
		'view_item'          => 'View Client',
		'all_items'          => 'All Clients',
		'search_items'       => 'Search Clients',
		'parent_item_colon'  => 'Parent Clients:',
		'not_found'          => 'No clients found.',
		'not_found_in_trash' => 'No clients found in Trash.'
   );
   
   protected static $_post_args = array(
		'labels'             => array(),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'client' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 30,
		'menu_icon'          => 'dashicons-businessman',
		'taxonomies'         => array( 'th_client_label' ),
		'supports'           => array( 'title' )
	);
   
   /**
    * Get the phone number of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_phone( $post_id ) {
      $phone = get_post_meta( $post_id, 'phone', true );
      return is_string( $phone ) ? $phone : '';
   }
   
   /**
    * Get the website of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_website( $post_id ) {
      $website = get_post_meta( $post_id, 'website', true );
      return is_string( $website ) ? $website : '';
   }
   
   /**
    * Get the Billing Address 1 of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_billing_address1( $post_id ) {
      $address1 = get_post_meta( $post_id, 'billing_address1', true );
      return is_string( $address1 ) ? $address1 : '';
   }
   
   /**
    * Get the Billing Address 2 of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_billing_address2( $post_id ) {
      $address2 = get_post_meta( $post_id, 'billing_address2', true );
      return is_string( $address2 ) ? $address2 : '';
   }
   
   /**
    * Get the Billing City of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_billing_city( $post_id ) {
      $city = get_post_meta( $post_id, 'billing_city', true );
      return is_string( $city ) ? $city : '';
   }
   
   /**
    * Get the Billing State of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_billing_state( $post_id ) {
      $state = get_post_meta( $post_id, 'billing_state', true );
      return is_string( $state ) ? $state : '';
   }
   
   /**
    * Get the Billing ZIP Code of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_billing_zip( $post_id ) {
      $zip = get_post_meta( $post_id, 'billing_zip', true );
      return is_string( $zip ) ? $zip : '';
   }
   
   /**
    * Get the Shipping Address 1 of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_shipping_address1( $post_id ) {
      $address1 = get_post_meta( $post_id, 'shipping_address1', true );
      return is_string( $address1 ) ? $address1 : '';
   }
   
   /**
    * Get the Shipping Address 2 of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_shipping_address2( $post_id ) {
      $address2 = get_post_meta( $post_id, 'shipping_address2', true );
      return is_string( $address2 ) ? $address2 : '';
   }
   
   /**
    * Get the Shipping City of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_shipping_city( $post_id ) {
      $city = get_post_meta( $post_id, 'shipping_city', true );
      return is_string( $city ) ? $city : '';
   }
   
   /**
    * Get the Shipping State of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_shipping_state( $post_id ) {
      $state = get_post_meta( $post_id, 'shipping_state', true );
      return is_string( $state ) ? $state : '';
   }
   
   /**
    * Get the Shipping ZIP Code of a Client.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_shipping_zip( $post_id ) {
      $zip = get_post_meta( $post_id, 'shipping_zip', true );
      return is_string( $zip ) ? $zip : '';
   }
   
}