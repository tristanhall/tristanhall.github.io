<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class ServerController {
   
   /**
    * Load JS/CSS for the Stashbox Server object.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      wp_register_style( 'stashbox-server', plugins_url( 'stashbox/css/stashbox.server.css' ) );
      wp_enqueue_style( 'stashbox-server' );
   }
   
   /**
    * Register Server Settings with Stashbox.
    * 
    * @access public
    * @static
    * @param array $settings
    * @return array
    */
   public static function filter_stashbox_register_settings( $settings ) {
      $settings['sb_ping_method'] = 'sanitize_text_field';
      return $settings;
   }
   
   /**
    * Render the Server Certificate settings fields.
    * 
    * @access public
    * @static
    * @param string $field_html
    * @return string
    */
   public static function filter_stashbox_settings_fields( $field_html ) {
      $tdata = array(
         'ping_method' => Server::get_ping_method()
      );
      $field_html .= Template::make( 'server/row-settings', $tdata, false );
      return $field_html;
   }
   
   /**
    * Add custom columns to the server post type.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_server_posts_columns( $columns ) {
      unset( $columns['wpseo-focuskw'] );
      unset( $columns['wpseo-score'] );
      unset( $columns['wpseo-title'] );
      unset( $columns['wpseo-metadesc'] );
      unset( $columns['date'] );
      $columns['hostname'] = __( 'Hostname', 'th' );
      $columns['ping_check'] = __( 'PING Check', 'th' );
      $columns['ip_pool'] = __( 'IP Pool', 'th' );
      $columns['vendor'] = __( 'Vendor', 'th' );
      return $columns;
   }
   
   /**
    * Display the meta data for the custom post columns.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_server_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'hostname':
            $hostname = Server::get_hostname( $post_id );
            if( empty( $hostname ) ) {
               echo '&ndash;';
            } else {
               echo $hostname;
            }
            break;
         case 'ip_pool':
            $ip_pool = Server::get_ip_pool( $post_id );
            if( empty( $ip_pool ) ) {
               echo '&ndash;';
            } else {
               $ip_pool = array_map( 'trim', $ip_pool );
               echo implode( ', ', $ip_pool );
            }
            break;
         case 'vendor':
            $vendor = Server::get_vendor( $post_id );
            if( empty( $vendor ) ) {
               echo '&ndash;';
            } else {
               echo $vendor;
            }
            break;
         case 'ping_check':
            $ping_enabled = Server::get_enable_ping( $post_id );
            if( $ping_enabled ) {
               $host = Server::get_hostname( $post_id );
               if( empty( $host ) ) {
                  echo '&ndash;';
                  break;
               }
               $latency = Server::ping( $post_id );
               if( $latency === false ) {
                  _e( '<i class="stashbox-ping-fail"></i>&nbsp;Not responding.', 'th' );
               } else {
                  echo sprintf( __( '<i class="stashbox-ping-success"></i>&nbsp;%dms', 'th' ), $latency );
               }
            } else {
               echo '&ndash;';
            }
            break;
      }
   }
   
   /**
    * Register metaboxes for the Server post type.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes( $post ) {
      global $post;
      remove_meta_box( 'wpseo_meta', 'th_server', 'normal' );
      remove_meta_box( 'wordpress-https', 'th_server', 'side' );
      add_meta_box( 'stashbox-server-info', __( 'Server Information', 'th' ), array( __CLASS__, 'mb_info' ), 'th_server', 'normal', 'core' );
      if( Server::get_enable_ping( $post->ID ) ) {
         add_meta_box( 'stashbox-server-ping', __( 'PING Check', 'th' ), array( __CLASS__, 'mb_ping' ), 'th_server', 'side', 'default' );
      }
   }
   
   /**
    * Display the Server Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_info( $post ) {
      global $post;
      $tdata = array(
         'ip_pool'     => Server::get_ip_pool( $post->ID ),
         'root_pass'   => Server::get_root_pass( $post->ID ),
         'vendor'      => Server::get_vendor( $post->ID ),
         'hostname'    => Server::get_hostname( $post->ID ),
         'enable_ping' => Server::get_enable_ping( $post->ID )
      );
      Template::make( 'server/mb-info', $tdata );
   }
   
   /**
    * Display the PING check metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_ping( $post ) {
      global $post;
      $tdata = array(
         'latency' => Server::ping( $post->ID )
      );
      Template::make( 'server/mb-ping', $tdata );
   }
   
   /**
    * Save Post callback for the Server posts.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return void
    */
   public static function action_save_post( $post_id ) {
      if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-nonce' ), 'server' ) ) {
         return;
      }
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      $ip_pool = filter_input( INPUT_POST, 'ip_pool', FILTER_SANITIZE_STRING );
      $vendor = filter_input( INPUT_POST, 'vendor', FILTER_SANITIZE_STRING );
      $hostname = filter_input( INPUT_POST, 'hostname', FILTER_SANITIZE_STRING );
      $root_pass = filter_input( INPUT_POST, 'root_pass', FILTER_SANITIZE_STRING );
      $enable_ping = filter_input( INPUT_POST, 'enable_ping', FILTER_VALIDATE_BOOLEAN );
      update_post_meta( $post_id, 'ip_pool', explode( "\n", $ip_pool ) );
      update_post_meta( $post_id, 'hostname', $hostname );
      update_post_meta( $post_id, 'vendor', $vendor );
      update_post_meta( $post_id, 'enable_ping', $enable_ping );
      update_post_meta( $post_id, 'root_pass', Encrypt::encrypt( $root_pass ) );
   }
   
}