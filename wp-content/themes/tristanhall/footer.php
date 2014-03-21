<?php
/**
 * Author: Tristan Hall
 * Created On: September 4, 2013
 * Copyright 2013 Tristan Hall
 */
?>
</div><!--endWrapper-->
<div id="footerWrapper">
   <footer>
      <nav id="footer-nav">
         <?php wp_nav_menu( array('theme_location' => 'footer_nav', 'container' => false, 'menu_id' => 'footer_nav') ); ?>
      </nav>
      <p id='copyright'>COPYRIGHT &copy; <?php echo date('Y'); ?> TRISTAN HALL. ALL RIGHTS RESERVED.<br>SITE DESIGN &copy; <?php echo date('Y'); ?> <?php echo HTML::link( 'http://tristanhall.com', 'Tristan Hall', array('alt' => 'Detroit Web Developer Tristan Hall', 'title' => 'Detroit Web Developer Tristan Hall', 'target' => '_blank', 'class' => 'promolink') ) ?></p>
   </footer>
</div>
      <?php wp_footer(); ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/vendor/custom.modernizr.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.clearing.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.topbar.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/jquery.functions.js') ?>
</body>
</html>