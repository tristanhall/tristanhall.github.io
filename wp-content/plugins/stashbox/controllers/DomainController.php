<?php
namespace TH\Stashbox;

use TH\WPAtomic\Template;
use TH\Stashbox\Moment;

class DomainController {
   
   private static $scheduled_event_hook = 'stashbox_domain_reminder';
   
   /**
    * Register hooks for the Domains.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function init() {
      add_action( self::$scheduled_event_hook, array( __CLASS__, 'cron_expiration_reminder' ) );
      add_filter( 'manage_edit-th_domain_sortable_columns', array( __CLASS__, 'manage_sortable_columns' ) );
   }
   
   /**
    * Load JS for Stashbox domains.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_admin_enqueue_scripts() {
      wp_register_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css' );
      wp_enqueue_style( 'jquery-ui' );
      wp_register_style( 'chosen', plugins_url( 'stashbox/css/chosen.css' ) );
      wp_enqueue_style( 'chosen' );
      wp_register_script( 'chosen', plugins_url( 'stashbox/js/chosen.jquery.min.js' ), array( 'jquery' ), '1.0' );
      wp_enqueue_script( 'chosen' );
      wp_register_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js' );
      wp_enqueue_script( 'jquery-ui' );
      wp_register_script( 'stashbox-domain', plugins_url( 'stashbox/js/stashbox.domain.js' ), array( 'jquery', 'jquery-ui', 'chosen' ), '1.0' );
      wp_enqueue_script( 'stashbox-domain' );
   }
   
   /**
    * Register Domain Settings with Stashbox.
    * 
    * @access public
    * @static
    * @param array $settings
    * @return array
    */
   public static function filter_stashbox_register_settings( $settings ) {
      $settings['sb_domain_reminders'] = 'boolval';
      $settings['sb_domain_reminder_distance'] = 'intval';
      $settings['sb_domain_reminder_recipient'] = 'sanitize_email';
      return $settings;
   }
   
   /**
    * Append the Domain Settings fields to the settings form.
    * 
    * @access public
    * @static
    * @param string $field_html
    * @return string
    */
   public static function filter_stashbox_settings_fields( $field_html ) {
      $tdata = array(
         'domain_reminders'   => self::send_domain_reminders(),
         'reminder_distance'  => self::get_reminder_distance(),
         'reminder_recipient' => self::get_reminder_recipient()
      );
      $field_html .= Template::make( 'domain/row-settings', $tdata, false );
      return $field_html;
   }
   
