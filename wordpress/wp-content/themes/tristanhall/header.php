<?php
/**
 * Author: Tristan Hall
 * Created On: September 4, 2013
 * Copyright 2013 Tristan Hall
 */
global $global_config;
?>
<!DOCTYPE html>
<!--[if lt IE 9]><html class="ie8"><![endif]-->
   <head>
      <link rel="dns-prefetch" href="//ajax.googleapis.com">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
      <?php echo HTML::favicon('/favicon.png'); ?>
      <link rel="profile" href="http://gmpg.org/xfn/11">
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
      <?php echo HTML::style(get_template_directory_uri().'/css/style.css'); ?>
      <?php wp_head(); ?>
      <!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
      <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
      <![endif]-->
   </head>
   <body <?php echo 'class="'.body_class($global_config->bodyClass).'"'; ?>>
      <nav data-topbar class="top-bar show-for-small" id='mobile-nav'>
         <ul class="title-area">
            <li class="name">
               <a href="<?php echo home_url() ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
         </ul>
         <section class="top-bar-section">
            <?php wp_nav_menu( array('theme_location' => 'mobile_nav', 'container' => false, 'menu_id' => 'mobile_nav') ); ?>
         </section>
      </nav>
      <div id="headerWrapper">
         <header>
            <nav id="main-nav">
               <a id="logo" href="<?php echo home_url() ?>" title="<?php bloginfo( 'name' ); ?>"></a>
               <?php wp_nav_menu( array('theme_location' => 'main_nav', 'container' => false, 'menu_id' => 'main_nav') ); ?>
            </nav>
            <div id="contact-info">
               <?php foreach($global_config->social_channels as $channel) {
                  echo '<a title="Follow '.get_bloginfo( 'name' ).' on '.ucwords(str_replace('_', '&nbsp;', $channel)).'" class="'.$channel.'" rel="external" href="'.get_option("social_".$channel).'"></a>';
               } ?>
            </div>
         </header>
      </div>
      <div id="wrapper">
         <div id="content">