<!DOCTYPE html>
<html>
    <head>
        <link rel="dns-prefetch" href="//ajax.googleapis.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <?php wp_head(); ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-17578082-1', 'auto');
            ga('require', 'linkid');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
    </head>
    <body <?php body_class(); ?> itemscope itemtype="<?php echo (isset($post->post_name) && $post->post_name == 'contact' ? 'http://schema.org/ContactPage' : 'http://schema.org/WebPage'); ?>">
        <div id="wrapper">
            <div id="container">
                <header id="mast">
                    <a href="<?php echo home_url(); ?>" title="<?php echo get_option('blogname'); ?>" id="logo"><?php echo get_option('blogname'); ?></a>
                    <p class="slogan"><?php bloginfo('description'); ?></p>
                </header>
                <nav id="primaryNav">
                    <div class="mobileNavToggle"><?php _e('Menu', 'th'); ?></div>
                    <?php wp_nav_menu(array(
                        'theme_location'  => 'header_menu',
                    	'depth'           => 2
                    )); ?>
                </nav>
                <section id="content">