<div id='content'>
   <h1 class="post-title">Search Results</h1>
<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
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
   echo '<div class="post-content"><h2>No Results Found</h2>';
   echo _e('Sorry, no posts matched your criteria.');
   echo '</div>';
endif;
?>
</div>