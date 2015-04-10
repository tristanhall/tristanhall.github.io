<?php
namespace TH\Stashbox;

class Domain extends \TH\WPAtomic\Post {
   
   protected static $_post_type = 'th_domain';
   
   protected static $_post_labels = array(
		'name'               => 'Domains',
		'singular_name'      => 'Domain',
		'menu_name'          => 'Domains',
		'name_admin_bar'     => 'Domain',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Domain',
		'new_item'           => 'New Domain',
		'edit_item'          => 'Edit Domain',
		'view_item'          => 'View Domain',
		'all_items'          => 'All Domains',
		'search_items'       => 'Search Domains',
		'parent_item_colon'  => 'Parent Domains:',
		'not_found'          => 'No domains found.',
		'not_found_in_trash' => 'No domains found in Trash.'
   );
   
   protected static $_post_args = array(
		'labels'             => array(),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => 'stashbox',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'domain' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 3,
		'supports'           => array( 'title' )
	);
   
   /**
    * Retrieve the DNS records for a domain name.
    * 
    * @access public
    * @static
    * @param string $domain
    * @return array
    */
   public static function get_dns_records( $domain, $type = DNS_ANY ) {
      $records = dns_get_record( $domain, $type );
      if( !is_array( $records ) ) {
         return array();
      }
      return $records;
   }
   
   /**
    * Validate whether or not a domain is a FQDN.
    * 
    * @access public
    * @static
    * @param string $domain
    * @return string
    */
   public static function is_fqdn( $domain ) {
      return ( !empty( $domain ) && preg_match( '/(?=^.{1,253}$)(^(((?!-)[a-zA-Z0-9-]{1,63}(?<!-))|((?!-)[a-zA-Z0-9-]{1,63}(?<!-)\.)+[a-zA-Z]{2,63})$)/', $domain ) > 0 );
   }
   
   /**
    * Retrieve a list of all published Domain posts and their expiration dates.
    * 
    * @access public
    * @static
    * @return array
    */
   public static function get_domain_expirations() {
      global $wpdb;
      $query = 'SELECT p.ID, pm.meta_value AS expiration FROM `'.$wpdb->posts.'` p LEFT JOIN `'.$wpdb->postmeta.'` pm ON pm.post_id = p.ID WHERE pm.meta_key = "expiration" AND p.post_status = "publish" AND p.post_type = "th_domain" ORDER BY p.ID ASC';
      $posts = $wpdb->get_results( $query );
      return is_array( $posts ) ? $posts : array();
   }
   
   /**
    * Get the expiration date of a domain.
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
    * Get the Registrar of a domain.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_registrar( $post_id ) {
      return get_post_meta( $post_id, 'registrar', true );
   }
   
   /**
    * Get the username of a domain.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_username( $post_id ) {
      $username = get_post_meta( $post_id, 'username', true );
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
    * Get the password for a domain.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_password( $post_id ) {
      $password = get_post_meta( $post_id, 'password', true );
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