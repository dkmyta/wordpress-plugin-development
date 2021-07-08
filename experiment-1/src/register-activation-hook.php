<?php

namespace PDEV;

register_activation_hook( __FILE__, function() {
	require_once plugin_dir_path( __FILE__ ) . 'src/Activation.php';
	Activation::activate();
} );
