<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
get_header(); ?>
<?php
if (have_posts()): 
   while (have_posts()):
       the_post();
       for($i = 1; $i <= $global_config->homepagePanels; $i++) {
          $panelContent = get_post_meta( get_the_ID(), 'home_panel_'.$i, true );
          echo '<div data-type="background" data-speed="4.2" class="panel" id="panel-'.$i.'">';
          echo $panelContent;
          echo '</div>';
       }
   endwhile;
endif;
?>
<?php get_footer();