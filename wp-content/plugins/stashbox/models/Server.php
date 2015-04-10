<?php
namespace TH\Stashbox;

use JJG\Ping;

class Server extends \TH\WPAtomic\Post {
   
   protected static $_post_type = 'th_server';
   
   protected static $_post_labels = array(
		'name'               => 'Servers',
		'singular_name'      => 'Server',
		'menu_name'          => 'Servers',
		'name_admin_bar'     => 'Server',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Server',
		'new_item'           => 'New Server',
		'edit_item'          => 'Edit Server',
		'view_item'          => 'View Server',
		'all_items'          => 'All Servers',
		'search_items'       => 'Search Servers',
		'parent_item_colon'  => 'Parent Servers:',
		'not_found'          => 'No servers found.',
		'not_found_in_trash' => 'No servers found in Trash.'
   );
   
   protected static $_post_args = array(
		'labels'             => array(),
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => 'stashbox',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'server' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 3,
		'supports'           => array( 'title' ),
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
    * Get the hostname of a server.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return array
    */
   public static function get_hostname( $post_id ) {
      $hostname = get_post_meta( $post_id, 'hostname', true );
      if( !is_string( $hostname ) ) {
         return '';
      }
      return $hostname;
   }
   
   /**
    * Get the vendor of a server.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return array
    */
   public static function get_vendor( $post_id ) {
      $vendor = get_post_meta( $post_id, 'vendor', true );
      if( !is_string( $vendor ) ) {
         return '';
      }
      return $vendor;
   }
   
   /**
    * Return true if the PING check is enabled for a server. False if not enabled.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return bool
    */
   public static function get_enable_ping( $post_id ) {
      $enable_ping = get_post_meta( $post_id, 'enable_ping', true );
      $bool_val = filter_var( $enable_ping, FILTER_VALIDATE_BOOLEAN );
      return $bool_val;
   }
   
   /**
    * Get the IP Address Pool of a server.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return array
    */
   public static function get_ip_pool( $post_id ) {
      $ip_pool = get_post_meta( $post_id, 'ip_pool', true );
      if( !is_array( $ip_pool ) ) {
         return array();
      }
      return $ip_pool;
   }
   
   /**
    * Get the root password for a server.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return string
    */
   public static function get_root_pass( $post_id ) {
      $password = get_post_meta( $post_id, 'root_pass', true );
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
    * Get the method to use for PING checks.
    * 
    * @access public
    * @static
    * @return string
    */
   public static function get_ping_method() {
      $method = get_option( 'sb_ping_method' );
      if( empty( $method ) ) {
         return 'exec';
      }
      return $method;
   }
   
   /**
    * Test the PING response of a server.
    * 
    * @access public
    * @static
    * @param mixed $server_id
    * @return integer
    */
   public static function ping( $post_id ) {
      $host = Server::get_hostname( $post_id );
      $method = Server::get_ping_method();
      //Don't ping an empty hostname
      if( empty( $host ) ) {
         return false;
      }
      $ping = new Ping( $host );
      $latency = $ping->ping( $method );
      //Return false for no response or return the latency.
      if( $latency === false ) {
         return false;
      } else {
         return $latency;
      }
   }
   
}