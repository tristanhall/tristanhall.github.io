<?php
/**
 * Author: Tristan Hall
 * Created On: June 21, 2013 12:30pm
 * Copyright 2013 Tristan Hall
 */
register_nav_menus(array(
	'header_nav' => 'Header Navigation',
	'footer_nav' => 'Footer Navigation'
));
register_sidebar(array(
    'name'          => 'Right Sidebar',
    'id'            => 'right_sidebar',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
));
get_header();
?>
<div id="content">
   <p><img src="http://www.reactiongifs.com/wp-content/uploads/2013/09/Dwight-Schrute-Shakes-Head-and-Rolls-Eyes.gif" class="alignleft" style="margin-right:10px;margin-bottom:10px;"></p>
   <h1 class="post-title">404: Page Not Found</h1>
   <?php if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
   } ?>
   <div class="post-content">
      <h2>My Apologies</h2>
      <p>The page you have requested could not be found.<br/>
         But you could try <a title="Tristan's Portfolio" href="http://tristanhall.com/portfolio/">this page</a>.
      </p>
   </div>
</div>
<?php
get_footer();