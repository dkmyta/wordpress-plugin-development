<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	wp_die( sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'pdev' ),
		__FILE__
	) );
	exit;
}

// Clean de-registration of registered setting 
unregister_setting( 'pdev_plugin_options', 'pdev_plugin_options' );

// Remove saved options from the database 
delete_option( 'pdev_plugin_options' );
