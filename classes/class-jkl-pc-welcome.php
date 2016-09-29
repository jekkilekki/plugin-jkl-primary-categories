<?php
/**
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * @since           0.0.1
 * 
 * The Welcome Page for the plugin.
 * 
 * Sends a nice greeting and introduces some of the features of the plugin.
 * 
 * @link            https://premium.wpmudev.org/blog/plugin-welcome-screen
 */
/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
/* Avoid redefining a class with the same name */
if ( ! class_exists( 'JKL_PC_Welcome' ) ) {
    
    class JKL_PC_Welcome {
        
        /**
         * CONSTRUCTOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_PC_Welcome Object and sets its properties
         * @since   0.0.1
         */
        public function __construct() {
            
            // Call WordPress action and filter hooks to run the plugin
            $this->run();
            
        } // END __construct()
        
        /**
         * Hooks into admin actions to create our Welcome Page and show it 
         * immediately upon plugin activation
         */
        public function run() {
            
            // Redirect to the Welcome Screen
            add_action( 'admin_init', array( $this, 'jkl_pc_welcome_screen_redirect' ) );
            // Create the Welcome Screen
            add_action( 'admin_menu', array( $this, 'jkl_pc_welcome_screen_page' ) );
            // Remove the Welcome Screen from the menus
            add_action( 'admin_head', array( $this, 'jkl_pc_welcome_screen_remove_menus' ) );
            
        } // END run()
        
        /**
         * Redirects the user to our Welcome Page
         */
        public function jkl_pc_welcome_screen_redirect() {
            
            // Bail if no activation redirect
            if( ! get_transient( '_jkl_pc_welcome_redirect' ) ) { return; }
            
            // Delete redirect transient
            delete_transient( '_jkl_pc_welcome_redirect' );
            
            // Bail if activating from network, or bulk
            if( is_network_admin() || isset( $_GET[ 'activate-multi' ] ) ) { return; }
            
            // Redirect to Welcome Page
            wp_safe_redirect( add_query_arg( array( 
                'page'      => 'jkl-pc-welcome' 
            ), admin_url( 'index.php' ) ) );
            
        } // END jkl_pc_welcome_screen_redirect()
        
        /**
         * Create the Welcome Screen
         */
        public function jkl_pc_welcome_screen_page() {
            
            // Add a Page to the Dashboard
            add_dashboard_page(
                    'JKL Primary Categories',                       // $page_title
                    'JKL Primary Categories',                       // $menu_title
                    'read',                                         // $capability
                    'jkl-pc-welcome',                               // $menu_slug
                    array( $this, 'jkl_welcome_screen_content' )    // $function callback
            );
            
        } // END jkl_pc_welcome_screen_page()
        
        /**
         * Renders the Welcome Page (calls a View file)
         */
        public function jkl_welcome_screen_content() {
            
            // Include the View for the Welcome Page
            include_once plugin_dir_path( __FILE__ ) . '../views/view-jkl-pc-welcome-page.php';
        
        } // END jkl_welcome_screen_content()
        
        /**
         * Remove the Welcome Screen from the WordPress menus so users can't click it again
         */
        public function jkl_pc_welcome_screen_remove_menus() {
            remove_submenu_page( 'index.php', 'jkl-pc-welcome' );
        }
        
    } // END class JKL_PC_Welcome
    
} // END if ( ! class_exists() )