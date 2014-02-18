<?php
/**
 * Author: Tristan Hall
 * Created On: June 21, 2013
 * Copyright 2013 Tristan Hall
 */

/**
 * Discover the body class
 * @return string
 */
function bodyClass() {
   $class = '';
   return $class;
}

$global_config = new stdClass(); //Create our config object
$global_config->has_banners = true; //Determines if home page banners are to be used or not.
$global_config->banner_count = get_option('banner_count'); //Retrieve the number of banners that the user wants
$global_config->front_page_id = get_option('page_on_front'); //Retrieve the front page ID
$global_config->use_phone = true; //Does this site display a phone number?
$global_config->use_email = true; //Does this site display an email address?
$global_config->social_channels = array('facebook', 'twitter', 'google_plus'); //Define an array of identifiers for each social media channel this site supports.
$global_config->jquery_version = '1.11.0';
$global_config->bodyClass = bodyClass();
$global_config->homepagePanels = 4;


require_once('libraries/class.html.php'); //HTML element class
require_once('libraries/class.ui.php'); //Foundation short code class
require_once('libraries/class.validate.php'); //Input validation class
require_once('libraries/theme-update-checker.php'); //Theme Update library

//Check for updates
$updateChecker = new ThemeUpdateChecker(
   'tristanhall', //Theme slug. Usually the same as the name of its directory.
   'http://wpupdate.tristanhall.com/?action=get_metadata&slug=tristanhall' //Metadata URL.
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
//Save the homepage banners and panels
add_action('save_post', 'save_homepage');
function save_homepage() {
   global $global_config;
   global $post;
   if(!$post) {
      return;
   }
   if($post->post_title !== 'Home') {
      return $post->ID;
   }
   if (!wp_verify_nonce( $_POST['th_noncename'], basename(__FILE__))) {
      return $post->ID;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post->ID;
   }
   for($i = 1; $i <= $global_config->homepagePanels; $i++) {
      update_post_meta($post->ID, 'home_panel_'.$i, $_POST['home_panel_'.$i]);
   }
//   for($i = 1; $i <= $global_config->banner_count; $i++) {
//      update_post_meta($post->ID, 'banner_img_src_'.$i, $_POST['banner_img_src_'.$i]);
//      update_post_meta($post->ID, 'banner_title_'.$i, $_POST['banner_title_'.$i]);
//      update_post_meta($post->ID, 'banner_caption_'.$i, $_POST['banner_caption_'.$i]);
//      update_post_meta($post->ID, 'banner_link_'.$i, $_POST['banner_link_'.$i]);
//   }
}


//Allows banners to be uploaded to the home page
function homepage_panels() {
   global $global_config;
   global $post;
   //Can't do anything without a $post variable
   if(!$post) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post->ID;
   }
   $output = '';
   for($i = 1; $i <= $global_config->homepagePanels; $i++) {
      $panelContent = get_post_meta( $post->ID, 'home_panel_'.$i, true );
      
      $output .= '<p><strong>Panel #'.$i.'</strong></p>';
      $output .= '<p>Content: <br/>';
      $output .= '<textarea name="home_panel_'.$i.'" style="width:100%; min-height:80px; padding:10px;">'.$panelContent.'</textarea></p>';
   }
   wp_nonce_field( basename(__FILE__), 'th_noncename' );
   echo $output;
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
   } else {
      return;
   }
   if ($post_id == $global_config->front_page_id) {
      remove_post_type_support('page', 'editor');
      //add_meta_box('homepage-banners', 'Home Page Baners', 'homepage_banners', 'page', 'normal', 'high');
      add_meta_box('homepage-panels', 'Home Page Panel Content', 'homepage_panels', 'page', 'normal', 'high');
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

//Support post thumbnails
add_theme_support( 'post-thumbnails' );

//Pull in our custom post type library
include_once(__DIR__.'/libraries/portfolio.php');

//Pull in the clearing gallery functions to rewrite Wordpress's gallery output
include_once(__DIR__.'/libraries/clearing.php');