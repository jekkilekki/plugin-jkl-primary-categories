<?php

add_action( 'admin_enqueue_scripts', 'myHelpPointers' );
function myHelpPointers()
{
    $pointers = array(
        array(
            'id'       => 'jklpc1',
            'screen'   => '', // post, page, etc
            'target'   => '#jkl-pc-help',
            'title'    => 'Get Quick Information',
            'content'  => 'Easily see what your Primary Category is currently set to. It defaults to the first Category selected for a Post and dynamically updates as you click the "Set Primary" links in the Category meta box.',
            'position' => array(
                'edge'  => 'bottom', // top, bottom, left, right
                'align' => 'top' // top, bottom, left, right, middle
            )
        ),
        array(
            'id'       => 'jklpc2',
            'screen'   => '', // post, page, etc
            'target'   => '#categorychecklist',
            'title'    => 'Change Primary Categories',
            'content'  => 'The first Category you select defaults to the Primary Category. But you can easily change that by clicking the "Set Primary" link beside any other Category you select as well. Once you Save the Post, the Primary Category gets saved along with it in custom meta data and your Primary Category information gets reloaded when the Post refreshes.',
            'position' => array(
                'edge'  => 'bottom', // top, bottom, left, right
                'align' => 'top' // top, bottom, left, right, middle
            )
        ),
        array(
            'id'       => 'jklpc3',
            'screen'   => '', // post, page, etc
            'target'   => '#edit-slug-box',
            'title'    => 'Choose your own Permalinks',
            'content'  => 'By setting a Primary Category for a Post, you also set the breadcrumb for that Post (if permalinks has /%category%/ enabled). Watch the changes to your breadcrumb take place every time you Save the Post.',
            'position' => array(
                'edge'  => 'top', // top, bottom, left, right
                'align' => 'left' // top, bottom, left, right, middle
            )
        ),
    );
    new JKL_PC_Admin_Pointer( $pointers );
}
class JKL_PC_Admin_Pointer
{
    public $screen_id;
    public $valid;
    public $pointers;
    /**
     * Register variables and start up plugin
     */
    public function __construct( $pointers = array( ) )
    {
        if( get_bloginfo( 'version' ) < '3.3' )
            return;
        //$screen = get_current_screen();
        //$this->screen_id = $screen->id;
        $this->register_pointers( $pointers );
        add_action( 'admin_enqueue_scripts', array( $this, 'add_pointers' ), 1000 );
        add_action( 'admin_print_footer_scripts', array( $this, 'add_scripts' ) );
    }
    /**
     * Register the available pointers for the current screen
     */
    public function register_pointers( $pointers )
    {
        $screen_pointers = null;
        foreach( $pointers as $ptr )
        {
            //if( $ptr['screen'] == $this->screen_id )
            //{
                $options = array(
                    'content'  => sprintf(
                        '<h3> %s </h3> <p> %s </p>', 
                        __( $ptr['title'], 'jkl-primary-categories' ), 
                        __( $ptr['content'], 'jkl-primary-categories' )
                    ),
                    'position' => $ptr['position']
                );
                $screen_pointers[$ptr['id']] = array(
                    'screen'  => $ptr['screen'],
                    'target'  => $ptr['target'],
                    'options' => $options
                );
            //}
        }
        $this->pointers = $screen_pointers;
    }
    /**
     * Add pointers to the current screen if they were not dismissed
     */
    public function add_pointers()
    {
        if( !$this->pointers || !is_array( $this->pointers ) )
            return;
        // Get dismissed pointers
        //$get_dismissed = get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true );
        //$dismissed = explode( ',', (string) $get_dismissed );
        $dismissed = array();
        // Check pointers and remove dismissed ones.
        $valid_pointers = array( );
        foreach( $this->pointers as $pointer_id => $pointer )
        {
            if(
                in_array( $pointer_id, $dismissed ) 
                || empty( $pointer ) 
                || empty( $pointer_id ) 
                || empty( $pointer['target'] ) 
                || empty( $pointer['options'] )
            )
                continue;
            $pointer['pointer_id'] = $pointer_id;
            $valid_pointers['pointers'][] = $pointer;
        }
        if( empty( $valid_pointers ) )
            return;
        $this->valid = $valid_pointers;
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
        
        // @TODO - figure out wp_localize_script so we can decouple the JS (below) from the PHP
        // $pointers = json_encode( $this->valid );
        // wp_enqueue_script( 'jkl-pc-pointer-script', plugins_url( '../js/jkl-pc-pointer.js', __FILE__ ), array( 'wp-pointer' ), '20160922', true );
        // wp_localize_script( 'jkl-pc-pointer-script', 'jklPcPointer', array( 'pointers' => $pointers ) );
    }
    /**
     * Print JavaScript if pointers are available
     */
    public function add_scripts()
    {
        if( empty( $this->valid ) )
            return;
        $pointers = json_encode( $this->valid );
        echo <<<HTML
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready( function($) {
		var WPHelpPointer = {$pointers};
                var count = 0;
                
                $( "#jkl-pc-help" ).click( function( e ) {
                    e.preventDefault();
                    if( ! $( '.wp-pointer' ).is( ':visible' ) ) {
                        wp_help_pointer_open( count );
                    }
                } );
                
                $( document ).on( 'click', "#jkl-pc-help-next", function( e ) {
                    e.preventDefault();
                    wp_help_pointer_open(count);
                } );
                
		function wp_help_pointer_open(i) 
		{
                        pointer = WPHelpPointer.pointers[i];
                        prevPointer = WPHelpPointer.pointers[ i-1 ];
                        nextPointer = WPHelpPointer.pointers[ i+1 ];
  
			$( pointer.target ).pointer( 
			{
				content: pointer.options.content,
				position: 
				{
					edge: pointer.options.position.edge,
					align: pointer.options.position.align
				},
				close: function() 
				{
					$.post( ajaxurl, 
					{
						pointer: pointer.pointer_id,
						action: 'dismiss-wp-pointer'
					});
				}
			}).pointer('open');

                        if( prevPointer !== undefined ) {
                            $( prevPointer.target ).pointer( 'close' );
                        }
                        count++;
                
                        if( nextPointer !== undefined ) {
                            $( '.wp-pointer-buttons' ).find( 'a.close' ).remove();
                            $( '.wp-pointer-buttons' ).append('<a class="button-primary" id="jkl-pc-help-next">Next</a>'); // and if so attach a "next" link to the current pointer
                        } else {
                            $( '.wp-pointer-buttons' ).find( 'a.close' ).addClass( 'button-primary' );                
                            count = 0;
                        }
                
		}
	});
//]]>
</script>
HTML;
    }
    
}