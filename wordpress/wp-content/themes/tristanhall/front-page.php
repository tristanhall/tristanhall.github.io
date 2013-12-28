<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
get_header(); ?>
<div data-type="sprite" data-speed=".3" class="banner-container">
</div>
<div id="container">
   <div id='component'>
<?php get_template_part('loop', 'onecolumn'); ?>
      <div class="home-widget-container">
         <?php
         if (is_active_sidebar('home_widget_1')): 
            dynamic_sidebar('home_widget_1');
         endif;
         if (is_active_sidebar('home_widget_2')): 
            dynamic_sidebar('home_widget_2');
         endif;
         if (is_active_sidebar('home_widget_3')): 
            dynamic_sidebar('home_widget_3');
         endif;
         ?>
      </div>
<?php get_footer(); ?>