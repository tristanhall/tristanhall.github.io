<?php
get_header();
$posts_page = get_post( get_option( 'page_for_posts' ) );
?>
<div id="content">
   <h1 class="entry-title"><?php echo $posts_page->post_title; ?></h1>
   <?php if ( function_exists( 'yoast_breadcrumb' ) ) {
      yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
   } ?>
<?php get_template_part( 'loop', 'blog' ); ?>
</div>
<?php
get_sidebar();
get_footer();