<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;
use TH\Stashbox\Moment;

class SSLController {
   
   private static $scheduled_event_hook = 'stashbox_ssl_reminder_event';
   
   /**
    * Register hooks for the SSL Certificates.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function init() {
      add_action( self::$scheduled_event_hook, array( __CLASS__, 'cron_expiration_reminder' ) );
      add_filter( 'manage_edit-th_sslcertificate_sortable_columns', array( __CLASS__, 'manage_sortable_columns' ) );
   }
   
   /**
    * Load JS for Stashbox SSL Certificates.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      wp_register_script( 'stashbox-ssl', plugins_url( 'stashbox/js/stashbox.ssl.js' ), array( 'jquery' ), '1.0' );
      wp_enqueue_script( 'stashbox-ssl' );
   }
   
   /**
    * Register SSL Settings with Stashbox.
    * 
    * @access public
    * @static
    * @param array $settings
    * @return array
    */
   public static function filter_stashbox_register_settings( $settings ) {
      $settings['sb_ssl_reminders'] = 'boolval';
      $settings['sb_ssl_reminder_distance'] = 'intval';
      $settings['sb_ssl_reminder_recipient'] = 'sanitize_email';
      return $settings;
   }
   
   /**
    * Render the SSL Certificate settings fields.
    * 
    * @access public
    * @static
    * @param string $field_html
    * @return string
    */
   public static function filter_stashbox_settings_fields( $field_html ) {
      $tdata = array(
         'ssl_reminders'      => self::send_ssl_reminders(),
         'reminder_distance'  => self::get_reminder_distance(),
         'reminder_recipient' => self::get_reminder_recipient()
      );
      $field_html .= Template::make( 'ssl/row-settings', $tdata, false );
      return $field_html;
   }
   
   /**
    * Add custom columns to the SSL Certificate post table.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_sslcertificate_posts_columns( $columns ) {
      unset( $columns['date'] );
      $columns['domain'] = __( 'Domain', 'th' );
      $columns['expiration'] = __( 'Expiration Date', 'th' );
      return $columns;
   }
   
   /**
    * Display the meta values for the custom SSL Certificates post columns.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_sslcertificate_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'domain':
            $domain = SSL::get_domain( $post_id );
            if( !empty( $domain ) ) {
               echo edit_post_link( get_the_title( $domain ), '', '', $domain );
            } else {
               echo '&ndash;';
            }
            break;
         case 'expiration':
            $expires = SSL::get_expiration( $post_id );
            $expires_m = new Moment( $expires );
            $relative_expires = $expires_m->fromNow()->getRelative();
            echo sprintf( '%s<br><small>%s</small>', $expires_m->format( 'l, F j, Y' ), $relative_expires );
            break;
      }
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
      unset( $columns['wpseo-focuskw'] );
      unset( $columns['wpseo-score'] );
      unset( $columns['wpseo-title'] );
      unset( $columns['wpseo-metadesc'] );
      unset( $columns['date'] );
      $columns['expiration'] = 'expiration';
      return $columns;
   }
   
   /**
    * Modify the admin post query to allow sorting by expiration.
    * 
    * @access public
    * @static
    * @param object $query
    * @return void
    */
   public static function action_pre_get_posts(  $query ) {
      if( !is_admin() ) {
         return;
      }
      $orderby = $query->get( 'orderby');
      if( $orderby === 'expiration' ) {
         $query->set( 'meta_key', 'expiration' );
         $query->set( 'orderby', 'meta_DATETIME' );
      }
   }
   
   /**
    * Order posts by date.
    * 
    * @access public
    * @static
    * @param string $orderby
    * @param object $query
    * @return string
    */
   public static function filter_posts_orderby( $orderby, $query ) {
      global $wpdb;
      if( $query->get( 'meta_key' ) === 'expiration' ) {
         $sql_orderby = " CAST( $wpdb->postmeta.meta_value AS DATE ) " . $query->get( 'order' );
         return $sql_orderby;
      }
   }
   
