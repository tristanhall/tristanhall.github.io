<?php
/**
 * Author: Tristan Hall
 * Created On: September 4, 2013
 * Copyright 2013 Tristan Hall
 */
?>
   </div><!--endContent-->
</div><!--endWrapper-->
<div id="footerWrapper">
   <footer>
      <div id='copyright'>&copy; <?php echo date('Y').' '.get_bloginfo('name'); ?>. All Rights Reserved. Site Design &copy; <?php echo date('Y'); ?> <?php echo HTML::link( 'http://tristanhall.com', 'Tristan Hall', array('alt' => 'Detroit Web Developer Tristan Hall', 'title' => 'Detroit Web Developer Tristan Hall', 'target' => '_blank', 'class' => 'promolink') ) ?></div>
   </footer>
</div>
      <?php wp_footer(); ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/vendor/custom.modernizr.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.clearing.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.dropdown.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.interchange.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.magellan.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.orbit.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.reveal.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/foundation/foundation.topbar.js') ?>
      <?php echo HTML::script(get_template_directory_uri().'/js/jquery.functions.js') ?>
</body>
</html>