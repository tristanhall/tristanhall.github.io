<?php
/**
 * Author: Tristan Hall
 * Created On: June 21, 2013 12:30pm
 * Copyright 2013 Tristan Hall
 */
get_header(); ?>
<div id="content">
   <h1 itemprop="name" class="entry-title">
      <a href="<?php the_permalink(); ?>" title="Read more of <?php the_title(); ?>"><?php the_title(); ?></a>
   </h1>
   <?php get_template_part( 'breadcrumbs' ); ?>
<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class(); ?> id="post-<?php the_ID(); ?>">
   <section itemprop="text">
      <?php the_content(); ?>
   </section>
   <section class="entry-comments">
      <?php comments_template( '', true ); ?>
   </section>
   <footer>
      <p class="entry-meta">
         <span class="categories"><?php echo get_the_category_list( ',', '' ); ?></span>
         <span class="author">
            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="Read more posts by <?php the_author_meta( 'display_name' ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
         </span>
         <span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>
      </p>
   </footer>
</article>
</div>
<?php
get_sidebar();
get_footer();