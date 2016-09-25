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
/* Also avoid creating this class if Yoast SEO is activated - it will cause conflicts */
if ( ! class_exists( 'JKL_Primary_Categories' ) && ! class_exists( 'WPSEO_Primary_Term' ) ) {
    
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
         * JKL_PC_Welcome Object - makes our Welcoming Page
         * @since   0.0.1
         * @access  private
         * @var     Object   $welcome_screen  JKL_PC_Welcome Object
         */
        private $welcome_screen;
        
        /**
         * Array of WordPress admin pointers.
         * @since   0.0.1
         * @access  private
         * @var     array   $pointers   Array of WordPress admin pointers.
         */
        private $pointers;
        
        /**
         * JKL_PC_Admin_Pointer Object - a WordPress admin pointer object
         * @since   0.0.1
         * @access  private
         * @var     Object   $admin_pointer  JKL_PC_Admin_Pointer Object
         */
        private $admin_pointer;
        
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
            
            //$this->primary_category = new JKL_PC_Term();
            $this->welcome_screen = new JKL_PC_Welcome();
            
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

            /* #3) Save the Primary Category meta data with the Post Save */
            add_action( 'save_post', array( $this, 'jkl_save_primary_cat' ), 10, 3 );
            
            /* #4) Filter the Frontend Category */
            add_filter( 'post_link_category', array( $this, 'jkl_frontend_primary_category' ), 10, 3 );
            
        } // END load()
        
        /**
         * #1) Enqueues our JavaScript, styles, and the WP Pointer
         * @since 0.0.1
         */
        public function jkl_pc_scripts( $hook ) {
            
            global $post;
            //if ( is_post_type_hierarchical( $post->post_type ) ) {
            wp_enqueue_style( 'jkl_pc_style', plugins_url( '../css/style.css', __FILE__ ) );
            
            // Only enqueue scripts and styles on Post pages
            if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) { return; }
            
            // Avoid Pages
            if( $post->post_type != 'page' ) {
            
                // Enqueue our plugin styles and scripts
                
                wp_enqueue_script( 'jkl_pc_functions', plugins_url( '../js/functions.js', __FILE__ ), array( 'jquery' ), '20160921', true );
            
                $this->pointers = $this->get_admin_pointers();
                $this->admin_pointer = new JKL_PC_Admin_Pointer( $this->pointers );
                
                //wp_enqueue_script( 'jkl_pc_pointer', plugins_url( '../js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
                //wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', $this->admin_pointer->valid );
                
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
            $selected_categories = get_the_category( $post->ID );
            
//            echo '<pre>';
//            var_dump( $selected_categories_names );
//            echo '</pre>';
            
            $primary_cat_id = $this->jkl_get_primary_cat_id( $post, $primary_cat, $selected_categories );
            
            // Or, default to the first Category in use if not set
            if ( $primary_cat == '' && ! empty( get_the_category( $post->ID ) ) ) {
                
                $primary_cat = $selected_categories[0]->name;
                $primary_cat_id = $selected_categories[0]->term_id;
            } 
            
            
            
            // Avoid Pages
            if ( $post->post_type != 'page' ) {
                
                echo '<div id="jkl-pc-notice" class="misc-pub-section">';
                echo '<span class="dashicons dashicons-category"></span>';
                echo 'Primary Category: ';
                // if ( ! isset( $primary_cat ) || $primary_cat == null ) {
                echo '<span id="jkl-primary-cat">';
                echo $primary_cat;
                echo '</span>';
                echo '<a id="jkl-edit-primary-category" href="#">Edit</a> ';
                //} else {
                echo '<a id="jkl-set-primary-category" href="#">Set</a> <a id="jkl-pc-help" href="#" title="1) Select a category or two, 2) SAVE the Post, 3) Set your Primary Category">Help</a>';
                //}
                echo '<input id="jkl-primary-cat-hidden" name="jkl_primary_category" type="hidden" value="' . $primary_cat . '" />';
                echo '<input id="jkl-primary-cat-id-hidden" name="jkl_primary_category_id" type="hidden" value="' . $primary_cat_id . '" />';
                echo '</div>';
                
            }
        }
        
        public function get_admin_pointers() {
            return array( 
                array(
                    'id'        => 'jklpcpointer1',
                    'screen'    => 'post',
                    'target'    => '#jkl-set-primary-category',
                    'title'     => __( 'Set Primary Category', 'jkl-primary-categories' ),
                    'content'   => __( 'To set the Primary Category, ...', 'jkl-primary-categories' ),
                    'position'  => array(
                        'edge'  => 'top',   // top, bottom, left, right
                        'align' => 'middle' // top, bottom, left, right, middle
                    )
                ),
            );
        }
        
        /**
         * Gets the Primary Category
         * @since   0.0.1
         * @var     int     $post_id
         * @link    https://github.com/JacobMC/Primary-Categories/blob/master/classes/class-pc-meta-box.php
         */
        public function jkl_get_primary_cat_id( $post, $primary_cat, $post_categories ) {
            
            $selected_categories_names = $this->jkl_get_the_category_names( $post_categories );
            
            // Return the ID of the Primary Category
            return $post_categories[ array_search( $primary_cat, $selected_categories_names, true ) ]->term_id;
            
        }
        
        /**
         * 
         */
        public function jkl_get_the_category_names( $post_categories ) {
            $selected_categories_names = array();
            
            foreach( $post_categories as $term ) {
                $selected_categories_names[] = $term->name;
            }
            
            return $selected_categories_names;
        }
        
        /**
         * #3) Save the Primary Category meta data with the Post Save
         * @since   0.0.1
         * @link    https://joebuckle.me/quickie/wordpress-add-options-to-post-admin-publish-meta-box/
         */
        public function jkl_save_primary_cat() {
            
            global $post;
            
            // Avoid Pages
            if ( $post->post_type == 'page' ) { return; }
            // Don't update on revisions
            if ( wp_is_post_revision( $post->ID ) ) { return; }
            
            if ( isset( $_POST[ 'jkl_primary_category' ] ) ) {
                // Get the list of ALL possible Category names
                $selected_categories = get_the_category();
                
                // Check that our hidden input field value is in that array
                if ( in_array( $_POST[ 'jkl_primary_category' ], $this->jkl_get_the_category_names( $selected_categories ) ) ) {
                    // Update the post meta with our hidden input field value if so
                    update_post_meta( $post->ID, 'jkl_primary_category', $_POST[ 'jkl_primary_category' ] );
                }
                
            } 
            
        }
        
        /**
         * #4) Filter the frontend Category to change to the category chosen by the user
         * @since   0.0.1
         * @link    https://github.com/Yoast/wordpress-seo/blob/6b298c7c8c08411c7d99cf1108d249e9cf43206d/frontend/class-primary-category.php
         * @link    https://developer.wordpress.org/reference/hooks/post_link_category/
         */
        public function jkl_frontend_primary_category( $category, $categories = null, $post = null ) {
            $post = get_post( $post );
            $primary_cat = get_post_meta( $post->ID, 'jkl_primary_category', true );
            $primary_cat_id = $this->jkl_get_primary_cat_id($post, $primary_cat, $categories);
            
            if ( false !== $primary_cat_id && $primary_cat_id !== $category->cat_ID ) {
                $category = $primary_cat_id;
            }
            
            return $category;
            
        }
        
    } // END class JKL_Primary_Categories
    
} // END if ( ! class_exists() )

