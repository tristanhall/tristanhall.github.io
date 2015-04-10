<?php
namespace TH\Stashbox;

use Unirest\Request;
use TH\WPAtomic\Template;

class WhoisController {
   
   /**
    * Set the API Endpoint for the JsonWHOIS.com API
    * 
    * (default value: 'http://jsonwhois.com/api/v1/whois')
    * 
    * @var string
    * @access private
    * @static
    */
   private static $api_endpoint = 'http://jsonwhois.com/api/v1/whois';
   
   /**
    * Register the WHOIS settings.
    * 
    * @access public
    * @static
    * @param mixed $settings
    * @return void
    */
   /*public static function filter_stashbox_register_settings( $settings ) {
      $settings['sb_enable_whois'] = 'boolval';
      $settings['sb_whois_api_key'] = 'sanitize_text_field';
      return $settings;
   }*/
   
   /**
    * Render the settings fields for the WHOIS reports.
    * 
    * @access public
    * @static
    * @param mixed $field_html
    * @return void
    */
   /*public static function filter_stashbox_settings_fields( $field_html ) {
      $tdata = array(
         'enable_whois'  => self::enabled(),
         'whois_api_key' => self::get_api_key()
      );
      $field_html .= Template::make( 'whois/row-settings', $tdata, false );
      return $field_html;
   }*/
   
   /**
    * Register the WHOIS Report metabox for websites.
    * 
    * @access public
    * @static
    * @return void
    */
   public static function action_add_meta_boxes() {
      if( self::enabled() ) {
         //add_meta_box( 'stashbox-whois-mb', __( 'WHOIS Report', 'th' ), array( __CLASS__, 'mb_whois' ), 'th_domain', 'advanced', 'high' );
      }
   }
   
   /**
    * Display the WHOIS Report metabox.
    * 
    * @access public
    * @static
    * @param object $post
    * @return void
    */
   public static function mb_whois( $post ) {
      $domain = $post->post_title;
      if( Domain::is_fqdn( $domain ) ) {
         $tdata = array(
            'whois' => self::get_whois( $domain, $post->ID )
         );
         Template::make( 'whois/mb-whois', $tdata );
      } else {
         _e( 'This is not a Fully Qualified Domain Name.', 'th' );
      }
   }
   
   /**
    * Retrieve the JsonWHOIS.com API key.
    * 
    * @access public
    * @static
    * @return string
    */
   public static function get_api_key() {
      $api_key = get_option( 'sb_whois_api_key' );
      return esc_attr( $api_key );
   }
   
   /**
    * Return True if WHOIS reports are enabled.
    * 
    * @access public
    * @static
    * @return boolean
    */
   public static function enabled() {
      $enabled = get_option( 'sb_enable_whois' );
      return boolval( $enabled );
   }
   
   /**
    * Get the WHOIS report for a domain.
    * 
    * @access public
    * @static
    * @param string $domain
    * @return array
    */
   public static function get_whois( $domain, $post_id = null ) {
      //Get the cached WHOIS data if possible
      if( !is_null( $post_id ) ) {
         $cached_whois = get_post_meta( $post_id, 'whois_cache', true );
         if( is_array( $cached_whois ) && time() <= $cached_whois['expires'] ) {
            return $cached_whois['whois'];
         }
      }
      $api_key = self::get_api_key();
      $headers = array(
         'Accept'        => 'application/json',
         'Authorization' => sprintf( 'Token token=%s', $api_key )
      );
      $query = array(
         'domain' => $domain
      );
      $response = Request::get( self::$api_endpoint, $headers, $query );
      $whois_data = (array) $response->body;
      unset( $whois_data['raw'] );
      //Update the cache if the API was used
      if( !is_null( $post_id ) ) {
         $cache_data = array(
            'expires' => strtotime( '+1 week' ),
            'whois'   => $whois_data
         );
         update_post_meta( $post_id, 'whois_cache', $cache_data );
      }
      return $whois_data;
   }
   
}