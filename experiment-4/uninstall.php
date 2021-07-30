<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	wp_die( sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'pdev' ),
		__FILE__
	) );
	exit;
}

$role = get_role( 'administrator' );

if ( ! empty( $role ) ) {
	$role->remove_cap( 'pdev_manage' );
}

// Register our uninstall function
//register_uninstall_hook( __FILE__, 'pdev_plugin_uninstall' );

// Deregister our settings group and delete all options
//function pdev_plugin_uninstall() {

	// Clean de-registration of registered setting
	unregister_setting( 'pdev_plugin_options', 'pdev_plugin_options' );

	// Remove saved options from the database
	delete_option( 'pdev_plugin_options' );

//}