<?php
use TH\Stashbox\Domain;
use TH\Stashbox\Client;
use TH\Stashbox\Moment;
use TH\WPAtomic\Template;
Template::make( 'common/email-header' );
?>
<h1 style="Margin-top: 0;color: #565656;font-weight: 700;font-size: 36px;Margin-bottom: 18px;font-family: sans-serif;line-height: 42px"><?php _e( 'Expiring Domains Reminder', 'th' ); ?></h1>
<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px"><?php _e( 'You have some domains expiring soon. The domains, their clients &amp; expiration dates are listed below for your convenience.', 'th' ); ?></p>
<table width="100%" border="0" cellpadding="4" style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px">
   <thead>
      <tr>
         <th><?php _e( 'Domain', 'th' ); ?></th>
         <th><?php _e( 'Client', 'th' ); ?></th>
         <th><?php _e( 'Expiration Date', 'th' ); ?></th>
      </tr>
   </thead>
   <tbody>
      <?php foreach( $domains as $domain_id ) {
         $timestamp = strtotime( Domain::get_expiration( $domain_id ) );
         $client_id = Domain::get_client( $domain_id );
         if( !empty( $client_id ) ) {
            $client = new Client( $client_id );
         }
      ?>
      <tr>
         <td><?php echo get_the_title( $domain_id ); ?></td>
         <td><?php echo empty( $client_id ) ? '&ndash;' : $client->get_title(); ?></td>
         <td><?php echo date( 'm/d/Y', $timestamp ); ?></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
<?php Template::make( 'common/email-footer' ); ?>