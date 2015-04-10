<?php
use TH\Stashbox\SSL;
use TH\Stashbox\Client;
use TH\Stashbox\Moment;
use TH\WPAtomic\Template;
Template::make( 'common/email-header' );
?>
<h1 style="Margin-top: 0;color: #565656;font-weight: 700;font-size: 36px;Margin-bottom: 18px;font-family: sans-serif;line-height: 42px"><?php _e( 'Expiring SSL Certificate Reminder', 'th' ); ?></h1>
<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px"><?php _e( 'You have some SSL certificates expiring soon. The domains, associated clients &amp; expiration dates are listed below for your convenience.', 'th' ); ?></p>
<table width="100%" border="0" cellpadding="4" style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px">
   <thead>
      <tr>
         <th><?php _e( 'SSL Certificate', 'th' ); ?></th>
         <th><?php _e( 'Domain', 'th' ); ?></th>
         <th><?php _e( 'Client', 'th' ); ?></th>
         <th><?php _e( 'Expiration Date', 'th' ); ?></th>
      </tr>
   </thead>
   <tbody>
      <?php foreach( $certificates as $cert_id ) {
         $timestamp = strtotime( SSL::get_expiration( $cert_id ) );
         $domain_id = SSL::get_domain( $cert_id );
         $client_id = SSL::get_client( $cert_id );
         if( !empty( $client_id ) ) {
            $client = new Client( $client_id );
         }
      ?>
      <tr>
         <td><?php echo get_the_title( $cert_id ); ?></td>
         <td><?php echo empty( $domain_id ) ? '&ndash;' : get_the_title( $domain_id ); ?></td>
         <td><?php echo empty( $client_id ) ? '&ndash;' : $client->get_title(); ?></td>
         <td><?php echo date( 'l, F j, Y', $timestamp ); ?></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
<?php Template::make( 'common/email-footer' ); ?>