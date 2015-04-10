<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class ClientController {
   
   /**
    * Define which post types can assign a client record.
    * 
    * @var array
    * @access private
    * @static
    */
   private static $post_types = array(
      'th_domain',
      'th_server',
      'th_website',
      'th_sslcertificate'
   );
   
   /**
    * Register hooks for the SSL Certificates.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function init() {
      add_filter( 'manage_edit-th_domain_sortable_columns', array( __CLASS__, 'manage_sortable_columns' ) );
      add_filter( 'manage_edit-th_sslcertificate_sortable_columns', array( __CLASS__, 'manage_sortable_columns' ) );
      add_filter( 'manage_edit-th_website_sortable_columns', array( __CLASS__, 'manage_sortable_columns' ) );
   }
   
   /**
    * Modify the sortable columns on the post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function manage_sortable_columns( $columns ) {
      $columns['client'] = 'client';
      return $columns;
   }
   
   /**
    * Modify the admin post query to allow searching by client names.
    * 
    * @access public
    * @static
    * @param object $query
    * @return void
    */
   public static function action_pre_get_posts( $query ) {
      if( !is_admin() ) {
         return;
      }
      $searchterm = $query->query_vars['s'];
      // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
      $query->query_vars['s'] = "";
      if( !empty( $searchterm ) && in_array( $query->query_vars['post_type'], self::$post_types ) ) {
         $meta_query = array( 'relation' => 'OR' );
         $meta_query[] = array(
            'key'     => 'client_name',
            'value'   => $searchterm,
            'compare' => 'LIKE'
         );
         $query->set( 'meta_query', $meta_query );
      }
   }
    /**
    * Modify the admin post query to allow sorting by client names.
    * 
    * @access public
    * @static
    * @param object $query
    * @return void
    */
   public static function filter_request( $vars ) {
      if( isset( $vars['orderby'] ) && $vars['orderby'] == 'client' ) {
         $vars = array_merge( $vars, array(
            'meta_key' => 'client_name',
            'orderby'  => 'meta_value'
         ) );
      }
      return $vars;
   }
   
   public static function action_admin_enqueue_scripts() {
      wp_register_style( 'chosen', plugins_url( 'stashbox/css/chosen.css' ) );
      wp_enqueue_style( 'chosen' );
      wp_register_script( 'chosen', plugins_url( 'stashbox/js/chosen.jquery.min.js' ), array( 'jquery' ), '1.0' );
      wp_enqueue_script( 'chosen' );
      wp_register_script( 'stashbox-client', plugins_url( 'stashbox/js/stashbox.client.js' ), array( 'jquery', 'chosen' ), '1.0' );
      wp_enqueue_script( 'stashbox-client' );
   }
   
   /**
    * Set custom columns on the post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_client_posts_columns( $columns ) {
      unset( $columns['date'] );
      unset( $columns['wpseo-focuskw'] );
      unset( $columns['wpseo-score'] );
      unset( $columns['wpseo-title'] );
      unset( $columns['wpseo-metadesc'] );
      $columns['primary_contact'] = __( 'Primary Contact', 'th' );
      $columns['phone'] = __( 'Phone', 'th' );
      $columns['website'] = __( 'Website', 'th' );
      return $columns;
   }
   
   /**
    * Display the custom post meta for the Client posts.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_client_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'primary_contact':
            break;
         case 'phone':
            $phone = Client::get_phone( $post_id );
            echo empty( $phone ) ? '&ndash;' :  $phone;
            break;
         case 'website':
            $site = Client::get_website( $post_id );
            echo empty( $site ) ? '&ndash;' :  sprintf( '<a href="%1$s" target="_blank">%1$s</a>', $site );
            break;
      }
   }
   
   /**
    * Set custom columns on the Domain post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_domain_posts_columns( $columns ) {
      $columns['client'] = __( 'Client', 'th' );
      return $columns;
   }
   
   /**
    * Display the client post meta for the Domain posts.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_domain_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'client':
            $client_id = Domain::get_client( $post_id );
            if( !empty( $client_id ) ) {
               echo edit_post_link( get_the_title( $client_id ), '', '', $client_id );
            } else {
               echo '&ndash;';
            }
            break;
      }
   }
   
   /**
    * Set custom columns on the Server post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_server_posts_columns( $columns ) {
      $columns['client'] = __( 'Client', 'th' );
      return $columns;
   }
   
   /**
    * Display the client post meta for the Server posts.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_server_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'client':
            $client_id = Server::get_client( $post_id );
            if( !empty( $client_id ) ) {
               echo edit_post_link( get_the_title( $client_id ), '', '', $client_id );
            } else {
               echo '&ndash;';
            }
            break;
      }
   }
   
   /**
    * Set custom columns on the SSL Cert post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_sslcertificate_posts_columns( $columns ) {
      $columns['client'] = __( 'Client', 'th' );
      return $columns;
   }
   
   /**
    * Display the client post meta for the SSL posts.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_sslcertificate_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'client':
            $client_id = SSL::get_client( $post_id );
            if( !empty( $client_id ) ) {
               echo edit_post_link( get_the_title( $client_id ), '', '', $client_id );
            } else {
               echo '&ndash;';
            }
            break;
      }
   }
   
   /**
    * Set custom columns on the Website post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_website_posts_columns( $columns ) {
      $columns['client'] = __( 'Client', 'th' );
      return $columns;
   }
   
   /**
    * Display the client post meta for the Website posts.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_website_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'client':
            $client_id = Website::get_client( $post_id );
            if( !empty( $client_id ) ) {
               echo edit_post_link( get_the_title( $client_id ), '', '', $client_id );
            } else {
               echo '&ndash;';
            }
            break;
      }
   }
   
   /**
    * Callback function for registering metaboxes for the Client post type.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes() {
      remove_meta_box( 'wpseo_meta', 'th_client', 'normal' );
      remove_meta_box( 'wordpress-https', 'th_client', 'side' );
      add_meta_box( 'th-client-info', __( 'Client Information', 'th' ), array( __CLASS__, 'mb_info' ), 'th_client', 'normal', 'core' );
      add_meta_box( 'th-client-billing', __( 'Billing Information', 'th' ), array( __CLASS__, 'mb_billing' ), 'th_client', 'normal', 'core' );
      add_meta_box( 'th-client-shipping', __( 'Shipping Information', 'th' ), array( __CLASS__, 'mb_shipping' ), 'th_client', 'normal', 'core' );
      foreach( self::$post_types as $type ) {
         add_meta_box( 'th-client-choose', __( 'Assign to Client', 'th' ), array( __CLASS__, 'mb_chooseclient' ), $type, 'side', 'core' );
      }
   }
   
   /**
    * Save post callback for the Client post type and for the Client ID value of other post types.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return void
    */
   public static function action_save_post( $post_id ) {
      global $wpdb;
      $post_type = get_post_type( $post_id );
      if( $post_type !== 'th_client' ) {
         if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-client-nonce' ), 'assign' ) ) {
            return;
         }
         if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
         }
         $client_id = filter_input( INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT );
         update_post_meta( $post_id, 'client_id', $client_id );
         update_post_meta( $post_id, 'client_name', get_the_title( $client_id ) );
         return;
      }
      if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-nonce' ), 'client' ) ) {
         return;
      }
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      $phone = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );
      $website = filter_input( INPUT_POST, 'website', FILTER_SANITIZE_STRING );
      $bill_address1 = filter_input( INPUT_POST, 'bill_address1', FILTER_SANITIZE_STRING );
      $bill_address2 = filter_input( INPUT_POST, 'bill_address2', FILTER_SANITIZE_STRING );
      $bill_city = filter_input( INPUT_POST, 'bill_city', FILTER_SANITIZE_STRING );
      $bill_state = filter_input( INPUT_POST, 'bill_state', FILTER_SANITIZE_STRING );
      $bill_zip = filter_input( INPUT_POST, 'bill_zip', FILTER_SANITIZE_STRING );
      $ship_address1 = filter_input( INPUT_POST, 'ship_address1', FILTER_SANITIZE_STRING );
      $ship_address2 = filter_input( INPUT_POST, 'ship_address2', FILTER_SANITIZE_STRING );
      $ship_city = filter_input( INPUT_POST, 'ship_city', FILTER_SANITIZE_STRING );
      $ship_state = filter_input( INPUT_POST, 'ship_state', FILTER_SANITIZE_STRING );
      $ship_zip = filter_input( INPUT_POST, 'ship_zip', FILTER_SANITIZE_STRING );
      update_post_meta( $post_id, 'phone', $phone );
      update_post_meta( $post_id, 'website', $website );
      update_post_meta( $post_id, 'billing_address1', $bill_address1 );
      update_post_meta( $post_id, 'billing_address2', $bill_address2 );
      update_post_meta( $post_id, 'billing_city', $bill_city );
      update_post_meta( $post_id, 'billing_state', $bill_state );
      update_post_meta( $post_id, 'billing_zip', $bill_zip );
      update_post_meta( $post_id, 'shipping_address1', $ship_address1 );
      update_post_meta( $post_id, 'shipping_address2', $ship_address2 );
      update_post_meta( $post_id, 'shipping_city', $ship_city );
      update_post_meta( $post_id, 'shipping_state', $ship_state );
      update_post_meta( $post_id, 'shipping_zip', $ship_zip );
      //Update the names of all of the clients attached to other posts
      $wpdb->update( $wpdb->postmeta, array( 'meta_value' => get_the_title( $post_id ) ), array( 'meta_value' => $post_id, 'meta_key' => 'client_id' ) );
   }
   
   /**
    * Display the Client Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_info( $post ) {
      $tdata = array(
         'phone'   => Client::get_phone( $post->ID ),
         'website' => Client::get_website( $post->ID )
      );
      Template::make( 'client/mb-info', $tdata );
   }
   
   /**
    * Display the Billing Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_billing( $post ) {
      $tdata = array(
         'address1' => Client::get_billing_address1( $post->ID ),
         'address2' => Client::get_billing_address2( $post->ID ),
         'city'     => Client::get_billing_city( $post->ID ),
         'state'    => Client::get_billing_state( $post->ID ),
         'zip'      => Client::get_billing_zip( $post->ID )
      );
      Template::make( 'client/mb-billing', $tdata );
   }
   
   /**
    * Display the Shipping Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_shipping( $post ) {
      $tdata = array(
         'address1' => Client::get_shipping_address1( $post->ID ),
         'address2' => Client::get_shipping_address2( $post->ID ),
         'city'     => Client::get_shipping_city( $post->ID ),
         'state'    => Client::get_shipping_state( $post->ID ),
         'zip'      => Client::get_shipping_zip( $post->ID )
      );
      Template::make( 'client/mb-shipping', $tdata );
   }
   
   /**
    * Display the Assign to Client metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_chooseclient( $post ) {
      $clients = Client::get_all();
      $tdata = array(
         'client_id' => intval( get_post_meta( $post->ID, 'client_id', true ) ),
         'clients'   => $clients
      );
      Template::make( 'client/mb-chooseclient', $tdata );
   }
   
}