   /**
    * Add custom columns to the domain post type.
    * 
    * @access public
    * @static
    * @param array $columns
    * @return array
    */
   public static function filter_manage_th_domain_posts_columns( $columns ) {
      unset( $columns['wpseo-focuskw'] );
      unset( $columns['wpseo-score'] );
      unset( $columns['wpseo-title'] );
      unset( $columns['wpseo-metadesc'] );
      unset( $columns['date'] );
      $columns['registrar'] = __( 'Registrar', 'th' );
      $columns['expiration'] = __( 'Expiration Date', 'th' );
      return $columns;
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
      $columns['registrar'] = 'registrar';
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
   public static function filter_request( $vars ) {
      if( isset( $vars['orderby'] ) && $vars['orderby'] == 'expiration' ) {
         $vars['orderby'] = 'meta_value';
         $vars['meta_key'] = 'expiration';
      }
      if( isset( $vars['orderby'] ) && $vars['orderby'] == 'registrar' ) {
         $vars['orderby'] = 'meta_value';
         $vars['meta_key'] = 'registrar';
      }
      return $vars;
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
    * Display the meta data for the custom post columns.
    * 
    * @access public
    * @static
    * @param string $column
    * @param integer $post_id
    * @return void
    */
   public static function action_manage_th_domain_posts_custom_column( $column, $post_id ) {
      switch( $column ) {
         case 'registrar':
            $registrar = Domain::get_registrar( $post_id );
            echo empty( $registrar ) ? '&ndash;' : $registrar;
            break;
         case 'expiration':
            $expires = Domain::get_expiration( $post_id );
            if( empty( $expires ) ) {
               echo '&ndash;';
               break;
            }
            $expires_m = new Moment( $expires );
            $relative_expires = $expires_m->fromNow()->getRelative();
            $formatted_expiration = $expires_m->format( 'l, F j, Y' );
            echo $formatted_expiration;
            if( !empty( $relative_expires ) && trim( $relative_expires ) !== 'in' ) {
               echo sprintf( '<br><small>%s</small>', $relative_expires );
            }
            break;
      }
   }
   
   /**
    * Callback function for registering metaboxes for the Domain post type.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes( $post ) {
      remove_meta_box( 'wpseo_meta', 'th_domain', 'normal' );
      remove_meta_box( 'wordpress-https', 'th_domain', 'side' );
      add_meta_box( 'th-domain-info', __( 'Domain Information', 'th' ), array( __CLASS__, 'mb_info' ), 'th_domain', 'normal', 'core' );
      add_meta_box( 'th-domain-dns', __( 'DNS Records', 'th' ), array( __CLASS__, 'mb_dns' ), 'th_domain', 'normal', 'core' );
   }
   
   /**
    * Callback function to display the Info metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_info( $post ) {
      global $post;
      $tdata = array(
         'registrar'  => Domain::get_registrar( $post->ID ),
         'expiration' => Domain::get_expiration( $post->ID ),
         'username'   => Domain::get_username( $post->ID ),
         'password'   => Domain::get_password( $post->ID )
      );
      Template::make( 'domain/mb-info', $tdata );
   }
   
   /**
    * Callback function to display the DNS record metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_dns( $post ) {
      global $post;
      if( Domain::is_fqdn( $post->post_title ) ) {
         $a_records = Domain::get_dns_records( $post->post_title, DNS_A );
         $aaaa_records = Domain::get_dns_records( $post->post_title, DNS_AAAA );
         $cname_records = Domain::get_dns_records( $post->post_title, DNS_CNAME );
         $mx_records = Domain::get_dns_records( $post->post_title, DNS_MX );
         $txt_records = Domain::get_dns_records( $post->post_title, DNS_TXT );
         $srv_records = Domain::get_dns_records( $post->post_title, DNS_SRV );
         $name_servers = Domain::get_dns_records( $post->post_title, DNS_NS );
         $tdata = array(
            'a_records'     => array_merge( $a_records, $aaaa_records ),
            'cname_records' => $cname_records,
            'mx_records'    => $mx_records,
            'txt_records'   => $txt_records,
            'srv_records'   => $srv_records,
            'name_servers'  => $name_servers
         );
         Template::make( 'domain/mb-dns', $tdata );
      } else {
         _e( 'This is not a Fully Qualified Domain Name.', 'th' );
      }
   }
   
   /**
    * Save Post callback for the Domain posts.
    * 
    * @access public
    * @static
    * @param integer $post_id
    * @return void
    */
   public static function action_save_post( $post_id ) {
      if( !wp_verify_nonce( filter_input( INPUT_POST, 'stashbox-nonce' ), 'domain' ) ) {
         return;
      }
      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      $registrar = filter_input( INPUT_POST, 'registrar', FILTER_SANITIZE_STRING );
      $expiration = filter_input( INPUT_POST, 'expiration', FILTER_SANITIZE_STRING );
      $username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
      $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
      update_post_meta( $post_id, 'registrar', $registrar );
      update_post_meta( $post_id, 'expiration', $expiration );
      update_post_meta( $post_id, 'username', Encrypt::encrypt( $username ) );
      update_post_meta( $post_id, 'password', Encrypt::encrypt( $password ) );
   }
   
   /**
    * Return true if Domain expiration reminder emails are enabled. False is not.
    * 
    * @access public
    * @static
    * @return boolean
    */
   public static function send_domain_reminders() {
      $domain_reminders = get_option( 'sb_domain_reminders' );
      return boolval( $domain_reminders );
   }
   
   /**
    * Get the number of weeks ahead of time to warn about an expiring domain.
    * 
    * @access public
    * @static
    * @return integer
    */
   public static function get_reminder_distance() {
      $reminder_distance = get_option( 'sb_domain_reminder_distance' );
      $distance = intval( $reminder_distance );
      if( $distance < 1 ) {
         return 1;
      }
      return $distance;
   }
   
   /**
    * Get the recipient of the expiring domain reminder emails.
    * 
    * @access public
    * @static
    * @return string
    */
   public static function get_reminder_recipient() {
      $recipient = get_option( 'sb_domain_reminder_recipient' );
      if( empty( $recipient ) ) {
         $recipient = get_bloginfo( 'admin_email' );
      }
      return $recipient;
   }
   
   /**
    * Register a Weekly cron schedule for Domain Expiration reminders.
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
      $enable_reminders = self::send_domain_reminders();
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
    * Gather an array of domains that are expiring soon and fire off a digest email.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function cron_expiration_reminder() {
      $domains = Domain::get_domain_expirations();
      $min_distance = self::get_reminder_distance();
      $expiring_soon = array();
      foreach( $domains as $dom ) {
         $m = new Moment( $dom->expiration );
         $momentFromVo = $m->fromNow();
         $distance = $momentFromVo->getWeeks();
         //Subtract the time until expiration from the minimum warning window (weeks in advance to send reminders)
         $diff = $min_distance + $distance;
         //If the difference is greater than or equal to 0, expiration is closing in and we need to send a reminder.
         if( $diff >= 0 && $distance < 0 ) {
            $expiring_soon[] = $dom->ID;
         }
      }
      if( !empty( $expiring_soon ) ) {
         self::send_reminder_digest( $expiring_soon );
      }
   }
   
   /**
    * Sends a digest email with a list of domain names and their expiration dates.
    * 
    * @access private
    * @static
    * @param array $domains
    * @return void
    */
   private static function send_reminder_digest( $domains ) {
      $reminder_recipient = self::get_reminder_recipient();
      $tdata = array(
         'site_name' => get_bloginfo( 'name' ),
         'domains'   => $domains
      );
      $admin_email = get_bloginfo( 'admin_email' );
      $addl_headers = array(
         'Reply-To' => $admin_email,
         'From'     => sprintf( __( 'Stashbox - %s <%s>', 'th' ), $tdata['site_name'], $admin_email )
      );
      $message = Template::make( 'domain/email-expiration_reminder', $tdata, false );
      add_filter( 'wp_mail_content_type', array( __CLASS__, 'send_html_mail' ) );
      $sent = wp_mail( $reminder_recipient, __( 'Stashbox Expiring Domain Reminder', 'th' ), $message, $addl_headers );
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
   public static function action_wp_ajax_stashbox_domain_test_reminder() {
      if( !is_user_logged_in() ) {
         wp_die( 'You do not have permission to access this page.' );
      }
      global $wpdb;
      $domains = $wpdb->get_col( 'SELECT ID FROM '.$wpdb->posts.' WHERE post_type = "th_domain" AND post_status = "publish" ORDER BY post_title ASC' );
      $sent = self::send_reminder_digest( $domains );
      header( 'Content-Type: application/json' );
      if( !$sent ) {
         echo json_encode( array( 'status' => 'failure', 'affected' => $domains ) );
      } else {
         echo json_encode( array( 'status' => 'success', 'affected' => $domains ) );
      }
      exit();
   }
   
}