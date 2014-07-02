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
   <?php if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
   } ?>
<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class(); ?> id="post-<?php the_ID(); ?>">
   <section itemprop="text">
      <?php the_content(); ?>
   </section>
</article>
</div>
<?php
get_sidebar();
get_footer();