<?php
/* 
Template Name: Portfolio Archive
Author: Tristan Hall
Copyright 2013 Tristan Hall
 */
get_header();
$taxonomy = 'portfolio_categories';
$tax_terms = get_terms( $taxonomy );
$args = array( 'post_type' => 'th-portfolio', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'date' );
$loop = new WP_Query( $args );
echo '<div id="content">';
echo '<h1>Portfolio</h1>';
if ( function_exists( 'yoast_breadcrumb' ) ) {
yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
echo '<ul id="portfolioFilter">';
echo '<li class="active">Filter:</li><li class="filter active" data-filter="mix">All</li>';
foreach( $tax_terms as $tax_term ) {
   echo '<li class="filter" data-filter="'.$tax_term->name.'">'.$tax_term->name.'</li>';
}
echo '</ul>';
echo '<div class="portfolio-entries" id="grid">';
while( $loop->have_posts() ) :
   $loop->the_post();
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
            echo '<a title="Read More on '.get_the_title().'" class="read-more button secondary" href="'.get_permalink().'">Read More</a>';
         echo '</div>';
      echo '</figcaption>';
   echo '</figure>';
endwhile;
echo '</div>';
echo '</div>';
wp_reset_postdata();
get_footer();
