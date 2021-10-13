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

// Add register_activation_hook direct to primary plugin file
register_activation_hook( __FILE__, function() {
	require_once plugin_dir_path( __FILE__ ) . 'src/Activation.php';
	\PDEV\Activation::activate();
} );

// Require register_deactivation_hook file instead - *Does not work
// require_once plugin_dir_path( __FILE__ ) . 'src/register-activation-hook.php';

// Add register_deactivation_hook direct to primary plugin file
register_deactivation_hook( __FILE__, function() {
	require_once plugin_dir_path( __FILE__ ) . 'src/Deactivation.php';
	\PDEV\Deactivation::deactivate();
} );

// Require register_deactivation_hook file instead - *Does not work
// require_once plugin_dir_path( __FILE__ ) . 'src/register-deactivation-hook.php';

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

// Load custom post type functions.
require_once plugin_dir_path( __FILE__ ) . 'post-types.php';
require_once plugin_dir_path( __FILE__ ) . 'post-meta.php';
require_once plugin_dir_path( __FILE__ ) . 'meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'taxonomies.php';

// Display message in footer based on user's logged-in status
// wp_footer/wp_head frontend
// in_admin_footer/in_admin_header backend 
add_action( 'wp_footer', 'pdev_logged_in_message' );

function pdev_logged_in_message() {

    // Count users
    $count = count_users();

    // Get the current WP_User object.
    $current_user = wp_get_current_user();

    if ( is_user_logged_in() ) {
        echo '<p>Welcome back ' . $current_user->display_name . '! You are currently logged in.</p>';
        // Output the total user count
        printf(
			_n( 
				'<p>This site has %s user:</p>',
				'<p>This site has %s users:</p>',
				$count['total_users'],
				'experiment-10'
			),
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

// Insert "John Doe" user with wp_insert_user
// With this here its impossible to delete the user, 
// they are just regenerated again with a new ID
// What could you use so they are only created once?
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
// With this here its impossible to delete the user, 
// they are just regenerated again with a new ID
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

// Apply user rating system functionality based on number of posts using count_user_posts
add_action( 'save_post', 'pdev_add_user_rating' );

function pdev_add_user_rating() {

	// Get the current user object.
	$user = wp_get_current_user();

	// Get the user's current rating.
	$rating = get_user_meta( $user->ID, 'user_rating', true );

	// Bail if user already has gold rating.
	if ( 'gold' === $rating ) {
		return;
	}

	// Get the user's post count.
	$posts = count_user_posts( $user->ID );

	// Update the user's rating based on number of posts.
	if ( 50 <= $posts ) {
		update_user_meta( $user->ID, 'user_rating', 'gold' );
	} elseif ( 25 <= $posts ) {
		update_user_meta( $user->ID, 'user_rating', 'silver' );
	}

}

// Create a plugin with user metadata
// Add the form to the user/profile admin screen.
add_action( 'show_user_profile', 'pdev_user_favorite_post_form' );
add_action( 'edit_user_profile', 'pdev_user_favorite_post_form' );

function pdev_user_favorite_post_form( $user ) {

	$favorite = get_user_meta( $user->ID, 'favorite_post', true );

	$posts = get_posts( [ 'numberposts' => -1 ] ); ?>

	<h2>Favorites</h2>

	<table class="form-table">
		<tr>
			<th><label for="pdev-favorite-post">Favorite Post</label></th>

			<td>
				<select name="pdev_favorite_post" id="pdev-favorite-post">
					<option value="" <?php selected( '', $favorite ); ?>></option>

					<?php foreach ( $posts as $post ) {
						printf(
							'<option value="%s" %s>%s</option>',
							esc_attr( $post->ID ),
							selected( $post->ID, $favorite, false ),
							esc_html( $post->post_title )
						);
					} ?>
				</select>
				<br />
				<span class="description">Select your favorite post.</span>
			</td>
		</tr>
	</table>
 <?php }

// Add the update function to the user update hooks.
add_action( 'personal_options_update',  'pdev_user_favorite_post_update' );
add_action( 'edit_user_profile_update', 'pdev_user_favorite_post_update' );

function pdev_user_favorite_post_update( $user_id ) {

	// Bail if the current user cannot edit the user.
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}

	// Get the existing favorite post if the value exists.
	// If no existing favorite post, value is empty string.
	$old_favorite = get_user_meta( $user_id, 'favorite_post', true );

	// Sanitize to only accept numbers since it's a post ID.
	$new_favorite = preg_replace( "/[^0-9]/", '', $_POST['pdev_favorite_post'] );

	// Update the user's favorite post.
	update_user_meta( $user_id, 'favorite_post', $favorite_post );

	// If there's an old value but not a new value, delete old value.
	if ( ! $new_favorite && $old_favorite ) {
		delete_user_meta( $user_id, 'favorite_post' );

	// If the new value doesn't match the new value add/update.
	} elseif ( $new_value !== $old_value ) {
		update_user_meta( $user_id, 'favorite_post', $new_value );
	}
}

// Register single cron event, no deactivation necessary
register_activation_hook( __FILE__, 'pdev_cron_single_activation' );

function pdev_cron_single_activation() {

	$args = [
		'example@example.com'
	];

	if ( ! wp_next_scheduled( 'pdev_single_email', $args ) ) {

		wp_schedule_single_event( time() + 3600, 'pdev_single_email', $args );
	}
}

add_action( 'pdev_single_email', 'pdev_send_email_once' );

function pdev_send_email_once( $email ) {

	wp_mail(
		sanitize_email( $email ),
		'Plugin Name - Thanks',
		'Thank you for using my plugin! If you need help with it, let me know.'
	);
}

// Register recurring cron event, with deactivation hook registered to unschedule event
register_activation_hook( __FILE__, 'pdev_cron_example_activation' );

function pdev_cron_example_activation() {

	if ( ! wp_next_scheduled( 'pdev_example_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'pdev_example_event' );
	}
}

// Prepare text domain for internationalization
add_action( 'init', 'pdev_load_textdomain' );

function pdev_load_textdomain() {

	load_plugin_textdomain( 'experiment-10', false, 'experiment-10/languages' );

}

// To enable Multisite, the following must be added to the site's wp-config.php 
// define( 'WP_ALLOW_MULTSITE', true );

// Multisite site switching example
add_action( 'admin_menu', 'pdev_multisite_switch_menu' );
             
function pdev_multisite_switch_menu() {
             
    //create custom top-level menu
    add_menu_page( 'Multisite Switch', 'Multisite Switch',
        'manage_options',
        'pdev-network-switch', 'pdev_multisite_switch_page' );
             
}
             
function pdev_multisite_switch_page() {
             
    if ( is_multisite() ) {
             
        //switch to blog ID 3
        switch_to_blog( 2 );
             
        //create a custom Loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page=5' );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //store the recent posts in a variable
            echo '<p><a href="' .get_permalink(). '">' .
                get_the_title() .'</a></p>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
    }
             
}

// Multisite site switching shortcode example
add_shortcode( 'network_posts', 'pdev_multisite_network_posts' );
             
function pdev_multisite_network_posts( $attr ) {
    extract( shortcode_atts( array(
            "site_id"    =>    '1',
            "num"        =>    '5'
            ), $attr ) );
             
    if ( is_multisite() ) {
             
        $return_posts = '';
             
        //switch to site set in the shortcode
        switch_to_blog( absint( $site_id ) );
             
        //create a custom Loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page=' .absint( $num ) );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //store the recent posts in a variable
            $return_posts .= '<p><a href="' .get_permalink().
                '">' .get_the_title() .'</a></p>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
        //return the results to display
        return $return_posts;
             
    }
}

// Multisite network posts example
add_shortcode( 'latest_network_posts',
    'pdev_multisite_latest_network_posts' );
             
function pdev_multisite_latest_network_posts() {
             
    if ( is_multisite() ) {
             
        $return_posts = '';
             
        //get posts from current site
        $local_posts = get_posts( 'numberposts=5' );
             
        //switch to blog ID 3
        switch_to_blog( 3 );
             
        //get posts from another site
        $network_posts = get_posts( 'numberposts=5' );
             
        //restore the current site
        restore_current_blog();
             
        //merge the two arrays
        $posts = array_merge( $local_posts, $network_posts );
             
        //sort the post results by date
        usort( $posts, 'pdev_multisite_sort_posts_array' );
             
        foreach ( $posts as $post ) {
             
            //store latest posts in a variable
            $return_posts .= $post->post_title .' - posted on '
                .$post->post_date .'<br />';
             
        }
             
        //return the results to display
        return $return_posts;
             
    }
             
}
             
//sort the array by date
function pdev_multisite_sort_posts_array( $a, $b ) {
             
    //if dates are the same return 0
    if ($a->post_date == $b->post_date)
        return 0;
             
    //ternary operator to determine which date is newer
    return $a->post_date < $b->post_date ? 1 : -1;
             
}

// Multisite recent posts widget example
//widgets_init action hook to execute custom function
add_action( 'widgets_init', 'pdev_multisite_register_widget' );
             
//register our widget
function pdev_multisite_register_widget() {
    register_widget( 'pdev_multisite_widget' );
}
             
//pdev_multisite_widget class
class PDEV_Multisite_Widget extends WP_Widget {

    //process our new widget
    function __construct() {
             
        $widget_ops = array( 'classname' => 'pdev_multisite_widget',
            'description' =>
                'Display recent posts from a network site.' );
        parent::__construct( 'pdev_multisite_widget_posts',
            'Multisite Recent Posts', $widget_ops );
             
    }
             
     //build our widget settings form
    function form( $instance ) {
        global $wpdb;
             
        $defaults = array( 'title' => 'Recent Posts',
            'disp_number' => '5' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        $siteid = $instance['siteid'];
        $disp_number = $instance['disp_number'];
             
        //title textfield widget option
        echo '<p>Title: <input class="widefat" name="'
            .$this->get_field_name( 'title' )
            . '" type="text" value="' .esc_attr( $title )
            . '" /></p>';
             
        //get a list of all public site IDs
        $args = array (
            'public' => '1'
        );

        $sites = get_sites( $args );

        if ( is_array( $sites ) ) {

            echo '<p>';
            echo 'Site to display recent posts';
            echo '<select name="' .$this->get_field_name('siteid')
                .'" class="widefat" >';
             
            //loop through the blog IDs
            foreach ($sites as $site) {
             
                //display each site as an option
                echo '<option value="' .$site->blog_id. '" '
                    .selected( $site->blog_id, $siteid )
                    . '>' .get_blog_details( $site->blog_id )->blogname
                    . '</option>';
             
            }
             
            echo '</select>';
            echo '</p>';
        }
             
        //number to display textfield widget option
        echo '<p>Number to display: <input class="widefat" name="'
            .$this->get_field_name( 'disp_number' ). '" type="text"
            value="' .esc_attr( $disp_number ). '" /></p>';
             
    }
             
      //save the widget settings
    function update( $new_instance, $old_instance ) {
             
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['siteid'] = absint( $new_instance['siteid'] );
        $instance['disp_number'] =
            absint( $new_instance['disp_number'] );
             
        return $instance;
    }
             
     //display the widget
    function widget( $args, $instance ) {
        extract( $args );
             
        echo $before_widget;
             
        //load the widget options
        $title = apply_filters( 'widget_title', $instance['title'] );
        $siteid = empty( $instance['siteid'] ) ? 1 :
            $instance['siteid'];
         $disp_number = empty( $instance['disp_number'] ) ? 5 :
             $instance['disp_number'];
             
         //display the widget title
        if ( !empty( $title ) ) { echo $before_title . $title
            . $after_title; };
             
        echo '<ul>';
             
        //switch to site saved
        switch_to_blog( absint( $siteid ) );
             
        //create a custom loop
        $recent_posts = new WP_Query();
        $recent_posts->query( 'posts_per_page='
            .absint( $disp_number ) );
             
        //start the custom Loop
        while ( $recent_posts->have_posts() ) :
            $recent_posts->the_post();
             
            //display the recent post title with link
            echo '<li><a href="' .get_permalink(). '">'
                .get_the_title() .'</a></li>';
             
        endwhile;
             
        //restore the current site
        restore_current_blog();
             
        echo '</ul>';
        echo $after_widget;
             
    }
             
}

// Multisite create site example
add_action( 'admin_menu', 'pdev_multisite_create_menu' );
             
function pdev_multisite_create_menu() {
             
    //create custom top-level menu
    add_menu_page( 'Multisite Create Site Page',
        'Multisite Create Site',
        'manage_options', 'pdev-network-create',
        'pdev_multisite_create_site_settings' );
             
}
             
function pdev_multisite_create_site_settings() {
             
    //check if multisite is enabled
    if ( is_multisite() ) {
             
        //if the form was submitted lets process it
        if ( isset( $_POST['create_site'] ) ) {
             
            //populate the variables based on form values
            $domain = sanitize_text_field( $_POST['domain'] );
            $path = sanitize_text_field( $_POST['path'] );
            $title = sanitize_text_field( $_POST['title'] );
            $user_id = absint( $_POST['user_id'] );
             
            //verify the required values are set
            if ( $domain && $path && $title && $user_id ) {
             
                //create the new site in WordPress
                $new_site = wpmu_create_blog( $domain, $path,
                    $title, $user_id );
             
                //if successfully display a message
                if ( $new_site ) {
             
                    echo '<div class="notice notice-success is-dismissible">New site '
                        .$new_site. ' created successfully!</div>';
             
             
                }
             
            //if required values are not set display an error
            } else {
             
                echo '<div class="notice notice-error is-dismissible">
                    New site could not be created.
                    Required fields are missing
                    </div>';
             
            }
             
        }
        ?>
        <div class="wrap">
            <h2>Create New Site</h2>
            <form method="post">
            <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="fname">Domain</label>
                </th>
                <td><input maxlength="45" size="25" name="domain"
                        value="<?php echo DOMAIN_CURRENT_SITE; ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="fname">Path</label></th>
                <td>
                    <input maxlength="45" size="10" name="path" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="fname">Title</label></th>
                <td>
                    <input maxlength="45" size="25" name="title" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="fname">User ID</label>
                </th>
                <td>
                    <input maxlength="45" size="3" name="user_id" />
                </td>
            </tr>
            <tr valign="top">
                <td>
                <input type="submit" name="create_site"
                    value="Create Site" class="button-primary" />
                <input type="submit" name="reset" value="Reset"
                    class="button-secondary" />
                </td>
            </tr>
            </table>
            </form>
        </div>
        <?php
    } else {
             
        echo '<p>Multisite is not enabled</p>';
             
    }
             
}

// Multisite add user example
add_action( 'init', 'pdev_multisite_add_user_to_site' );
             
function pdev_multisite_add_user_to_site() {
             
    //verify user is logged in before proceeding
    if( !is_user_logged_in() )
        return false;
             
    //load current blog ID and user data
    global $current_user,$blog_id;
             
    //verify user is not a member of this site
    if( !is_user_member_of_blog() ) {
             
        //add user to this site as a subscriber
        add_user_to_blog( $blog_id, $current_user->ID, 'subscriber' );
             
    }
             
}