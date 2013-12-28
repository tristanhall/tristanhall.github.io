<?php
/* 
Template Name: Portfolio Archive
Author: Tristan Hall
Copyright 2013 Tristan Hall
 */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array( 'post_type' => 'th-portfolio', 'posts_per_page' => get_option('posts_per_page'), 'paged' => $paged );
$loop = new WP_Query( $args );
get_header();
echo '<h1>Select Clients</h1>';
echo '<div class="portfolio-entries">';
while ( $loop->have_posts() ) : $loop->the_post();
   echo '<figure>';
      echo '<figcaption>';
         echo '<a title="'.get_the_title().'" class="portfolio-link" href="/portfolio/'.get_the_ID().'/">';
         the_post_thumbnail();
         echo '</a>';
         echo '<div class="portfolio-desc">';
            echo '<h3>';
            the_title();
            echo '</h3>';
            echo '<div class="excerpt">';
            the_excerpt();
            echo '</div>';
            echo '<a title="Read More on '.get_the_title().'" class="read-more" href="';
            the_permalink();
            echo '">View '.get_the_title().'</a>';
         echo '</div>';
      echo '</figcaption>';
   echo '</figure>';
endwhile;
echo '</div>';
get_footer();