<?php
/**
 * Author: Tristan Hall
 * Created On: September 4, 2013
 * Copyright 2013 Tristan Hall
 */
global $global_config;
if( is_front_page() ) {
   $global_config->bodyClass .= ' front-page';
} else {
   $global_config->bodyClass .= ' internal';
}
if( is_page( 'invoices' ) ) {
   $global_config->bodyClass .= ' invoice';
}
?>
<!DOCTYPE html>
<!--[if lt IE 9]><html class="ie8"><![endif]-->
<head>
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <?php echo HTML::favicon('/favicon.png'); ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php echo HTML::style(get_template_directory_uri().'/css/style.css'); ?>
    <?php wp_head(); ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
    <![endif]-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-17578082-1', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');
    </script>
</head>
<body itemscope itemtype="http://schema.org/WebPage" <?php echo body_class( $global_config->bodyClass ) ?>>
   <nav data-topbar class="top-bar show-for-small" id='mobile-nav'>
      <ul class="title-area">
         <li class="name">
            <a href="<?php echo home_url() ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
         </li>
         <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      </ul>
      <section class="top-bar-section">
            <?php wp_nav_menu( array( 'theme_location' => 'mobile_nav', 'container' => false, 'menu_id' => 'mobile_nav' ) ); ?>
      </section>
   </nav>
   <div id="headerWrapper">
      <header>
         <div id="logo">
            <a href="<?php echo home_url() ?>" title="<?php bloginfo( 'name' ); ?>">
               <img src="/wp-content/themes/tristanhall/images/logo-white.png" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>">
            </a>
         </div>
         <nav id="main-nav">
               <?php wp_nav_menu( array( 'theme_location' => 'main_nav', 'container' => false, 'menu_id' => 'main_nav' ) ); ?>
         </nav>
         <div id="contact-info">
               <?php foreach( $global_config->social_channels as $channel ) { ?>
                  <a title="Follow '<?php echo get_bloginfo( 'name' ); ?>' on '<?php echo ucwords( str_replace( '_', '&nbsp;', $channel ) ); ?>'" class="'<?php echo $channel; ?>'" rel="external" href="'<?php echo get_option( "social_".$channel ); ?>'">&nbsp;</a>
               <?php } ?>
         </div>
      </header>
   </div>
   <div id="wrapper">
      <div id="contentWrapper">