<?php
/**
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
global $global_config;
echo HTML::style('//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600') ?>
<style type='text/css'>
   div.wrap {
      font-family:"Source Sans Pro", sans-serif !important;
   }
   div.wrap form label {
      display:block;
      height:18px;
      padding-top:4px;
   }
   div.wrap form input[type="text"] {
      width:300px;
   }
</style>
<div class="wrap">
    <?php screen_icon('themes'); ?> <h2>Theme Settings</h2>
    <br/>
    <?php if(isset($_POST['update_settings'])) : ?>
    <div id="message" class="updated below-h2"><p>Settings saved.</p></div>  
    <?php endif; ?>
    <form action="" method="post">
        <label for="google-analytics-code">Google Analytics Profile ID</label>
        <input type="text" value="<?php echo get_option("google-analytics-id"); ?>" name="google-analytics-id" id="google-analytics-id">
        <?php if($global_config->use_email) : ?>
        <br>
        <label for="email_address">Email Address</label>
        <input type="text" value="<?php echo get_option("email_address"); ?>" name="email_address" id="email_address">
        <?php endif; ?>
        <?php if($global_config->use_phone) : ?>
        <br>
        <label for="phone">Phone Number</label>
        <input type="tel" value="<?php echo get_option("phone"); ?>" name="phone" id="phone">
        <?php endif; ?>
        <?php foreach($global_config->social_channels as $channelName) : ?>
        <br>
        <label for="social_<?php echo $channelName; ?>"><?php echo ucwords(str_replace('_', '&nbsp;', $channelName)); ?> URL</label>
        <input type="text" value="<?php echo get_option("social_".$channelName); ?>" name="social_<?php echo $channelName; ?>" placeholder="http://" id="social_<?php echo $channelName; ?>">
        <?php endforeach; ?>
        <br>
        <label for="banner_count">Number of Home Page Banners</label>
        <input type="number" min="0" step="1" value="<?php echo get_option("banner_count"); ?>" name="banner_count" id="banner_count">
        <br>
        <br>
        <input type="submit" name="save_settings" id="save_settings" class="button button-primary" value="Save Settings">
        <input type="hidden" name="update_settings" value="true">
    </form>
</div>