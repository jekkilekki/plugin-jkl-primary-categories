jQuery( document ).ready( function ( $ ) {
    
    function jkl_pc_open_pointer( i ) {
        pointer = jklPcPointer.pointers[ i ];
        options = $.extend( pointer.options, {
            close: function() {
                $.post( ajaxurl, {
                    pointer:    pointer.pointer_id,
                    action:     'dismiss-wp-pointer'
                });
            }
        });
        $( pointer.target ).pointer( options ).pointer( 'open' );
    }
    jkl_pc_open_pointer(0);
    
} );


