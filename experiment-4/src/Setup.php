<?php

namespace PDEV;

class Setup {

	public $path;

	public function boot() {

		// Store the plugin folder path.
		$this->path = plugin_dir_path( __FILE__ );

		// Run other setup code here.
	}
}