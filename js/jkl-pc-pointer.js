jQuery(document).ready( function($) {
    
    // Trying to use wp_localize_script() here - figure this out
    var WPHelpPointer = jklPcPointer.pointers;
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