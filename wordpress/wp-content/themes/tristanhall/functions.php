<?php
/**
 * Author: Tristan Hall
 * Created On: June 21, 2013
 * Copyright 2013 Tristan Hall
 */

//Prettier error handling
set_error_handler('handle_errors');
function handle_errors($errno, $errstr, $errfile, $errline) {
   $trace = array_reverse(debug_backtrace());
   array_pop($trace);
   include_once(__DIR__.'/php_error.php');
   if(ini_get('log_errors')) {
      $items = array();
      foreach($trace as $item) {
         $items[] = (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()';
         $message = 'Backtrace from '. $errstr . ' at ' . $errfile . ' ' . $errline . ': ' . join(' | ', $items);
         error_log($message);
      }
    }
    exit;
}

$global_config = new stdClass(); //Create our config object
$global_config->has_banners = true; //Determines if home page banners are to be used or not.
$global_config->banner_count = get_option('banner_count'); //Retrieve the number of banners that the user wants
$global_config->front_page_id = get_option('page_on_front'); //Retrieve the front page ID
$global_config->use_phone = true; //Does this site display a phone number?
$global_config->use_email = true; //Does this site display an email address?
$global_config->social_channels = array('facebook', 'twitter', 'google_plus'); //Define an array of identifiers for each social media channel this site supports.
$global_config->jquery_version = '1.10.2';

require_once('libraries/class.html.php'); //HTML element class
require_once('libraries/class.ui.php'); //Foundation short code class
require_once('libraries/class.validate.php'); //Input validation class
require_once('libraries/theme-update-checker.php'); //Theme Update library

//Check for updates
$updateChecker = new ThemeUpdateChecker(
   'thbase', //Theme slug. Usually the same as the name of its directory.
   'http://example.com/wp-update-server/?action=get_metadata&slug=thbase' //Metadata URL.
);

//All Foundation UI functions are available as short codes too :)
add_shortcode('alert', array('UI', 'alert')); //[alert]Button Text[/alert]
add_shortcode('button', array('UI', 'button')); //[button]Button Text[/button]
add_shortcode('panel', array('UI', 'panel')); //[panel]Panel Text[/panel]
add_shortcode('callout', array('UI', 'callout')); //[callout]Callout Text[/callout]
add_shortcode('progress', array('UI', 'progress')); //[progress amount=75]
add_shortcode('one', array('UI', 'one')); //[one]Content[/one]
add_shortcode('two', array('UI', 'two')); //[two]Content[/two]
add_shortcode('three', array('UI', 'three')); //[three]Content[/three]
add_shortcode('four', array('UI', 'four')); //"..."
add_shortcode('five', array('UI', 'five')); //"..."
add_shortcode('six', array('UI', 'six')); //"..."
add_shortcode('seven', array('UI', 'seven')); //"..."
add_shortcode('eight', array('UI', 'eight')); //"..."
add_shortcode('nine', array('UI', 'nine')); //"..."
add_shortcode('ten', array('UI', 'ten')); //"..."
add_shortcode('eleven', array('UI', 'eleven')); //"..."
add_shortcode('twelve', array('UI', 'twelve')); //[twelve]Content[/twelve]

//Remove Wordpress version meta tag
remove_action('wp_head', 'wp_generator');

//Activate our navigation menus
register_nav_menus(array(
	'main_nav' => 'Header Navigation',
	'footer_nav' => 'Footer Navigation',
	'mobile_nav' => 'Mobile Navigation'
));
//Activate our single sidebar
register_sidebar(array(
    'name'          => __('Right Sidebar',"Tristan Hall" ),
    'id'            => 'right_sidebar',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
));
//Activate home content blocks
register_sidebar(array(
    'name'          => __('Home Content Blocks',"Tristan Hall" ),
    'id'            => 'home_content_blocks',
    'before_title'  => '<h3 class="block-title">',
    'after_title'   => '</h3>'
));

//Add a settings page for our theme
function setup_theme_admin_menus() {  
      add_submenu_page('themes.php',   
        "Theme Settings", 'Theme Settings', 'manage_options',   
        'theme-settings', 'theme_settings');
}
add_action("admin_menu", "setup_theme_admin_menus");

//Create the settings page
function theme_settings() {
   global $global_config;
   if(!current_user_can('manage_options')) {  
      wp_die('You do not have sufficient permissions to access this page.');  
   }
   if(isset($_POST["update_settings"])) {
      //Update email address if applicable
      if($global_config->use_email === TRUE) {
         $email_address = esc_attr($_POST["email_address"]);
         update_option("email_address", $email_address);
      }
      //Update phone number if applicable
      if($global_config->use_phone === TRUE) {
         $phone = esc_attr($_POST["phone"]);
         update_option("phone", $phone);
      }
      //Update all social channel links depending on what's setup
      foreach($global_config->social_channels as $channelName) {
         update_option("social_".$channelName, esc_attr($_POST["social_".$channelName]));
      }
      //Update banner count and Google Analytics Tracking ID
      update_option("banner_count", esc_attr($_POST["banner_count"]));
      update_option("google-analytics-id", esc_attr($_POST["google-analytics-id"]));
   }
   include_once(__DIR__.'/theme-settings.php');
}

//Allows banners to be uploaded to the home page
function homepage_banners() {
   global $global_config;
   global $post;
   //Can't do anything without a $post variable
   if(!$post) {
      return;
   }
   wp_register_script('wp-upload', get_template_directory_uri() .'/js/wp-upload.js', array('jquery','media-upload','thickbox'));
   wp_enqueue_script('jquery');
   wp_enqueue_script('thickbox');
   wp_enqueue_style('thickbox');
   wp_enqueue_script('media-upload');
   wp_enqueue_script('wp-upload');
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post->ID;
   }
   $custom = get_post_custom($post->ID);
   $output = '';
   for($i = 1; $i <= $global_config->banner_count; $i++) {
      $bannersrc = (array_key_exists('banner_img_src_'.$i, $custom) ? $custom['banner_img_src_'.$i][0] : '');
      $bannertitle = (array_key_exists('banner_title_'.$i, $custom) ? $custom['banner_title_'.$i][0] : '');
      $bannercaption = (array_key_exists('banner_caption_'.$i, $custom) ? $custom['banner_caption_'.$i][0] : '');
      $bannerlink = (array_key_exists('banner_link_'.$i, $custom) ? $custom['banner_link_'.$i][0] : '');
      
      $output .= '<p><strong>Banner #'.$i.'</strong></p>';
      $output .= '<p>Banner Image URL<br/>';
      $output .= '<input name="banner_img_src_'.$i.'" type="text" value="'.$bannersrc.'" size="67" />&nbsp;<a class="uploadImage button" id="banner_img_src_'.$i.'">Choose Image</a></p>';
      $output .= '<p><em>Enter the URL of the image here. This image must be 1000px x 350px.</em></p>';
      $output .= '<p>Banner #'.$i.' Title<br/>';
      $output .= '<input name="banner_title_'.$i.'" type="text" value="'.$bannertitle.'" size="67" /></p>';
      $output .= '<p>Banner #'.$i.' Caption<br/>';
      $output .= '<input name="banner_caption_'.$i.'" type="text" value="'.$bannercaption.'" size="67" /></p>';
      $output .= '<p>Banner #'.$i.' Link<br/>';
      $output .= '<input name="banner_link_'.$i.'" type="text" value="'.$bannerlink.'" size="67" /></p>';
      $output .= '<p><em>Enter the URL of where you want the first banner to link to.</em></p><br />';
   }
   wp_nonce_field( basename(__FILE__), 'th_noncename' );
   echo $output;
}
//Save the banners we upload 
add_action('save_post', 'save_homepage_banners');
function save_homepage_banners() {
   global $global_config;
   global $post;
   if(!$post) {
      return;
   }
   if($post->ID !== $global_config->front_page_id) {
      return $post->ID;
   }
   if (!wp_verify_nonce( $_POST['th_noncename'], basename(__FILE__))) {
      return $post->ID;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post->ID;
   }
   for($i = 1; $i <= $global_config->banner_count; $i++) {
      update_post_meta($post->ID, 'banner_img_src_'.$i, $_POST['banner_img_src_'.$i]);
      update_post_meta($post->ID, 'banner_title_'.$i, $_POST['banner_title_'.$i]);
      update_post_meta($post->ID, 'banner_caption_'.$i, $_POST['banner_caption_'.$i]);
      update_post_meta($post->ID, 'banner_link_'.$i, $_POST['banner_link_'.$i]);
   }
}

//Instantiate banner uploading ONLY on the home page
add_action('admin_init', 'admin_init_callback');
function admin_init_callback() {
   global $global_config;
   if(!isset($post_id)) {
      if(isset($_GET['post'])) {
         $post_id = $_GET['post'];
      } elseif(isset($_POST['post_ID'])) {
         $post_id = $_POST['post_ID'];
      } else {
         $post_id = null;
      }
   }
   if ($post_id == $global_config->front_page_id) {
      add_meta_box('homepage-banners', 'Home Page Baners', 'homepage_banners', 'page', 'normal', 'high');
   }
}

//Add our stylesheet to the editor
function add_editor_styles() {
    add_editor_style(__DIR__.'/css/editor.css');
}
add_action('init', 'add_editor_styles');

//Override jQuery
function frontend_scripts() {
   global $global_config;
   wp_deregister_script('jquery');
   wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/'.$global_config->jquery_version.'/jquery.min.js');
   wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'frontend_scripts');