<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
get_header();
if (have_posts()): 
   while (have_posts()):
       the_post();
       for($i = 1; $i <= $global_config->homepagePanels; $i++) {
          $panelContent = get_post_meta( get_the_ID(), 'home_panel_'.$i, true );
          if($i == 4) {
             $panelContent = do_shortcode( $panelContent );
          }
          echo '<div data-type="background" data-speed="6.2" class="panel" id="panel-'.$i.'">';
          echo '<div class="panelContent">'.$panelContent.'</div>';
          echo '</div>';
       }
   endwhile;
endif;
get_footer();