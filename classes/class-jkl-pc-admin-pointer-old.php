<?php
/**
 * 
 */

class JKL_PC_Admin_Pointer {
    
    public $screen_id;
    public $valid;
    public $pointers;
    
    /**
     * Register variables and create object
     */
    public function __construct( $pointers = array() ) {
        /**
         * Create a WordPress Pointer to help users "Set" a Primary Category
         * @link https://code.tutsplus.com/articles/integrating-with-wordpress-ui-admin-pointers--wp-26853
         * @link https://gist.github.com/brasofilo/6947539
         */
        // But don't run on WP < 3.3
        if ( get_bloginfo( 'version' ) < '3.3' ) return;

        // Get the screen ID
        //$screen = get_current_screen();
        //$this->screen_id = $screen->id;
        
        $this->register_pointers( $pointers );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'add_pointers' ), 1000 );
        // add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
        
    }
    
    /**
     * Register the available pointers for the current screen
     */
    public function register_pointers( $pointers ) {
        
        $screen_pointers = null;
        foreach( $pointers as $pointer ) {
            
            if( $pointer[ 'screen' ] == $this->screen_id ) {
                
                $options = array(
                    'content'   => sprintf(
                            '<h3>%s</h3><p>%s</p>',
                            __( $pointer[ 'title' ], 'jkl-primary-categories' ),
                            __( $pointer[ 'content' ], 'jkl-primary-categories' )
                    ),
                    'position'  => $pointer[ 'position' ]
                );
                $screen_pointers[ $pointer[ 'id' ] ] = array( 
                    'screen'    => $pointer[ 'screen' ],
                    'target'    => $pointer[ 'target' ],
                    'options'   => $options
                );
            }
        }
        $this->pointers = $screen_pointers;
        
    }
    
    /**
     * Add pointers to the current screen if they were not dismissed
     */
    public function add_pointers() {
        
        $pointers = $this->pointers;
        
        // No pointers? Then stop.
        if ( ! $pointers || ! is_array( $pointers ) ) return;

        // Get dismissed pointers
        $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
        
        // Check pointers and remove dismissed ones
        $valid_pointers = array();
        foreach ( $pointers as $pointer_id => $pointer ) {
            // Sanity check
            if ( in_array( $pointer_id, $dismissed ) 
                    || empty( $pointer ) 
                    || empty( $pointer_id ) 
                    || empty( $pointer[ 'target' ] ) 
                    || empty( $pointer[ 'options' ] ) 
                )
                continue;

            $pointer[ 'pointer_id' ] = $pointer_id;

            // Add the pointer to $valid_pointers array
            $valid_pointers[ 'pointers' ][ ] = $pointer; 
        }

        // No valid pointers? Then stop.
        if ( empty( $valid_pointers ) ) return;
        
        $this->valid = $valid_pointers;

        // Enqueue pointers style and script
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
        
    }
    
    /**
     * Enqueue JavaScript if pointers are available
     */
    public function add_scripts() {
        
        // Don't enqueue JS if no pointers
        if ( empty ( $this->valid ) ) return;
        
        wp_enqueue_script( 'jkl-pc-pointer-script', plugins_url( '../js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
        wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', $this->valid );
                
    }
    
} // END class JKL_PC_Admin_Pointer