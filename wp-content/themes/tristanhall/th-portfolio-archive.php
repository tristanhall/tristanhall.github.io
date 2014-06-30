<?php
/* 
Template Name: Portfolio Items
Author: Tristan Hall
Copyright 2013 Tristan Hall
 */
get_header();
$taxonomy = 'portfolio_categories';
$tax_terms = get_terms( $taxonomy );
$args = array( 'post_type' => 'th-portfolio', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'date' );
echo '<div id="content">';
echo '<h1>Portfolio</h1>';
if ( function_exists( 'yoast_breadcrumb' ) ) {
   yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
$tmp_query = $wp_query;
$wp_query = new WP_Query( $args );
if( $wp_query->have_posts() ) {
   echo '<div class="portfolio-entries" id="grid">';
   while( $wp_query->have_posts() ) :
      $wp_query->the_post();
      $taxonomy = strip_tags( get_the_term_list( get_the_ID(), 'portfolio_categories' ) );
      echo '<figure class="mix '.$taxonomy.'">';
         echo '<figcaption>';
            echo '<a title="'.get_the_title().'" class="portfolio-link" href="'.get_permalink().'">';
            the_post_thumbnail();
            echo '</a>';
            echo '<div class="portfolio-desc">';
               echo '<h3><a title="'.get_the_title().'" href="'.get_permalink().'">';
               the_title();
               echo '</a></h3>';
               echo '<div class="excerpt">';
               the_excerpt();
               echo '</div>';
               echo '<a title="View '.get_the_title().'" class="read-more button" href="'.get_permalink().'">View</a>';
            echo '</div>';
         echo '</figcaption>';
      echo '</figure>';
   endwhile;
}
echo '</div>';
echo '</div>';
$wp_query = $tmp_query;
get_sidebar();
get_footer();
