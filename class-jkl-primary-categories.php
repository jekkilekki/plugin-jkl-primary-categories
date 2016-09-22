<?php
/**
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * The main plugin class that handles all other plugin parts.
 * 
 * Defines the plugin name, version, and hooks for enqueing the JavaScript.
 */

/**
 * Plugin Notes:
 * Save Post / Update Meta
 * @link https://www.sitepoint.com/extend-the-quick-edit-actions-in-the-wordpress-dashboard/
 * My Custom Meta in a Theme
 * @link https://github.com/jekkilekki/theme-jin/blob/master/page-templates/page-client.php
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Avoid redefining a class with the same name */
if ( ! class_exists( 'JKL_Primary_Categories' ) ) {
    
    class JKL_Primary_Categories {
        
        /**
         * Current version of this plugin.
         * @since   0.0.1
         * @access  private
         * @var     String  $version    The current version of this plugin.
         */
        private $version;
        
        /**
         * The ID of this plugin.
         * @since   0.0.1
         * @access  private
         * @var     String $name        The ID of this plugin.
         */
        private $name;
        
        /**
         * CONSTRUCTOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_Primary_Categories Object and sets its properties
         * @since   0.0.1
         * @var     String  $version    The version of this plugin.
         * @var     String  $name       The ID of this plugin.
         */
        public function __construct( $name, $version ) {
            
            // Set the name and version number
            $this->name     = $name;
            $this->version  = $version;
            
            // Load the plugin and supplementary files
            $this->load();
        
        } // END __construct()
        
        /**
         * Loads translation directory
         * Adds the call to enqueue our JavaScript
         * @since   0.0.1
         */
        protected function load() {
            
            /* Load text domain (translations) */
            load_plugin_textdomain( 'jkl-primary-categories', false, basename( dirname( __FILE__ ) ) . '/languages/' );
            
            /* #1) Enqueue JavaScript where required */
            add_action( 'admin_enqueue_scripts', array( $this, 'jkl_pc_scripts' ) );
            
            /* #2) Add extra options to the 'Publish' metabox */
            add_action( 'post_submitbox_misc_actions', array( $this, 'jkl_add_publish_options' ) );
            add_filter( 'jkl_pc_admin_pointers-post', 'jkl_pc_register_pointer' );
            
            /* #3) Save the Primary Category meta data with the Post Save */
            add_action( 'save_post', array( $this, 'jkl_save_primary_cat' ), 10, 3 );
            
        } // END load()
        
        /**
         * #1) Enqueues our JavaScript, styles, and the WP Pointer
         * @since 0.0.1
         */
        public function jkl_pc_scripts( $hook ) {
            
            global $post;
            //if ( is_post_type_hierarchical( $post->post_type ) ) {
            if( $post->post_type != 'page' && $hook != 'edit.php' ) {
            
                // Enqueue our plugin styles and scripts
                wp_enqueue_style( 'jkl_pc_style', plugins_url( '/css/style.css', __FILE__ ) );
                wp_enqueue_script( 'jkl_pc_functions', plugins_url( '/js/functions.js', __FILE__ ), array( 'jquery' ), '20160921', true );
                
                // Enqueue pointers style, custom script, and pointer options
                wp_enqueue_style( 'wp-pointer' );
                wp_enqueue_script( 'jkl-pc-pointer-script', plugins_url( 'js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
                wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', $valid_pointers );
                
                /**
                 * Create a WordPress Pointer to help users "Set" a Primary Category
                 * @link https://code.tutsplus.com/articles/integrating-with-wordpress-ui-admin-pointers--wp-26853
                 */
                // But don't run on WP < 3.3
                if ( get_bloginfo( 'version' ) < '3.3' ) return;
                
                // Get the screen ID
                $screen = get_current_screen();
                $screen_id = $screen->id;
                
                // Get pointers for this screen
                $pointers = apply_filters( 'jkl_pc_admin_pointers-' . $screen_id, array() );
                
                // No pointers? Then stop.
                if ( ! $pointers || ! is_array( $pointers ) ) return;
                
                // Get dismissed pointers
                $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
                $valid_pointers = array();
                
                // Check pointers and remove dismissed ones
                foreach ( $pointers as $pointer_id => $pointer ) {
                    // Sanity check
                    if ( in_array( $pointer_id, $dismissed ) || empty( $pointer ) || empty( $pointer_id ) || empty( $pointer[ 'target' ] || empty( $pointer[ 'options' ] ) ) )
                        continue;
                    
                    $pointer[ 'pointer_id' ] = $pointer_id;
                    
                    // Add the pointer to $valid_pointers array
                    $valid_pointers[ 'pointers' ][ ] = $pointer; 
                }
                
                // No valid pointers? Then stop.
                if ( empty( $valid_pointers ) ) return;
                
            }
            
        } // END jkl_pc_scripts()
        
        /**
         * #2) Add extra options to the 'Publish' metabox
         * @since   0.0.1
         * @link    https://joebuckle.me/quickie/wordpress-add-options-to-post-admin-publish-meta-box/
         */
        public function jkl_add_publish_options( $post ) {
            
            global $post;
            // Get Primary Category (if set)
            $primary_cat = get_post_meta( $post->ID, 'jkl_primary_category', true );
            
            // Avoid Pages
            if ( $post->post_type != 'page' ) {
                
                echo '<div id="jkl-pc-notice" class="misc-pub-section">';
                echo '<span class="dashicons dashicons-category"></span>';
                echo 'Primary Category: ';
                if ( isset( $primary_cat ) && $primary_cat != null ) {
                    echo '<span id="jkl-primary-cat"><strong>';
                    echo ucwords( $primary_cat );
                    echo '</strong></span>';
                    echo '<a href="#categorydiv">Edit</a>';
                } else {
                    echo '<a id="jkl-set-primary-category" href="#categorydiv">Set</a> <a id="jkl-pc-help" href="#" title="1) Select a category or two, 2) SAVE the Post, 3) Set your Primary Category">Help</a>';
                }
                echo '</div>';
                
            }
        }
        
        public function jkl_pc_register_pointer( $p ) {
            $p[ 'jklpcpointer1' ] = array( 
                'target'    => '#jkl-set-primary-category',
                'options'   => array(
                    'content'   => sprintf( '<h3>%s</h3><p>%s</p>',
                            __( 'Set Primary Category', 'jkl-primary-categories' ),
                            __( 'To set the Primary Category, ...', 'jkl-primary-categories' )
                    ),
                    'position'  => array( 'edge' => 'top', 'align' => 'middle' )
                )
            );
            return $p;
        }
        
        /**
         * 
         * @param type $post_id
         * @param type $post
         * @param type $update
         * @return type
         */
        public function jkl_get_primary_cat_id( $post_id ) {
            
            $primary_category = get_post_meta( $post_id, 'jkl_primary_category', true );
            
        }
        
        /**
         * #3) Save the Primary Category meta data with the Post Save
         * @since   0.0.1
         * @link    https://joebuckle.me/quickie/wordpress-add-options-to-post-admin-publish-meta-box/
         */
        public function jkl_save_primary_cat( $post_id, $post, $update ) {
            
            // Avoid Pages
            if ( $post->post_type == 'page' ) { return; }
            // Don't update on revisions
            if ( wp_is_post_revision( $post_id ) ) { return; }
            
            if ( isset( $_POST[ 'jkl_primary_category' ] ) ) {
                update_post_meta( $post_id, 'jkl_primary_category', $_POST[ 'jkl_primary_category' ] );
            }
            
        }
        
    } // END class JKL_Primary_Categories
    
} // END if ( ! class_exists() )

