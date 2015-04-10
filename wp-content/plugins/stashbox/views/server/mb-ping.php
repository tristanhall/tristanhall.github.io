<?php
if( $latency === false ) { 
   _e( '<i class="stashbox-ping-fail"></i>&nbsp;The server is not responding to PING or the hostname is not defined.', 'th' );
} else {
   echo sprintf( __( '<i class="stashbox-ping-success"></i>&nbsp;Responded in %dms.', 'th' ), $latency );
}