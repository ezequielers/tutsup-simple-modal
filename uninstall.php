<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

delete_option( 'tutsup_modal' );
delete_site_option( 'tutsup_modal' );

delete_option( 'tutsup_modal_style' );
delete_site_option( 'tutsup_modal_style' );
