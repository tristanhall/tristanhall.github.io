<?php
if (have_posts()): 
   while (have_posts()):
      the_post();
      get_template_part( 'post' );
   endwhile;
else:
   echo '<h1 class="page-title">No Results Found</h1>';
   get_template_part( 'breadcrumbs' );
   echo '<div class="post-content"><p>'._e('Sorry, no posts matched your criteria.').'</p></div>';
endif;