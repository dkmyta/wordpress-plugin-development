<?php

namespace PDEV;

class Deactivation {

	public static function deactivate() {
		// Run your deactivation code here.

		// Remove custom forum roles.
		remove_role( 'forum_administrator' );
		remove_role( 'forum_moderator'     );
		remove_role( 'forum_member'        );
		remove_role( 'forum_banned'        );
	}
}
