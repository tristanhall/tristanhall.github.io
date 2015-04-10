<?php wp_nonce_field( 'assign', 'stashbox-client-nonce' ); ?>
<select data-placeholder="Choose a Client..." name="client_id" id="client_id">
   <option value="">&ndash;</option>
   <?php foreach( $clients as $client ) { ?>
   <option value="<?php echo $client->get_ID(); ?>" <?php echo $client->get_ID() == $client_id ? 'selected="selected"' : ''; ?>><?php echo $client->get_title(); ?></option>
   <?php } ?>
</select>