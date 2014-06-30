<?php
$page = filter_input( INPUT_GET, 'paged' )  != '' ? filter_input( INPUT_GET, 'paged' ) : 0;
$post_args = array(
   'paged' => $page,
   'posts_per_page' => get_option( 'posts_per_page' )
);
$tmp_query = $wp_query;
$wp_query = new WP_Query( $post_args );
if( $wp_query->have_posts() ) {
   while( $wp_query->have_posts() ) {
      $wp_query->the_post();
      get_template_part( 'excerpt' );
   }
}
if( function_exists( 'postbar' ) ) {
   postbar();
}
$wp_query = $tmp_query;