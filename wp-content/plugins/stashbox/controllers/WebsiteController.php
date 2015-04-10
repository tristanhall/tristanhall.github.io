<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;

class WebsiteController {
   
   /**
    * Load up Website JS & CSS.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      wp_register_script( 'stashbox-website', plugins_url( 'stashbox/js/stashbox.website.js' ), array( 'jquery' ), '1.0' );
      wp_enqueue_script( 'stashbox-website' );
   }
   
   /**
    * Add custom columns for Website posts.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_website_posts_columns( $columns ) {
      unset( $columns['wpseo-focuskw'] );
      unset( $columns['wpseo-score'] );
      unset( $columns['wpseo-title'] );
      unset( $columns['wpseo-metadesc'] );
      unset( $columns['date'] );
      $columns['domain'] = __( 'Domain', 'th' );
      $columns['login_url'] = __( 'Login URL', 'th' );
      $columns['vcs_url'] = __( 'VCS URL', 'th' );
      return $columns;
   }
   
   /**
    * Display the meta values for the custom Website post columns.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_website_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'domain':
            $domain = Website::get_domain( $post_id );
            if( !empty( $domain ) ) {
               echo edit_post_link( get_the_title( $domain ), '', '', $domain );
            } else {
               echo '&ndash;';
            }
            break;
         case 'login_url':
            $login_url = Website::get_login_url( $post_id );
            if( empty( $login_url ) ) {
               echo '&ndash;';
            } else {
               echo sprintf( '<a href="%1$s" target="_blank">%1$s</a>', $login_url );
            }
            break;
         case 'vcs_url':
            $vcs_url = Website::get_vcs_url( $post_id );
            $vcs_url_scheme = parse_url( $vcs_url, PHP_URL_SCHEME );
            $vcs_url_host = parse_url( $vcs_url, PHP_URL_HOST );
            if( empty( $vcs_url ) ) {
               echo '&ndash;';
            } else {
               echo sprintf( '<a href="%1$s" title="%1$s" target="_blank">%2$s://%3$s</a>', $vcs_url, $vcs_url_scheme, $vcs_url_host );
            }
            break;
      }
   }
   
   /**
    * Register the metaboxes for the Website posts.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes( $post ) {
      global $post;
      remove_meta_box( 'wpseo_meta', 'th_website', 'normal' );
      remove_meta_box( 'wordpress-https', 'th_website', 'side' );
      add_meta_box( 'th-website-info', __( 'Website Information', 'th' ), array( __CLASS__, 'mb_info' ), 'th_website', 'normal', 'core' );
      add_meta_box( 'th-website-ftp', __( 'FTP Information', 'th' ), array( __CLASS__, 'mb_ftp' ), 'th_website', 'normal', 'core' );
      add_meta_box( 'th-website-db', __( 'Database Information', 'th' ), array( __CLASS__, 'mb_db' ), 'th_website', 'normal', 'core' );
   }
   
   /**
    * Display the Website Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_info( $post ) {
      global $post;
      $domains = Domain::get_all();
      $tdata = array(
         'domain'     => Website::get_domain( $post->ID ),
         'vcs_url'    => Website::get_vcs_url( $post->ID ),
         'login_url'  => Website::get_login_url( $post->ID ),
         'admin_user' => Website::get_admin_user( $post->ID ),
         'admin_pass' => Website::get_admin_pass( $post->ID ),
         'domains'    => $domains
      );
      Template::make( 'website/mb-info', $tdata );
   }
   
   /**
    * Display the FTP Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_ftp( $post ) {
      global $post;
      $tdata = array(
         'ftp_user' => Website::get_ftp_user( $post->ID ),
         'ftp_pass' => Website::get_ftp_pass( $post->ID ),
         'ftp_port' => Website::get_ftp_port( $post->ID )
      );
      Template::make( 'website/mb-ftp', $tdata );
   }
   
   /**
    * Display the DB Information metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_db( $post ) {
      global $post;
      $tdata = array(
         'db_user' => Website::get_db_user( $post->ID ),
         'db_pass' => Website::get_db_pass( $post->ID ),
         'db_name' => Website::get_db_name( $post->ID ),
         'db_host' => Website::get_db_host( $post->ID )
      );
      Template::make( 'website/mb-db', $tdata );
   }
   
   /**
    * Save Post callback for the Website posts.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return void
    */
   public static function action_save_post( $post_id ) {
      if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-nonce' ), 'website' ) ) {
         return;
      }
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      $domain = filter_input( INPUT_POST, 'domain', FILTER_SANITIZE_NUMBER_INT );
      $vcs_url = filter_input( INPUT_POST, 'vcs_url', FILTER_SANITIZE_STRING );
      $login_url = filter_input( INPUT_POST, 'login_url', FILTER_SANITIZE_STRING );
      $admin_user = filter_input( INPUT_POST, 'admin_user', FILTER_SANITIZE_STRING );
      $admin_pass = filter_input( INPUT_POST, 'admin_pass', FILTER_SANITIZE_STRING );
      $ftp_user = filter_input( INPUT_POST, 'ftp_user', FILTER_SANITIZE_STRING );
      $ftp_pass = filter_input( INPUT_POST, 'ftp_pass', FILTER_SANITIZE_STRING );
      $ftp_port = filter_input( INPUT_POST, 'ftp_port', FILTER_SANITIZE_NUMBER_INT );
      $db_user = filter_input( INPUT_POST, 'db_user', FILTER_SANITIZE_STRING );
      $db_pass = filter_input( INPUT_POST, 'db_pass', FILTER_SANITIZE_STRING );
      $db_host = filter_input( INPUT_POST, 'db_host', FILTER_SANITIZE_STRING );
      $db_name = filter_input( INPUT_POST, 'db_name', FILTER_SANITIZE_STRING );
      update_post_meta( $post_id, 'domain', $domain );
      update_post_meta( $post_id, 'vcs_url', $vcs_url );
      update_post_meta( $post_id, 'login_url', $login_url );
      update_post_meta( $post_id, 'admin_user', Encrypt::encrypt( $admin_user ) );
      update_post_meta( $post_id, 'admin_pass', Encrypt::encrypt( $admin_pass ) );
      update_post_meta( $post_id, 'ftp_user', Encrypt::encrypt( $ftp_user ) );
      update_post_meta( $post_id, 'ftp_pass', Encrypt::encrypt( $ftp_pass ) );
      update_post_meta( $post_id, 'ftp_port', $ftp_port );
      update_post_meta( $post_id, 'db_user', Encrypt::encrypt( $db_user ) );
      update_post_meta( $post_id, 'db_pass', Encrypt::encrypt( $db_pass ) );
      update_post_meta( $post_id, 'db_host', $db_host );
      update_post_meta( $post_id, 'db_name', $db_name );
   }
   
}