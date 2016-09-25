<?php
/**
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
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
         * Initializes the JKL_Primary_Categories Object and sets its properties
         * @since   0.0.1
         * @var     String  $version    The version of this plugin.
         * @var     String  $name       The ID of this plugin.
         */
        public function __construct() {
            
            // Load the plugin and supplementary files
            $this->run();
            
        }
        
        /**
         * 
         */
        public function run() {
            
            //set_transient( '_jkl_pc_welcome_redirect', true, 0 );
            
            add_action( 'admin_init', array( $this, 'jkl_pc_welcome_screen_redirect' ) );
            
            add_action( 'admin_menu', array( $this, 'jkl_pc_welcome_screen_page' ) );
            
            add_action( 'admin_head', array( $this, 'jkl_pc_welcome_screen_remove_menus' ) );
        }
        
        /**
         * 
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
        }
        
        /**
         * 
         */
        public function jkl_pc_welcome_screen_page() {
            add_dashboard_page(
                    'JKL Primary Categories',
                    'JKL Primary Categories',
                    'read', 
                    'jkl-pc-welcome',             // page name
                    array( $this, 'jkl_welcome_screen_content' )            // callback
            );
        }
        
        /**
         * 
         */
        public function jkl_welcome_screen_content() {
            // Require the View for the Welcome Page
            require_once plugin_dir_path( __FILE__ ) . '../views/view-jkl-pc-welcome-page.php';
        }
        
        /**
         * 
         */
        public function jkl_pc_welcome_screen_remove_menus() {
            remove_submenu_page( 'index.php', 'jkl-pc-welcome' );
        }
        
    } // END class JKL_PC_Welcome
    
} // END if ( ! class_exists() )