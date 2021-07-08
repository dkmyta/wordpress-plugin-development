<?php

namespace PDEV;

register_deactivation_hook( __FILE__, function() {
	require_once plugin_dir_path( __FILE__ ) . 'src/Deactivation.php';
	Deactivation::deactivate();
} );
