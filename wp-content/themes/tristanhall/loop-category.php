<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
?>
<div id='content'>
   <h1 class="post-title"><?php single_cat_title(); ?></h1>
   <?php
   get_template_part( 'breadcrumbs' );
   if (have_posts()): 
      while (have_posts()):
          the_post();
          get_template_part( 'excerpt' );
      endwhile;
   else:
      echo '<h1 class="page-title">No Results Found</h1>';
      echo '<div class="post-content"><p>'._e('Sorry, no posts matched your criteria.').'</p></div>';
   endif;
   ?>
</div>