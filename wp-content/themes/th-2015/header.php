<!DOCTYPE html>
<html>
    <head>
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
    <body <?php body_class(); ?>>
        <div id="Wrapper">
            <div id="Container">
                <header id="Mast">
                    <a href="<?php echo home_url(); ?>" title="<?php echo get_option('blogname'); ?>" id="Logo"><?php echo get_option('blogname'); ?></a>
                    <p class="slogan">Complex Problems. Simple Solutions.</p>
                </header>
                <nav id="PrimaryNav">
                    <ul class="menu">
                        <li class="menu-item current-menu-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Disciplines</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Work</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Blog</a>
                        </li>
                    </ul>
                </nav>
                <section id="Content">