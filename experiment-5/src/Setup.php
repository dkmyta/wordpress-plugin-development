<?php

namespace PDEV;

class Setup {

	public $path;

	public function boot() {

		// Store the folder path of the Setup.php file -> /var/www/html/wp-content/plugins/experiment-4/src/
		// For plugin folder path move Setup.php to root
		$this->path = plugin_dir_path( __FILE__ );

		// Run other setup code here.
	}
}