   /**
    * Register metaboxes for SSL Certificate posts.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes() {
      remove_meta_box( 'wpseo_meta', 'th_sslcertificate', 'normal' );
      remove_meta_box( 'wordpress-https', 'th_sslcertificate', 'side' );
      add_meta_box( 'th-ssl-info', __( 'Certificate Information', 'th' ), array( __CLASS__, 'mb_info' ), 'th_sslcertificate', 'normal', 'core' );
   }
   
   /**
    * Display the SSL Certificate Info metabox.
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
         'domain'     => SSL::get_domain( $post->ID ),
         'expiration' => SSL::get_expiration( $post->ID ),
         'csr'        => SSL::get_csr( $post->ID ),
         'domains'    => $domains
      );
      Template::make( 'ssl/mb-info', $tdata );
   }
   
   /**
    * Save Post callback function for the SSL Certificate posts.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return void
    */
   public static function action_save_post( $post_id ) {
      if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-nonce' ), 'ssl' ) ) {
         return;
      }
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      $domain = filter_input( INPUT_POST, 'domain', FILTER_SANITIZE_NUMBER_INT );
      $expiration = filter_input( INPUT_POST, 'expiration', FILTER_SANITIZE_STRING );
      $csr = filter_input( INPUT_POST, 'csr', FILTER_SANITIZE_STRING );
      update_post_meta( $post_id, 'domain', $domain );
      update_post_meta( $post_id, 'expiration', $expiration );
      update_post_meta( $post_id, 'csr', $csr );
   }
   
   /**
    * Return true if SSL reminder emails are enabled. False if not.
    * 
    * @access public
    * @static
    * @return boolean
    */
   public static function send_ssl_reminders() {
      $ssl_reminders = get_option( 'sb_ssl_reminders' );
      return boolval( $ssl_reminders );
   }
   
   /**
    * Get the number of weeks ahead of time to warn about an expiring SSL.
    * 
    * @access public
    * @static
    * @return integer
    */
   public static function get_reminder_distance() {
      $reminder_distance = get_option( 'sb_ssl_reminder_distance' );
      $distance = intval( $reminder_distance );
      if( $distance < 1 ) {
         return 1;
      }
      return $distance;
   }
   
   /**
    * Get the recipient of the expiring SSL reminder emails.
    * 
    * @access public
    * @static
    * @return string
    */
   public static function get_reminder_recipient() {
      $recipient = get_option( 'sb_ssl_reminder_recipient' );
      if( empty( $recipient ) ) {
         $recipient = get_bloginfo( 'admin_email' );
      }
      return $recipient;
   }
   
   /**
    * Register a Weekly cron schedule for SSL Expiration reminders.
    * 
    * @access public
    * @static
    * @param array $schedules
    * @return array
    */
   public static function filter_cron_schedules( $schedules ) {
      if( isset( $schedules['weekly'] ) ) {
         return $schedules;
      }
      // Adds once weekly to the existing schedules.
      $schedules['weekly'] = array(
         'interval' => 604800,
         'display'  => __( 'Once Weekly', 'th' )
      );
      return $schedules;
   }
   
   /**
    * Setup the SSL Reminder Email scheduled event.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_wp() {
      $enable_reminders = self::send_ssl_reminders();
      $schedule = wp_get_schedule( self::$scheduled_event_hook );
      $next_occurence = wp_next_scheduled( self::$scheduled_event_hook );
      if( !$schedule && !$next_occurence && $enable_reminders ) {
         wp_schedule_event( time(), 'weekly', self::$scheduled_event_hook );
         return;
   	}
   	if( $schedule !== false && !$enable_reminders ) {
      	wp_unschedule_event( $next_occurence, self::$scheduled_event_hook );
      	return;
   	}
   }
   
   /**
    * Gather an array of SSL Certificates that are expiring soon and fire off a digest email.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function cron_expiration_reminder() {
      $certs = SSL::get_ssl_expirations();
      $min_distance = self::get_reminder_distance();
      $expiring_soon = array();
      foreach( $certs as $cert ) {
         $m = new Moment( $cert->expiration );
         $momentFromVo = $m->fromNow();
         $distance = $momentFromVo->getWeeks();
         //Subtract the time until expiration from the minimum warning window (weeks in advance to send reminders)
         $diff = $min_distance + $distance;
         //If the difference is greater than or equal to 0, expiration is closing in and we need to send a reminder.
         if( $diff >= 0 && $distance < 0 ) {
            $expiring_soon[] = $cert->ID;
         }
      }
      if( !empty( $expiring_soon ) ) {
         self::send_reminder_digest( $expiring_soon );
      }
   }
   
   /**
    * Sends a digest email with a list of certificates and their expiration dates.
    * 
    * @access private
    * @static
    * @param array $domains
    * @return void
    */
   private static function send_reminder_digest( $certificates ) {
      $reminder_recipient = self::get_reminder_recipient();
      $tdata = array(
         'site_name' => get_bloginfo( 'name' ),
         'certificates'   => $certificates
      );
      $admin_email = get_bloginfo( 'admin_email' );
      $addl_headers = array(
         'Reply-To' => $admin_email,
         'From'     => sprintf( __( 'Stashbox - %s <%s>', 'th' ), $tdata['site_name'], $admin_email )
      );
      $message = Template::make( 'ssl/email-expiration_reminder', $tdata, false );
      add_filter( 'wp_mail_content_type', array( __CLASS__, 'send_html_mail' ) );
      $sent = wp_mail( $reminder_recipient, __( 'Stashbox Expiring SSL Reminder', 'th' ), $message, $addl_headers );
      if( !$sent ) {
         remove_filter( 'wp_mail_content_type', array( __CLASS__, 'send_html_mail' ) );
         error_log( 'Failed to send message. Result: '.serialize( $sent ) );
         return false;
      } else {
         remove_filter( 'wp_mail_content_type', array( __CLASS__, 'send_html_mail' ) );
         return true;
      }
   }
   
   /**
    * Set the WP Mail Content Type to HTML.
    * 
    * @access public
    * @static
    * @param string $content_type
    * @return string
    */
   public static function send_html_mail( $content_type ) {
      return 'text/html';
   }
   
   /**
    * AJAX handler for firing off a test reminder email.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_wp_ajax_stashbox_ssl_test_reminder() {
      if( !is_user_logged_in() ) {
         wp_die( 'You do not have permission to access this page.' );
      }
      global $wpdb;
      $certs = $wpdb->get_col( 'SELECT ID FROM '.$wpdb->posts.' WHERE post_type = "th_sslcertificate" AND post_status = "publish" ORDER BY post_title ASC' );
      $sent = self::send_reminder_digest( $certs );
      header( 'Content-Type: application/json' );
      if( !$sent ) {
         echo json_encode( array( 'status' => 'failure', 'affected' => $certs ) );
      } else {
         echo json_encode( array( 'status' => 'success', 'affected' => $certs ) );
      }
      exit();
   }
   
}