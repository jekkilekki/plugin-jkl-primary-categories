<?php
/**
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * @since           0.0.1
 * 
 * The Core plugin class that handles all other plugin parts.
 * 
 * Defines the plugin version number, name, Welcome Page,
 * and (hopefully) Admin Pointer, and enqueues our CSS and JavaScript.
 */
/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Avoid redefining a class with the same name */
/* Also check for Yoast SEO - it will cause conflicts */
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
         * @var     String  $name       The ID of this plugin.
         */
        private $name;
        
        /**
         * JKL_PC_Welcome Object - makes our Welcoming Page
         * @since   0.0.1
         * @access  private
         * @var     JKL_PC_Welcome      $welcome_page   JKL_PC_Welcome Object
         */
        private $welcome_page;
        
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
         * @var     JKL_PC_Admin_Pointer   $admin_pointer  JKL_PC_Admin_Pointer Object
         */
        private $admin_pointer;
        
        /**
         * CONSTRUCTOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_Primary_Categories Object and sets its properties
         * @since   0.0.1
         * 
         * @param     String          $name           The name of this plugin.
         * @param     String          $version        The version of this plugin.
         */
        public function __construct( $name, $version ) {
            
            // Set the name and version number
            $this->name     = $name;
            $this->version  = $version;
            $this->pointers = $this->jkl_pc_add_admin_pointers();
            
            // Load the plugin and supplementary files
            $this->load();
        
        } // END __construct()
        
        /**
         * Function that uses various WordPress hooks to add the features of this plugin
         * 
         * #0) Loads translation directory
         * #1) Adds the call to enqueue our CSS and JavaScript
         * #2) Adds extra options to the 'Publish' metabox
         * #3) Saves the Primary Category meta data with the Post Save action
         * #4) Filters the Frontend Category so the Primary Category shows up in permalinks
         * @since   0.0.1
         */
        protected function load() {
            
            /* STEP #0) Loads text domain (translations) */
            load_plugin_textdomain( 'jkl-primary-categories', false, basename( dirname( __FILE__ ) ) . '/languages/' );
            
            /* #1) Enqueues CSS and JavaScript where required */
            add_action( 'admin_enqueue_scripts', array( $this, 'jkl_pc_scripts' ) );
            /* #2) Adds extra options to the 'Publish' metabox */
            add_action( 'post_submitbox_misc_actions', array( $this, 'jkl_add_publish_options' ) );
            /* #3) Saves the Primary Category meta data with the Post Save action */
            add_action( 'save_post', array( $this, 'jkl_save_primary_cat' ), 10, 3 );
            
            /* #4) Filter the Frontend Category */
            add_filter( 'post_link_category', array( $this, 'jkl_frontend_primary_category' ), 10, 3 );
            add_action( 'admin_init', array( $this, 'jkl_pc_flush_rewrite' ), 10, 3 );
            
            /* #5) Add Admin Pointer array and Create the Admin Pointer */
            add_action( 'admin_enqueue_scripts', array( $this, 'jkl_pc_add_admin_pointers' ) );
            
            // Create the Plugin Welcome Page and Admin Pointers
            $this->welcome_page = new JKL_PC_Welcome();
            $this->admin_pointer = new JKL_PC_Admin_Pointer( $this->pointers );
            
        } // END load()
        
        /**
         * STEP #1) Enqueues our CSS and JavaScript, and (hopefully) the WP Pointer
         * @since   0.0.1
         * 
         * @param   $hook   The Page hook where we want (or don't want) our scripts to run
         */
        public function jkl_pc_scripts( $hook ) {
            
            global $post;
            
            // Enqueue CSS styles first to be sure we get our nice styles on all pages
            wp_enqueue_style( 'jkl_pc_style', plugins_url( '../css/style.css', __FILE__ ) );
            
            // Only enqueue scripts and styles on Post pages (avoid Pages)
            if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) { return; }
            
            // Avoid Pages
            if ( ! isset( $post->post_type ) || $post->post_type != 'page' ) { 
            
                // Enqueue our main plugin scripts
                wp_enqueue_style( 'jkl_pc_style', plugins_url( '../css/style.css', __FILE__ ) );
                wp_enqueue_script( 'jkl_pc_functions', plugins_url( '../js/functions.js', __FILE__ ), array( 'jquery' ), '20160921', true );
                
                // Create an array with text for our Primary Category buttons to pass into our JavaScript (allows for translation)
                $localize = array(
                    'primaryLabel'      => __( 'Primary', 'jkl-primary-categories' ),
                    'setPrimaryLabel'   => __( 'Set Primary', 'jkl-primary-categories' )
                );
                // Localize our functions.js script (enqueued above) and pass in out array of strings to use
                wp_localize_script( 'jkl_pc_functions', 'jklPc', $localize );
                
            }
            //$this->pointers = $this->get_admin_pointers();
            //$this->admin_pointer = new JKL_PC_Admin_Pointer( $this->pointers );
            //wp_enqueue_script( 'jkl_pc_pointer', plugins_url( '../js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
            //wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', $this->admin_pointer->valid );
            
        } // END jkl_pc_scripts()
        
        /**
         * STEP #2) Add extra options to the 'Publish' metabox
         * @since   0.0.1
         * @link    https://joebuckle.me/quickie/wordpress-add-options-to-post-admin-publish-meta-box/
         * 
         * @param   WP_Post     $post   The current Post
         */
        public function jkl_add_publish_options( $post ) {
            
            global $post;
            
            // Get Primary Category (if set)
            $primary_cat = get_post_meta( $post->ID, 'jkl_primary_category', true );
            
            // Get all Categories associated with this Post
            $selected_categories = get_the_category( $post->ID );
            
            // Call a function of this class to get the ID of the Primary Category
            $primary_cat_id = $this->jkl_get_primary_cat_id( $post, $primary_cat, $selected_categories );
            
            // If there is NO Primary Category, but there are some Categories selected,
            // default to the first Category in use for this Post
            if ( $primary_cat == '' && ! empty( get_the_category( $post->ID ) ) ) {
                
                $primary_cat = $selected_categories[0]->name;       // Default Category name
                $primary_cat_id = $selected_categories[0]->term_id; // Default Category ID
                
            } 
            // Avoid Pages and Create our Publish meta box miscellaneous publishing section
            if ( $post->post_type != 'page' ) {
                ?>
                
                <!-- Create our Publish meta box miscellaneous publishing section -->
                <div id="jkl-pc-notice" class="misc-pub-section">
                    <span class="dashicons dashicons-category"></span>
                    <?php esc_html_e( 'Primary Category: ', 'jkl-primary-categories' ); ?>

                    <!-- The span that contains the Primary Category name (an empty String if not set) -->
                    <span id="jkl-primary-cat"><?php esc_html_e( $primary_cat ); ?></span>

                    <!-- Links that provide various functionality for the plugin -->
                    <a id="jkl-edit-primary-category" href="#"><?php esc_html_e( 'Edit', 'jkl-primary-categories' ); ?></a> 
                    <a id="jkl-set-primary-category" href="#"><?php esc_html_e( 'Set', 'jkl-primary-categories' ); ?></a> 
                    <a id="jkl-pc-help" href="#" title="<?php
                        esc_html_e( '1) Select a category or two, 2) SAVE the Post, 3) Set your Primary Category', 'jkl-primary-categories' ); 
                        ?>">
                        <span class="jkl-pc-help-button-text screen-reader-text"><?php esc_html_e( 'Help', 'jkl-primary-categories' ); ?></span>
                        <span class="jkl-pc-help-button"></span>
                    </a>

                    <!-- Hidden input fields that contain and will save the custom Post meta information -->
                    <input id="jkl-primary-cat-hidden" name="jkl_primary_category" type="hidden" value="<?php echo $primary_cat; ?>" />
                    <input id="jkl-primary-cat-id-hidden" name="jkl_primary_category_id" type="hidden" value="<?php echo $primary_cat_id; ?>" />
                </div>
                
                <?php
            }
            
        } // END jkl_add_publish_options()
        
        /**
         * STEP #3) Save the Primary Category meta data with the Post Save
         * @since   0.0.1
         * @link    https://joebuckle.me/quickie/wordpress-add-options-to-post-admin-publish-meta-box/
         */
        public function jkl_save_primary_cat() {
            
            global $post;
            
            // Actually, in this case, we're ONLY saving the Primary Category name and not 
            // its ID (stored in another hidden input field).
            // Our other functions use the name to find the ID later, though 
            // we could store the ID in custom post meta if we wanted to (or use an array for this plugin)
            if ( isset( $_POST[ 'jkl_primary_category' ] ) ) {
                // Get the list of ALL possible Category names
                // This is a safety check, to be sure the data sent to the $_POST array IS 
                // actually relevant data - and not something injected
                $selected_categories = get_the_category();
                
                // Check that our hidden input field value is in that array
                if ( in_array( $_POST[ 'jkl_primary_category' ], $this->jkl_get_the_category_names( $selected_categories ) ) ) {
                    
                    // Sanitize before storing in the database
                    $primary_category = sanitize_text_field( $_POST[ 'jkl_primary_category' ] );
                    // Update the post meta with our hidden input field value if so
                    update_post_meta( $post->ID, 'jkl_primary_category', $primary_category );
                    
                }
            } 
            
        } // END jkl_save_primary_cat()
        
        /**
         * STEP #4) Filter the frontend Category to change to the category chosen by the user
         * @since   0.0.1
         * @link    https://github.com/Yoast/wordpress-seo/blob/6b298c7c8c08411c7d99cf1108d249e9cf43206d/frontend/class-primary-category.php
         * @link    https://developer.wordpress.org/reference/hooks/post_link_category/
         * 
         * @param   stdClass    $category       The Category that is now used for the Post link
         * @param   array       $categories     This parameter is not used
         * @param   WP_Post     $post           The current Post
         * 
         * @return  array|null|object|WP_Error  The Category we want to use for the permalink
         */
        public function jkl_frontend_primary_category( $category, $categories = null, $post = null ) {
            
            $post = get_post( $post );
            $post_categories = array();
            
            // Get the Primary Category
            $primary_cat = get_post_meta( $post->ID, 'jkl_primary_category', true );
            // Get the Primary Category ID
            $primary_cat_id = $this->jkl_get_primary_cat_id($post, $primary_cat, $categories);
            
            // If we have a Primary Category ID and it doesn't match the Category ID of our permalinks,
            if ( null !== $primary_cat_id && $primary_cat_id !== $category->cat_ID ) {
                
                // Then get the Primary Category and set it to what we want for our permalink
                $category = $this->get_category( $primary_cat_id );
                
            } 
            
            // OR if there is no jkl_primary_category post meta set for this post, default to the 
            // first Category selected for this Post (as all our other functions do)
            else if ( $post_categories = get_the_category( $post->ID ) ) {
                
                $category = $this->get_category( $post_categories[0]->term_id );
                
            }
            // Return the Category name to use in our permalink structure (/%category%/)
            return $category;
            
        } // END jkl_frontend_primary_category()
        
        /**
         * Helper Function = Gets the Primary Category ID
         * @link    https://github.com/JacobMC/Primary-Categories/blob/master/classes/class-pc-meta-box.php
         * @since   0.0.1
         * 
         * @param   WP_Post     $post               This Post
         * @param   String      $primary_cat        The name of the Primary Category
         * @param   array       $post_categories    An array of Categories associated with this Post
         * 
         * @return  int     The ID of the Primary Category
         */
        public function jkl_get_primary_cat_id( $post, $primary_cat, $post_categories ) {
            
            // Call this class's function that returns an array of Strings (names) for this Post's Categories
            $selected_categories_names = $this->jkl_get_the_category_names( $post_categories );
            
            // If we have a Primary Category set
            if ( $primary_cat != '' ) {
                // Return the ID of the Primary Category
                return $post_categories[ array_search( $primary_cat, $selected_categories_names, true ) ]->term_id;
            } else {
                // Return an empty string if no Primary Category is set
                return null;
            }
            
        } // END jkl_get_primary_cat_id()
        
        /**
	 * Helper Function = Wrapper for get category to make mocking easier
	 *
	 * @param int $primary_category id of primary category.
	 *
	 * @return array|null|object|WP_Error
	 */
	protected function get_category( $primary_category ) {
            $category = get_category( $primary_category );
            return $category;
	}
        
        /**
         * Helper Function = Returns any array of Category names from the array of Post Category objects
         * @since   0.0.1
         * 
         * @param   Object array    $post_categories    An array of Categories associated with this Post
         * 
         * @return  String array                        An array of Category names from the Categories objects array   
         */
        public function jkl_get_the_category_names( $post_categories ) {
            
            // Create an empty array which will be returned if $post_categories is null (no Categories associated with the Post yet)
            $selected_categories_names = array();
            
            foreach( $post_categories as $term ) {
                // Push the name of each Category onto our array to return
                $selected_categories_names[] = $term->name;
            }
            
            return $selected_categories_names;
            
        } // END jkl_get_the_category_names()
        
        /**
         * STEP #5) Creates the Admin Pointers we will use and stores them in our $pointers class variable
         * @since   1.0.1
         */
        public function jkl_pc_add_admin_pointers() {
            return array(
                'slide' => array(
                    'id'       => 'jklpc1',
                    'screen'   => '', // post, page, etc
                    'target'   => '#jkl-pc-help',
                    'title'    => 'Get Quick Information',
                    'content'  => 'Easily see what your Primary Category is set to.<br><br>It defaults to the first Category selected for a Post and dynamically updates as you click the "Set Primary" links in the Category meta box.',
                    'position' => array(
                        'edge'  => 'bottom', // top, bottom, left, right
                        'align' => 'top' // top, bottom, left, right, middle
                    )
                ),
                'slide2' => array(
                    'id'       => 'jklpc2',
                    'screen'   => '', // post, page, etc
                    'target'   => '#categorychecklist',
                    'title'    => 'Change Primary Categories',
                    'content'  => 'The first Category you select defaults to the Primary Category. But you can easily change that by clicking the "Set Primary" link beside any other Category you select as well.<br><br>Once you <strong>Save</strong> the Post, the Primary Category gets saved along with it in custom meta data and your Primary Category information gets reloaded when the Post refreshes.',
                    'position' => array(
                        'edge'  => 'bottom', // top, bottom, left, right
                        'align' => 'top' // top, bottom, left, right, middle
                    )
                ),
                'slide3' => array(
                    'id'       => 'jklpc3',
                    'screen'   => '', // post, page, etc
                    'target'   => '#edit-slug-box',
                    'title'    => 'Choose your own Permalinks',
                    'content'  => 'By setting a Primary Category for a Post, you also set the breadcrumb for that Post (if permalinks has <code>/%category%/</code> enabled). Watch the changes to your breadcrumb take place every time you <strong>Save</strong> the Post.',
                    'position' => array(
                        'edge'  => 'top', // top, bottom, left, right
                        'align' => 'left' // top, bottom, left, right, middle
                    )
                ),
            );
        } // END jkl_pc_add_admin_pointers()
        
        /**
         * Possible functions to be used later!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        /**
         * Rewrite rules for permalinks
         */
        public function jkl_pc_flush_rewrite() {
            if ( get_option('plugin_settings_have_changed') == true ) {
                flush_rewrite_rules();
                update_option('plugin_settings_have_changed', false);
            }
        }
        
    } // END class JKL_Primary_Categories
    
} // END if ( ! class_exists() )