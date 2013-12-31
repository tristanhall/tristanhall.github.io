<div id="content">
<?php
if (have_posts()): 
   while (have_posts()):
       the_post();
       echo '<article class="hentry">';
       echo '<h1 class="post-title">';
       the_title();
       echo '</h1><div class="post-content">';
       the_content();
       echo '</div>';
       echo '</article>';
   endwhile;
else:
   echo '<h1 class="page-title">No Results Found</h1>';
   echo '<div class="post-content"><p>'._e('Sorry, no posts matched your criteria.').'</p></div>';
endif;
?>
</div>