<?php
/**
 * Plugin Name:       Dean's Plugin
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

// Use plugin_loaded hook to call a setup class
add_action( 'plugins_loaded', 'pdev_plugin_bootstrap' );

function pdev_plugin_bootstrap() {

	require_once plugin_dir_path( __FILE__ ) . 'src/Setup.php';

	$setup = new \PDEV\Setup();

	$setup->boot();

	// Display folder path with echo $setup->path;
	
}

// Add a menu for our option page
add_action( 'admin_menu', 'pdev_plugin_add_settings_menu' );

function pdev_plugin_add_settings_menu() {

    add_options_page( 'Dean\'s Plugin Settings', 'Dean\'s Plugin Settings', 'manage_options',
        'pdev_plugin', 'pdev_plugin_option_page' );

}
        
// Create the option page
function pdev_plugin_option_page() {
    ?>
    <div class="wrap">
	    <h2>Dean's Plugin</h2>
	    <form action="options.php" method="post">
		    <?php 
            settings_fields( 'pdev_plugin_options' );
		    do_settings_sections( 'pdev_plugin' );
		    submit_button( 'Save Changes', 'primary' ); 
			// Create a Nonce
			wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
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
    	'Dean\'s Plugin Settings',
        'pdev_plugin_section_text', 
        'pdev_plugin' 
    );
    
    // Create our settings field for fname
    add_settings_field( 
    	'pdev_plugin_fname', 
    	'First Name',
        'pdev_plugin_setting_fname', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

    // Create our settings field for lname
    add_settings_field( 
        'pdev_plugin_lname', 
        'Last Name',
        'pdev_plugin_setting_lname', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );
    
    // Create our settings field for level
    add_settings_field( 
    	'pdev_plugin_level', 
    	'Level',
        'pdev_plugin_setting_level', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

    // Create our radio settings field for gender
    add_settings_field( 
    	'pdev_plugin_gender', 
    	'Gender',
        'pdev_plugin_setting_gender', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );
    
    // Create our checkbox setting field for mode
    add_settings_field( 
    	'pdev_plugin_mode', 
    	'Enable Mode?',
        'pdev_plugin_setting_mode', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

    // Create our textarea setting field for bio
    add_settings_field( 
    	'pdev_plugin_bio', 
    	'Bio',
        'pdev_plugin_setting_bio', 
        'pdev_plugin', 
        'pdev_plugin_main' 
    );

}

// Draw the section header
function pdev_plugin_section_text() {

    echo '<p>Enter your settings here.</p>';

}
        
// Display and fill the First Name text form field
function pdev_plugin_setting_fname() {

    // Get option 'text_string' value from the database
    $options = get_option( 'pdev_plugin_options' );
	$fname = '';
    if ( isset( $options['fname'] ) ) {
		$fname = $options['fname'];
	} 
	
    // Echo the field
    echo "<input id='name' name='pdev_plugin_options[fname]'
        type='text' value='" . esc_attr( $fname ) . "' />";

}

// Display and fill the Last Name text form field
function pdev_plugin_setting_lname() {

    // Get option 'text_string' value from the database
    $options = get_option( 'pdev_plugin_options' );
	$lname = '';
    if ( isset( $options['lname'] ) ) {
		$lname = $options['lname'];
	}
    // Echo the field
    echo "<input id='name' name='pdev_plugin_options[lname]'
        type='text' value='" . esc_attr( $lname ) . "' />";

}

// Display and select the level select field
function pdev_plugin_setting_level() {

    // Get option 'level' value from the database
    // Set to 0 as a default if the option does not exist
	$options = get_option('pdev_plugin_options', [ 'level' => 0 ] );
	$level = $options['level'];

	// Define the select option values for level
	$items = array( 0, 1, 2, 3, 4, 5 );
	
	echo "<select id='level' name='pdev_plugin_options[level]'>";
	
	foreach( $items as $item ) {

		// Loop through the option values
		// If saved option matches the option value, select it
		echo "<option value='" . esc_attr( $item ) . "' " . selected( $level, $item, false ) . ">" . esc_html( $item ) . "</option>";
	
	}

	echo "</select>";

}

//Display and set the Gender radion button field
function pdev_plugin_setting_gender() {

	// Get option 'gender' value from the database
    // Set to 'Male' as a default if the option does not exist
	$options = get_option( 'pdev_plugin_options', [ 'gender' => 'Male' ] );
	$gender = $options['gender'];
	
	// Define the radio button options
	$items = array( 'Male', 'Female', 'Other' );

	foreach( $items as $item ) {

		// Loop the three radio button options and select if set in the option value
		echo "<label><input " . checked( $gender, $item, false ) . " value='" . esc_attr( $item ) . "' name='pdev_plugin_options[gender]' type='radio' />" . esc_html( $item ) . "</label>&nbsp&nbsp";

	}

}

//Display and set the Mode checkbox button field
function pdev_plugin_setting_mode() {

	// Get option 'mode' value from the database
    // Set to 'false' as a default if the option does not exist
	$options = get_option( 'pdev_plugin_options', [ 'mode' => 0 ] );
	$mode = $options['mode'];

    echo "<input value='0' name='pdev_plugin_options[mode]' type='hidden' />";
    echo "<input " . checked( 1, $mode, false ) . " value='1' name='pdev_plugin_options[mode]' type='checkbox' />";

}

// Display and fill the Bio text form field
function pdev_plugin_setting_bio() {

    // Get option 'text_string' value from the database
    // Set to 'Enter text here' as a default if the option does not exist
    $options = get_option( 'pdev_plugin_options', [ 'bio' => 'Enter text here'] );
    $bio = $options['bio'];

    // Echo the field
    echo "<textarea id='bio' name='pdev_plugin_options[bio]'>" . $bio . "</textarea>";

}

// Validate user input for all three options
function pdev_plugin_validate_options( $input ) {

	// Verify the Nonce
	if (
		! isset( $_POST['name_of_nonce_field'] )
		|| ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' )
	) {
	   wp_nonce_ays( '' );
	} 

	// Or verify the Nonce using check_admin_referer( 'name_of_my_action', 'name_of_nonce_field' );

	// Only allow letters and spaces for the fname
    $valid['fname'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['fname'] );
        
    if( $valid['fname'] !== $input['fname'] ) {

        add_settings_error(
            'pdev_plugin_text_string',
            'pdev_plugin_texterror',
            'Incorrect value entered! Please only input letters and spaces.',
            'error'
        );

    }

    // Only allow letters and spaces for the lname
    $valid['lname'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['lname'] );
        
    if( $valid['lname'] !== $input['lname'] ) {

        add_settings_error(
            'pdev_plugin_text_string',
            'pdev_plugin_texterror',
            'Incorrect value entered! Please only input letters and spaces.',
            'error'
        );

    }
        
    // Sanitize the data we are receiving 
    $valid['level'] = sanitize_text_field( $input['level'] );
    $valid['gender'] = sanitize_text_field( $input['gender'] );
    $valid['mode'] = sanitize_text_field( $input['mode'] );
    $valid['bio'] = sanitize_text_field( $input['bio'] );

    return $valid;
}

// Enqueue JavaScript for registering block type
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script(
        'pdev/hello-world',
        plugins_url( 'pdev.build.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element' )
    );
} );

// Register custom post type for Book Collection

// Load custom post type functions.
require_once plugin_dir_path( __FILE__ ) . 'post-types.php';
require_once plugin_dir_path( __FILE__ ) . 'post-meta.php';
require_once plugin_dir_path( __FILE__ ) . 'meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'taxonomies.php';

// Display message in footer based on user's logged-in status
add_action( 'wp_footer', 'pdev_logged_in_message' );

function pdev_logged_in_message() {

    // Count users
    $count = count_users();

    $current_user = wp_get_current_user();

    if ( is_user_logged_in() ) {
        echo '<p>Welcome back ' . $current_user->display_name . '! You are currently logged in.</p>';
        // Output the total user count
        printf(
            '<p>This site has %s users:</p>',
            absint( $count['total_users'] )
        );
        // Output each role and its number of users
        echo '<ul>';
        foreach ( $count['avail_roles'] as $role => $user_count ) {
            if ( $role !== 'none' ) {
                printf(
                    '<li>%1$s: %2$s</li>',
                    esc_html( $role ),
                    absint( $user_count )
                );
            }
        }
        echo '</ul>';
    } else {
        echo '<p>You are not logged into the site.</p>';
    }

}

// Inset "John Doe" user with wp_insert_user
add_action( 'init', 'pdev_insert_user' );

function pdev_insert_user() {

	// Bail if the user already exists.
	if ( username_exists( 'johndoe' ) ) {
		return;
	}

	// Create new user.
	$user = wp_insert_user( [
		'user_login'   => 'johndoe',
		'user_email'   => 'john@example.com',
		'user_pass'    => '123456789',
		'user_url'     => 'https://wordpress.org',
		'display_name' => 'John Doe',
		'role'         => 'editor',
		'description'  => 'Loves to publish books on WordPress!'
	] );

	// If the user wasn't created, display error message.
	if ( is_wp_error( $user ) ) {
		echo $user->get_error_message();
	}
}

// Create "Jane Doe" user with wp_create_user
add_action( 'init', 'pdev_create_user' );

function pdev_create_user() {

	// Bail if the user already exists.
	if ( username_exists( 'janedoe' ) ) {
		return;
	}

	// Create new user.
	$user = wp_create_user(
		'janedoe',
		'123456789',
		'jane@example.com'
	);

	// If the user wasn't created, display error message.
	if ( is_wp_error( $user ) ) {
		echo $user->get_error_message();
	}
}

// Force current user admin_color to blue with wp_update_user
add_action( 'admin_init', 'pdev_force_admin_color' );

function pdev_force_admin_color() {

	// Get the current WP_User object.
	$user = wp_get_current_user();

	// Bail if no current user object.
	if ( empty( $user ) ) {
		return;
	}

	// Get user's admin color scheme.
	$color = get_user_meta( $user->ID, 'admin_color', true );

	// If not the fresh color scheme, update it.
	if ( 'blue' !== $color ) {

		wp_update_user( [
			'ID'          => $user->ID,
			'admin_color' => 'blue'
		] );
	}
}

// Update "John Doe" user display_name to "John Updated" with wp_update_user
add_action( 'admin_init', 'pdev_update_user' );

function pdev_update_user() {

    wp_update_user( [
        'ID'           => 7,
        'display_name' => 'John Updated'
    ] );

}

// Delete "John Updated" user with wp_delete_user, reassign posts to "Jane Doe"
// add_action( 'admin_init', 'pdev_delete_user' );

// function pdev_delete_user() {
    
//     wp_delete_user( 7, 3 );

// }
