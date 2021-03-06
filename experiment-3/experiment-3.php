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
    $fname = $options['fname'];

    // Echo the field
    echo "<input id='name' name='pdev_plugin_options[fname]'
        type='text' value='" . esc_attr( $fname ) . "' />";

}

// Display and fill the Last Name text form field
function pdev_plugin_setting_lname() {

    // Get option 'text_string' value from the database
    $options = get_option( 'pdev_plugin_options' );
    $lname = $options['lname'];

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
	$options = get_option( 'pdev_plugin_options' );
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

// Nonce Example
add_action( 'admin_menu', 'pdev_nonce_example_menu'   );
add_action( 'admin_init', 'pdev_nonce_example_verify' );

function pdev_nonce_example_menu() {

	add_menu_page(
		'Nonce Example',
		'Nonce Example',
		'manage_options',
		'pdev-nonce-example',
		'pdev_nonce_example_template'
	);
}

function pdev_nonce_example_verify() {

	// Bail if no nonce field.
	if ( ! isset( $_POST['pdev_nonce_name'] ) ) {
		return;
	}

	// Display error and die if not verified.
	if ( ! wp_verify_nonce( $_POST['pdev_nonce_name'], 'pdev_nonce_action' ) ) {
		wp_die( 'Your nonce could not be verified.' );
	}

	// Sanitize and update the option if it's set.
	if ( isset( $_POST['pdev_nonce_example'] ) ) {
		update_option(
			'pdev_nonce_example',
			wp_strip_all_tags( $_POST['pdev_nonce_example'] )
		);
	}
}

function pdev_nonce_example_template() { ?>

	<div class="wrap">
		<h1 class="wp-heading-inline">Nonce Example</h1>

		<?php $value = get_option( 'pdev_nonce_example' ); ?>

		<form method="post" action="">

			<?php wp_nonce_field( 'pdev_nonce_action', 'pdev_nonce_name' ); ?>

			<p>
				<label>
					Enter your name:
					<input type="text" name="pdev_nonce_example" value="<?php echo esc_attr( $value ); ?>" />
				</label>
			</p>

			<?php submit_button( 'Submit', 'primary' ); ?>
		</form>
	</div>
<?php }

// Apply Related Posts functionality using WordPress Cache API
add_filter( 'the_content', 'pdev_related_posts' );

function pdev_related_posts( $content ) {

	// Bail if not viewing a single post.
	if ( ! is_singular( 'post' ) || ! in_the_loop() ) {
		return $content;
	}

	// Get the current post ID.
	$post_id = get_the_ID();

	// Check for cached posts.
	$posts = wp_cache_get( $post_id, 'pdev_related_posts' );

	// If no cached posts, query them.
	if ( ! isset( $cache ) ) {
		$categories = get_the_category();

		$posts = get_posts( [
			'category' => absint( $categories[0]->term_id ),
			'post__not_in' => [ $post_id ],
			'numberposts'  => 5
		] );

		// Save the cached posts.
		if ( $posts ) {
			wp_cache_set(
				$post_id,
				$posts,
				'pdev_related_posts',
				DAY_IN_SECONDS
			);
		}
	}

	// If posts were found at this point.
	if ( $posts ) {

		$content .= '<h3>Related Posts</h3>';

		$content .= '<ul>';

		foreach ( $posts as $post ) {
			$content .= sprintf(
				'<li><a href="%s">%s</a></li>',
				esc_url( get_permalink( $post->ID ) ),
				esc_html( get_the_title( $post->ID ) )
			);
		}

		$content .= '</ul>';
	}
    return $content;
}

// Add a toolbar link to the Dean's Plugin Settings to the admin screen
add_action( 'wp_before_admin_bar_render', 'pdev_toolbar' );

function pdev_toolbar() {
	global $wp_admin_bar;

	if ( current_user_can( 'edit_users' ) ) {

		$wp_admin_bar->add_menu( [
			'id'    => 'pdev-users',
			'title' => 'Dean\'s Plugin Settings',
			'href'  => esc_url( admin_url( 'options-general.php?page=pdev_plugin' ) )
		] );
	}
}

// Transient API usage example
// Fetches video from third-party website.
function pdev_fetch_video_title() {
	// Connect to an API to fetch video.
	return $title;
}

// Returns the video title.
function pdev_get_video_title() {

	// Get transient.
	$title = get_transient( 'pdev_video_tutorial' );

	// If the transient doesn't exist or is expired, refresh it.
	if ( ! $title ) {
		$title = pdev_fetch_video_title();

		set_transient( 'pdev_video_tutorial', $title, DAY_IN_SECONDS );
	}

	return $title;
}