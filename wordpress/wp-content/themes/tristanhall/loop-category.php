<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
?>
<div id='content'>
   <h1 class="post-title"><?php single_cat_title(); ?></h1>
   <?php
   if (have_posts()): 
      while (have_posts()):
          the_post();
          echo '<article class="hentry">';
          echo '<h2 class="entry-title"><a href="'.get_permalink().'" title="';
          the_title();
          echo '">';
          the_title();
          echo '</a></h2>';
          if(get_post_type() == 'post') {
            echo '<div class="post-meta">Posted in <span class="post-category">';
            the_category(', ', 'single');
            echo '</span> by <span class="post-author">'; 
            the_author_posts_link();
            echo '</span> | <span class="post-date">';
            the_date();
            echo '</span></div>';
          }
          echo '<p class="post-excerpt post-content">';
          the_excerpt();
          echo '</p>';
          echo '<p class="right">';
          echo '<a href="'.get_permalink().'" title="';
          the_title();
          echo '">Read More &raquo;</a>';
          echo '</p>';
          echo '</article>';
      endwhile;
   else:
      echo '<h1 class="page-title">No Results Found</h1>';
      echo '<div class="post-content"><p>'._e('Sorry, no posts matched your criteria.').'</p></div>';
   endif;
   ?>
</div>