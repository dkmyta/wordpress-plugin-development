<?php
/**
 * Plugin Name:       My Plugin
 * Plugin URI:        https://example.com/plugins/pdev
 * Description:       A short description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.3
 * Requires PHP:      5.6
 * Author:            John Doe
 * Author URI:        https://example.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pdev
 * Domain Path:       /public/lang
 */

/*
Copyright (C) <year>  <name of author>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

/**
 * PHPDoc Example
 * 
 * Short Description.
 * 
 * Longer and more detailed description.
 * 
 * @param type $param_a Description.
 * @param type $param_b Description.
 * @return type
 */
function pdev_function( $param_a, $param_b ) {
    // Do stuff.
}

/* Comment out dashboard menu item and submenu items
add_action( 'admin_menu', 'pdev_create_menu' );
             
function pdev_create_menu() {
             
    //create custom top-level menu
    add_menu_page( 'PDEV Settings Page', 'PDEV Settings',
        'manage_options', 'pdev-options', 'pdev_settings_page',
        'dashicons-smiley', 99 );

    //create submenu items
    add_submenu_page( 'pdev-options', 'About The PDEV Plugin', 'About', 'manage_options',
        'pdev-about', 'pdev_about_page' );
    add_submenu_page( 'pdev-options', 'Help With The PDEV Plugin', 'Help', 'manage_options',
        'pdev-help', 'pdev_help_page' );
    add_submenu_page( 'pdev-options', 'Uninstall The PDEV Plugin', 'Uninstall', 'manage_options',
        'pdev-uninstall', 'pdev_uninstall_page' );
             
}

//placerholder function for the settings page
function pdev_settings_page() {

}

//placerholder function for the about page
function pdev_about_page() {

}

//placerholder function for the help page
function pdev_help_page() {

}

//placerholder function for the uninstall page
function pdev_uninstall_page() {

}
*/

// Add a menu for our option page
add_action( 'admin_menu', 'pdev_plugin_add_settings_menu' );

function pdev_plugin_add_settings_menu() {

    add_options_page( 'PDEV Plugin Settings', 'PDEV Settings', 'manage_options',
        'pdev_plugin', 'pdev_plugin_option_page' );

}
        
// Create the option page
function pdev_plugin_option_page() {
    ?>
    <div class="wrap">
	    <h2>My plugin</h2>
	    <form action="options.php" method="post">
		    <?php 
            settings_fields( 'pdev_plugin_options' );
		    do_settings_sections( 'pdev_plugin' );
		    submit_button( 'Save Changes', 'primary' ); 
            ?>
	    </form>
    </div>
    <?php
}

// Register and define the settings
add_action('admin_init', 'pdev_plugin_admin_init');

function pdev_plugin_admin_init(){

	// Define the setting args
	$args = array(
	    'type' 				=> 'string', 
	    'sanitize_callback' => 'pdev_plugin_validate_options',
	    'default' 			=> NULL
	);

    // Register our settings
    register_setting( 'pdev_plugin_options', 'pdev_plugin_options', $args );
    
    // Add a settings section
    add_settings_section( 
    	'pdev_plugin_main', 
    	'PDEV Plugin Settings',
        'pdev_plugin_section_text', 
        'pdev_plugin' 
    );
    
    // Create our settings field for name
    add_settings_field( 
    	'pdev_plugin_name', 
    	'Your Name',
        'pdev_plugin_setting_name', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

    
    // Create our settings field for favorite holiday
    add_settings_field( 
    	'pdev_plugin_fav_holiday', 
    	'Favorite Holiday',
        'pdev_plugin_setting_fav_holiday', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

    // Create our settings field for beast mode
    add_settings_field( 
    	'pdev_plugin_beast_mode', 
    	'Enable Beast Mode?',
        'pdev_plugin_setting_beast_mode', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

}

// Draw the section header
function pdev_plugin_section_text() {

    echo '<p>Enter your settings here.</p>';

}
        
// Display and fill the Name text form field
function pdev_plugin_setting_name() {

    // Get option 'text_string' value from the database
    $options = get_option( 'pdev_plugin_options' );
    $name = $options['name'];

    // Echo the field
    echo "<input id='name' name='pdev_plugin_options[name]'
        type='text' value='" . esc_attr( $name ) . "' />";

}

// Display and select the favorite holiday select field
function pdev_plugin_setting_fav_holiday() {

    // Get option 'fav_holiday' value from the database
    // Set to 'Halloween' as a default if the option does not exist
	$options = get_option('pdev_plugin_options', [ 'fav_holiday' => 'Halloween' ] );
	$fav_holiday = $options['fav_holiday'];

	// Define the select option values for favorite holiday
	$items = array( 'Halloween', 'Christmas', 'New Years');
	
	echo "<select id='fav_holiday' name='pdev_plugin_options[fav_holiday]'>";
	
	foreach( $items as $item ) {

		// Loop through the option values
		// If saved option matches the option value, select it
		echo "<option value='" . esc_attr( $item ) . "' ".selected( $fav_holiday, $item, false ).">" . esc_html( $item ) . "</option>";
	
	}

	echo "</select>";

}

//Display and set the Beast Mode radion button field
function pdev_plugin_setting_beast_mode() {

	// Get option 'beast_mode' value from the database
    // Set to 'disabled' as a default if the option does not exist
	$options = get_option( 'pdev_plugin_options', [ 'beast_mode' => 'disabled' ] );
	$beast_mode = $options['beast_mode'];
	
	// Define the radio button options
	$items = array( 'enabled', 'disabled' );

	foreach( $items as $item ) {

		// Loop the two radio button options and select if set in the option value
		echo "<label><input " . checked( $beast_mode, $item, false ) . " value='" . esc_attr( $item ) . "' name='pdev_plugin_options[beast_mode]' type='radio' />" . esc_html( $item ) . "</label><br />";

	}

}

// Validate user input for all three options
function pdev_plugin_validate_options( $input ) {

	// Only allow letters and spaces for the name
    $valid['name'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['name'] );
        
    if( $valid['name'] !== $input['name'] ) {

        add_settings_error(
            'pdev_plugin_text_string',
            'pdev_plugin_texterror',
            'Incorrect value entered! Please only input letters and spaces.',
            'error'
        );

    }
        
    // Sanitize the data we are receiving 
    $valid['fav_holiday'] = sanitize_text_field( $input['fav_holiday'] );
    $valid['beast_mode'] = sanitize_text_field( $input['beast_mode'] );

    return $valid;
}
?>