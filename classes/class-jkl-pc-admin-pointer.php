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
                $( "#jkl-pc-help" ).click( function( e ) {
                    e.preventDefault();
                    wp_help_pointer_open(0);
                } );
                $( document ).on( 'click', "#jkl-pc-help-next", function( e ) {
                    e.preventDefault();
                    wp_help_pointer_open(1);
                } );
		function wp_help_pointer_open(i) 
		{
			pointer = WPHelpPointer.pointers[i];
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
                $('#wp-pointer-' + i + " .wp-pointer-buttons").append('<a id="jkl-pc-help-next" style="float: left">Next</a>'); // and if so attach a "next" link to the current pointer
		}
	});
//]]>
</script>
HTML;
    }
    
}