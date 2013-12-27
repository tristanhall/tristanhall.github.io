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
   <h1 class="post-title">404: Page Not Found</h1>
   <div class="post-content">
      <h2>Our Apologies</h2>
      <p>The page you have requested could not be found.<br/>
         Try searching our website using the search form on the right, or go back to the <a href="http://localhost/wordpress">home page</a>.
      </p>
   </div>
</div>
<?php
get_sidebar();
get_footer();
?>