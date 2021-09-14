<?php

namespace PDEV;

class Activation {

	public static function activate() {
		// Run your activation code here.
		
		// Get the administrator role.
		$administrator = get_role( 'administrator' );

		// Add forum capabilities to the administrator role.
		$administrator->add_cap( 'create_forums'   );
		$administrator->add_cap( 'create_threads'  );
		$administrator->add_cap( 'modreate_forums' );

		// Add a forum administrator role.
		add_role( 'forum_administrator', 'Forum Administrator', [
			'read'            => true,
			'create_forums'   => true,
			'create_threads'  => true,
			'moderate_forums' => true
		] );

		// Add a forum moderator role.
		add_role( 'forum_moderator', 'Forum Moderator', [
			'read'            => true,
			'create_threads'  => true,
			'moderate_forums' => true
		] );

		// Add a forum member role.
		add_role( 'forum_member', 'Forum Member', [
			'read'            => true,
			'create_threads'  => true
		] );

		// Add a banned forum role.
		add_role( 'forum_banned', 'Forum Banned', [
			'read'            => true,
			'create_forums'   => false,
			'create_threads'  => false,
			'moderate_forums' => false
		] );
	}
}
