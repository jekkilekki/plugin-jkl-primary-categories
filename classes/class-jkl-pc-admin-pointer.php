<?php
/**
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * @since           0.0.1
 * 
 * The Admin Pointers class for the plugin.
 * 
 * Creates and displays a nice tour for using the plugin on the Post editing page.
 * 
 * @link            https://gist.github.com/brasofilo/6947539
 */
/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
/* Avoid redefining a class with the same name */
if ( ! class_exists( 'JKL_PC_Admin_Pointer' ) ) {

    class JKL_PC_Admin_Pointer {
        
        /**
         * Array of Admin Pointers for the plugin.
         * @since   0.0.1
         * @access  private
         * @var     array  $pointers    Array of Admin Pointers for the plugin.
         */
        private $pointers;
        
        /**
         * Array of (valid) Admin Pointers - i.e. if we cared about dismissed pointers, they wouldn't be in this array
         * @since   0.0.1
         * @access  private
         * @var     array  $valid       Array of (valid) Admin Pointers.
         */
        public $valid;
        
        /**
         * CONSTRUCTOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_PC_Admin_Pointer Object and sets its properties
         * @since   0.0.1
         */
        public function __construct( $pointers = array( ) ) {
            
            // Bail if less than WordPress 3.3 (Admin Pointers introduced in 3.3)
            if( get_bloginfo( 'version' ) < '3.3' )
                return;

            // Set this class's Admin pointers to the array we pass into the constructor
            $this->pointers = $pointers;
            // Register our pointers 
            $this->register_pointers( $this->pointers );
            // Run our scripts to get the pointers to function
            $this->run();
            
        } // END __construct()
        
        /**
         * Call WordPress action and filter hooks to run the plugin
         * @since   1.0.1
         */
        public function run() {
            
            // Add "valid" pointers - we'll make all of them valid all the time for now - since it's a tour feature
            add_action( 'admin_enqueue_scripts', array( $this, 'add_pointers' ), 1000 );
            // Add the pointer scripts
            // add_action( 'admin_print_footer_scripts', array( $this, 'add_pointer_scripts' ) );
            
        } // END run()
        
        /**
         * Register the available pointers for the current screen
         * @since   0.0.1
         * 
         * @param   array   $pointers   The array of Admin Pointers for THIS object
         */
        public function register_pointers( $pointers ) {
            
            $screen_pointers = null;
            foreach( $pointers as $ptr ) {
                
                // Set the content options for each pointer
                $options = array(
                    'content'  => sprintf(
                        '<h3>%s</h3><p>%s</p>', 
                        __( $ptr[ 'title' ], 'jkl-primary-categories' ), 
                        __( $ptr[ 'content' ], 'jkl-primary-categories' )
                    ),
                    'position' => $ptr[ 'position' ]
                );
                $screen_pointers[ $ptr[ 'id' ] ] = array(
                    // 'screen'  => $ptr['screen'], // If we wanted to use different screens
                    'target'  => $ptr[ 'target' ],
                    'options' => $options
                );
                
            }
            
            // If we were using different pointer for different screens, this would set this screen's
            // pointer to the $pointers array for this current object
            $this->pointers = $screen_pointers;
            
        } // END register_pointers()
        
        /**
         * Add pointers to the current screen if they were not dismissed
         * Since this is a Tour feature, we won't keep track of dismissed pointers and not load them,
         * rather, we'll just load the pointer Tour every time the "Help" button is clicked
         * @since   0.0.1
         */
        public function add_pointers() {
            
            // Bail if there are no pointers, or it's not an array
            if( ! $this->pointers || ! is_array( $this->pointers ) )
                return;
            // Get dismissed pointers (Unnecessary
            // $get_dismissed = get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true );
            // $dismissed = explode( ',', (string) $get_dismissed );
            
            $dismissed = array();
            // Check pointers and remove dismissed ones.
            $valid_pointers = array();
            
            foreach ( $this->pointers as $pointer_id => $pointer ) {
                // Skip every dismissed pointer, empty pointer, or pointer without an id, target, or options (content)
                if (
                    in_array( $pointer_id, $dismissed ) 
                    || empty( $pointer ) 
                    || empty( $pointer_id ) 
                    || empty( $pointer['target'] ) 
                    || empty( $pointer['options'] )
                )
                    continue;
                
                // Add all the valid pointers to a valid pointers array
                $pointer['pointer_id'] = $pointer_id;
                $valid_pointers['pointers'][] = $pointer;
                
            }
            
            // Bail if there are no valid pointers
            if( empty( $valid_pointers ) )
                return;
            
            // Store our $valid_pointers array in our class variable for this object
            $this->valid = $valid_pointers;
            
            // Enqueue the WordPress Admin Pointer CSS and JavaScript
            // We do this HERE rather than in run() just in case we have no valid pointers,
            // then we won't enqueue unnecessary scripts and styles
            wp_enqueue_style( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
            
            // Add our custom Admin Pointers script and localize our Pointer data to use in the script
            wp_enqueue_script( 'jkl-pc-pointer-script', plugins_url( '../js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
            wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', json_encode( $this->pointers ) );
            
        } // END add_pointers()

    } // END class JKL_PC_Welcome
    
} // END if ( ! class_exists() )