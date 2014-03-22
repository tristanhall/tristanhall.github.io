<div class="wrap wm-container list-websites">
   <h2><?php echo $site->new === true ? 'Add' : 'Edit'; ?> Website</h2>
   <form name="post" action="admin.php?page=wm-websites" method="post" id="post">
      <input type='hidden' name='id' value='<?php echo $site->id; ?>'>
      <div id="poststuff">
         <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
               <div id="titlediv">
                  <div id="titlewrap">
                     <label class="" id="title-prompt-text" for="title">Enter title here</label>
                     <input type="text" name="post_title" size="30" value="" id="title" autocomplete="off">
                  </div>
               </div><!-- /titlediv -->
               
            </div>
         </div><!-- /post-body-content -->
         
         <div id="postbox-container-1" class="postbox-container">
            <div id="side-sortables" class="meta-box-sortables ui-sortable"><div id="submitdiv" class="postbox ">
                  <div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Publish</span></h3>
                  <div class="inside">
                     <div class="submitbox" id="submitpost">
                        <div id="major-publishing-actions">
                           <div id="delete-action">
                           <a class="submitdelete deletion" href="http://tristanhall.com/wp-admin/post.php?post=99&amp;action=trash&amp;_wpnonce=ec1277acc8">Move to Trash</a></div>
                              
                           <div id="publishing-action">
                              <span class="spinner"></span>
                              <input name="original_publish" type="hidden" id="original_publish" value="Publish">
                              <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publish" accesskey="p"></div>
                           <div class="clear"></div>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
         <div id="postbox-container-2" class="postbox-container">
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
               
               <div id="postexcerpt" class="postbox  hide-if-js" style="">
                  <div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Excerpt</span></h3>
                  <div class="inside">
                     <label class="screen-reader-text" for="excerpt">Excerpt</label><textarea rows="1" cols="40" name="excerpt" id="excerpt"></textarea>
                  </div>
               </div>
            </div>
         </div>
      </div><!-- /post-body -->
      <br class="clear">
      </div><!-- /poststuff -->
   </form>
</div>