<?php

namespace PDEV;

class Deactivation {

	public static function deactivate() {
		// Run your deactivation code here.

		// Remove custom forum roles on deactivation, not uninstall (for now)
		remove_role( 'forum_administrator' );
		remove_role( 'forum_moderator'     );
		remove_role( 'forum_member'        );
		remove_role( 'forum_banned'        );
	}
}
