<?php
get_header(); ?>
<div id="content">
<?php get_template_part( 'loop', 'loop-single' ); ?>
</div>
<?php
get_sidebar();
get_footer();