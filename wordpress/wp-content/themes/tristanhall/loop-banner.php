<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
global $global_area122;
if (have_posts()): 
   $output = '<ul data-orbit>';
   while (have_posts()):
       the_post();
       $custom = get_post_custom(get_the_ID());
       for($i = 1; $i <= $global_area122['banner_count']; $i++) {
         $bannersrc = $custom['banner_img_src_'.$i][0];
         $bannertitle = $custom['banner_title_'.$i][0];
         $bannercaption = $custom['banner_caption_'.$i][0];
         $bannerlink = $custom['banner_link_'.$i][0];
         if($bannertitle == '') {
            $bannertitle = get_the_title().' '.$i;
         }
         if(!empty($bannersrc)) {
            $output .= '<li style="background-image:url('.$bannersrc.');">';
            if(!empty($bannerlink)) {
               $output .= '<a href="'.$bannerlink.'" title="'.$bannertitle.'">';
            }
            if(!empty($bannercaption)) {
               $output .= '<div class="caption">'.$bannercaption.'</div>';
            }
            if(!empty($bannerlink)) {
               $output .= '</a>';
            }
            $output .= '</li>';
         }
       }
   endwhile;
   $output .= '</ul>';
   echo $output;
endif;
?>