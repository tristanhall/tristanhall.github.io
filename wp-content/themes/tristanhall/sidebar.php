<?php
/**
 * Author: Tristan Hall
 * Created On: June 21, 2013
 * Copyright 2013 Tristan Hall
 */
if (is_active_sidebar( 'right_sidebar' ) ) { ?>
<div id='sidebar'>
    <?php dynamic_sidebar( 'right_sidebar' ); ?>
</div><!-- #sidebar -->
<?php }