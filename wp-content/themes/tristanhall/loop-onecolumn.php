<div id="content">
<?php
if (have_posts()): 
   while (have_posts()):
      the_post();
      echo '<h1 class="post-title">';
      if(!is_front_page()) :
         the_title();
      endif;
      echo '</h1>';
      if ( function_exists('yoast_breadcrumb') ) {
         yoast_breadcrumb('<p id="breadcrumbs">','</p>');
      }
      echo '<div class="post-content">';
      the_content();
      echo '</div>';
   endwhile;
else:
   echo '<h1 class="page-title">No Results Found</h1>';
   if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
   }
   echo '<div class="post-content"><p>'._e('Sorry, no posts matched your criteria.').'</p></div>';
endif;
?>
</div>