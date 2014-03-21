<?php
/*
Template Name: Login Page
Author: Tristan Hall
Copyright 2013 Tristan Hall
*/
$args = array(
  'echo'           => true,
  'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
  'form_id'        => 'loginform',
  'label_username' => __( 'Username' ),
  'label_password' => __( 'Password' ),
  'label_remember' => __( 'Remember Me' ),
  'label_log_in'   => __( 'Log In' ),
  'id_username'    => 'user_login',
  'id_password'    => 'user_pass',
  'id_remember'    => 'rememberme',
  'id_submit'      => 'wp-submit',
  'remember'       => true,
  'value_username' => NULL,
  'value_remember' => false
);
get_header(); ?>
<div id="content">
   <h1 class="entry-title">Client Login</h1>
   <article>
      <?php wp_login_form( $args ); ?>
      <div id="alreadyLoggedIn">
         <h2>You are already logged in.<br><small><a title="Logout - Tristan Hall" href="<?php echo wp_logout_url( home_url() ); ?>">Click here</a> to logout.</small></h2>
      </div>
   </article>
</div>
<?php get_footer();