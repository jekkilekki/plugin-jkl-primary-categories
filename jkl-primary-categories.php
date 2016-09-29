<?php
/**
 * @since           0.0.1
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @wordpress-plugin
 * Plugin Name:     JKL Primary Categories
 * Plugin URI:      https://github.com/jekkilekki/plugin-jkl-primary-categories
 * Description:     A simple plugin that allows you to set a Primary Category for a Post or Custom Post Type that has more than one category selected. Performs like Yoast SEO's implementation.
 * Version:         1.0.1
 * Author:          Aaron Snowberger
 * Author URI:      http://www.aaronsnowberger.com
 * Text Domain:     jkl-primary-categories
 * Domain Path:     /languages/
 * License:         GPL2
 * 
 * Requires at least: 3.5
 * Tested up to:    4.6
 */

/**
 * JKL Primary Categories allows you to set a Primary Category for a Post or Custom Post Type.
 * Copyright (C) 2016  AARON SNOWBERGER (email: JEKKILEKKI@GMAIL.COM)
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/* Prevent direct access */
if ( ! defined( 'WPINC' ) ) die;

/*
 * The class that represents and defines the Core plugin
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/class-jkl-primary-categories.php';

/*
 * The class that represents and defines our Welcoming Page
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/class-jkl-pc-welcome.php';

/*
 * The class that represents and defines our Admin Pointer object
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/class-jkl-pc-admin-pointer.php';

/**
 * Function to run on plugin activation to create our Welcome Page
 * 
 * @link    https://premium.wpmudev.org/blog/plugin-welcome-screen/         Basic function calls & structure
 * @link    http://www.wpexplorer.com/how-to-wordpress-custom-dashboard/    Basic Welcome Page Styles
 */
function jkl_pc_create_welcome_screen() {

   set_transient( '_jkl_pc_welcome_redirect', true, 0 ); // 0 = unlimited time

}

/**
 * Function that displays an admin error message if Yoast SEO is found to be an active plugin
 */
function jkl_pc_compatibility_issue() {
    ?>
        <div class="error notice">
            <p><?php _e( '<strong>Detected Yoast SEO active.</strong> JKL Primary Categories conflicts with Yoast SEO\'s Primary Terms.<br>Please disable ONE of these plugins. You cannot use both for Primary Categories.', 'jkl-primary-categories' ); ?></p>
        </div>
    <?php
}

/*
 * The function that creates a new JKL_Primary_Categories object and runs the plugin
 */
function run_jkl_pc() {
    
    // If Yoast SEO is not active
    if( ! class_exists( 'WPSEO_Primary_Term' ) ) {
        
        // Instantiate the plugin class
        $JKL_PC = new JKL_Primary_Categories( 'jkl-primary-categories', '1.0.1' );
    
    } else {
        
         // Pop up our compatibility issue warning
        add_action( 'admin_notices', 'jkl_pc_compatibility_issue' );
        //die;
        
    }
}

// The Welcome Page requires an activation hook - it will only run when the plugin is first activated
register_activation_hook( __FILE__, 'jkl_pc_create_welcome_screen' );
// Run the JKL Primary Categories plugin after the plugins loaded hook - this allows us to check for Yoast SEO
add_action( 'plugins_loaded', 'run_jkl_pc' );