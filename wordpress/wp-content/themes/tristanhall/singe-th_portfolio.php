<?php

/* 
Template Name: Single Portfolio
Author: Tristan Hall
Copyright 2013 Tristan Hall
 */
get_header();
$args = array( 'post_type' => 'th_portfolio', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	the_title();
	echo '<div class="entry-content">';
	the_content();
	echo '</div>';
endwhile;
get_footer();