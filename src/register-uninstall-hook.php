<?php

register_uninstall_hook( __FILE__, 'pdev_uninstall' );

function pdev_uninstall() {
	$role = get_role( 'administrator' );

	if ( ! empty( $role ) ) {
		$role->remove_cap( 'pdev_manage' );
	}
}
