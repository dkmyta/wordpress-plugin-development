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

// Apply Related Posts list functionality to individual post pages using WordPress Cache API
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

// add_action example using wp_head hook to add text to the site header
add_action( 'wp_head', 'pdev_header_message', PHP_INT_MAX );

function pdev_header_message() {
	esc_html_e( 'This site\'s head is powered by Dean.', 'pdev' );
}

// add_action example using wp_footer hook to add text to the site footer
add_action( 'wp_footer', 'pdev_footer_message', PHP_INT_MAX );

function pdev_footer_message() {
	esc_html_e( 'This site\'s foot is powered by Dean.', 'pdev' );
}

/* has_action example to verify if wp_footer hook has actions applied
if ( has_action( 'wp_footer' ) ) {
	echo '<p>Actions are registerd for the footer.</p>';
} else {
	// Test accuracy with remove_all_actions( 'wp_footer' );
	echo '<p>No actions are registered for the footer.</p>';
} This causes a Cannot modify header information – headers already sent by... error and saving form input causes WSOD - Why might this be happening? Perhaps it is called too late*/

/* has_action example to print the priority value of the wp_print_footer_scripts action of the wp_footer hook, if it exists
$priority = has_action( 'wp_footer', 'wp_print_footer_scripts' );

if ( false !== $priority ) {
	printf(
		'The wp_print_footer_scripts action has a priority of %d. </br>', absint( $priority )
	);
} This causes a Cannot modify header information – headers already sent by... error and saving form input causes WSOD*/

// add_action example using pre_get_posts action hook to randomize the order of posts on blog homepage
add_action( 'pre_get_posts', 'pdev_random_posts' );

function pdev_random_posts( $query ) {

	if ( $query->is_main_query() && $query->is_home() ) {
		$query->set( 'orderby', 'rand' );
	}
}

// add_filter example to remove "bad words" from post title and content
add_filter( 'the_title',   'pdev_remove_bad_words' );
add_filter( 'the_content', 'pdev_remove_bad_words' );

function pdev_remove_bad_words( $text ) {

	$words = [];

	if ( 'the_title' === current_filter() ) {
		$words = [
			'test',
			'bad_word_b'
		];
	} elseif ( 'the_content' === current_filter() ) {
		$words = [
			'test',
			'bad_word_d'
		];
	}

	if ( $words ) {
		$text = str_replace( $words, '***', $text );
	}

	return $text;
}

// add_filter example to present subscribe input field at the end of post content
add_filter( 'the_content', 'pdev_content_subscription_form', PHP_INT_MAX );

function pdev_content_subscription_form( $content ) {

	if ( is_singular( 'post' ) && in_the_loop() ) {

		$content .= '<div class="pdev-subscription">
			<p>Thank you for reading. Please subscribe to my email list for updates.</p>
			<form method="post">
				<p>
					<label>
					</br>
						Email:
						<input type="email" value="" />
					</label>
				</p>
				</br>
				<p>
					<input type="submit" value="Submit" />
				</p>
			</form>
		</div>';
	}

	return $content;
}

// add_filter examples using template_include hook to use specific template when a certain custom post type is used
add_filter( 'template_include', 'pdev_template_include' );

function pdev_template_include( $template ) {

	if ( is_post_type_archive( 'movie' ) ) {

		$template = locate_template( 'pdev-movie-archive.php' );

		if ( ! $locate ) {
			$template = require_once plugin_dir_path( __FILE__ )
			            . 'templates/pdev-movie-archive.php';
		}

	} elseif ( is_singular( 'movie' ) ) {

		$template = locate_template( 'pdev-single-movie.php' );

		if ( ! $locate ) {
			$template = require_once plugin_dir_path( __FILE__ )
			            . 'templates/pdev-single-movie.php';
		}
	}

	return $template;
}

// add_actions examples using widgits_init hook to create the widget 
class deans_widget extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	
	// Base ID of your widget
	'deans_widget', 
	
	// Widget name will appear in UI
	__('Dean\'s Widget', 'deans_widget_domain'), 
	
	// Widget description
	array( 'description' => __( 'Sample widget', 'deans_widget_domain' ), ) 
	);

	}
	
	// Creating widget front-end
	
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
	
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
		// This is where you run the code and display the output
		echo __( 'Hello, World!', 'deans_widget_domain' );
		echo $args['after_widget'];

	}
			
	// Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'deans_widget_domain' );
		}
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 

	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;

	}
	
	// Class wpb_widget ends here
} 
 
// Register and load the widget
function deans_load_widget() {

    register_widget( 'deans_widget' );

}

add_action( 'widgets_init', 'deans_load_widget' );
