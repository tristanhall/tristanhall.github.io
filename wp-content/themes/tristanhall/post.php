<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class(); ?> id="post-<?php the_ID(); ?>">
   <header>
      <h2 itemprop="name" class="entry-title">
         <a href="<?php the_permalink(); ?>" title="Read more of <?php the_title(); ?>"><?php the_title(); ?></a>
      </h2>
   </header>
   <section itemprop="text">
      <?php the_content(); ?>
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