/**
 * @package     JKL_Primary_Categories
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * @since       1.0.2
 * 
 * jQuery function that controls our Admin Pointer for the plugin tour.
 * 
 * 1) Gets data from PHP and parses it into a JSON Object
 * 2) Creates an array of Pointer Objects from the parsed JSON Object
 * 3) Manages the functionality of clicking through the Admin Pointer tour 
 * 
 * @see         https://codex.wordpress.org/Function_Reference/wp_localize_script
 * @see         https://developer.wordpress.org/reference/functions/wp_localize_script/
 * 
 * @param       jQuery  $
 * 
 * @link        http://www.ronakg.com/2011/05/passing-php-array-to-javascript-using-wp_localize_script/ 
 *              Helpful for me to understand: 1) encode to JSON string in PHP, 2) parse to JSON Object in JS
 * @link        http://stackoverflow.com/questions/11922383/access-process-nested-objects-arrays-or-json
 *              Good reading on JavaScript Objects and Arrays, and their relation to JSON 
 */

jQuery( document ).ready( function( $ ) {
    
    // Get our pointers from PHP as a string and parse it to a JSON Object
    var WPHelpPointerObject = jQuery.parseJSON( jklPcPointer );
    
    // Create an array of Pointers with our objects by using their id keys
    var WPHelpPointer = [
        WPHelpPointerObject.jklpc1,
        WPHelpPointerObject.jklpc2,
        WPHelpPointerObject.jklpc3
    ];
    
    // Counts the number (id) of the current pointer (for our tour)
    var count = 0;

    /**
     * Event Listener for "Help"
     * 
     * Starts the plugin tour whenever the user clicks our "Help" button or icon
     * 
     * @since   1.0.2
     */
    $( "#jkl-pc-help" ).click( function( e ) {
        e.preventDefault();
        // Don't run if there are already visible pointers
        if( ! $( '.wp-pointer' ).is( ':visible' ) ) {
            // Open the next (based on count) pointer
            wp_help_pointer_open( count );
        }
    } );

    /**
     * Event Listener for "Next" buttons
     * 
     * Opens the Next Pointer whenever a user clicks the "Next" button on a pointer
     * Bound to the Document since our "Next" buttons are added dynamically by this script
     * 
     * @since   1.0.2
     */
    $( document ).on( 'click', "#jkl-pc-help-next", function( e ) {
        e.preventDefault();
        // Open the next pointer
        wp_help_pointer_open(count);
    } );

    /**
     * Opens current Admin Pointer
     * 
     * 1) Opens the current Admin Pointer
     * 2) Closes the previous Admin Pointer (if applicable)
     * 3) Adds a "Next" button in place of the "Dismiss" button if there is a following Admin Pointer
     * 4) Resets slide id number (count) to 0 at the end of the tour
     * 
     * @since   1.0.2
     * 
     * @param   int i   count   The id number of our current slide
     */
    function wp_help_pointer_open(i) {

            // Set variables for ease of use later
            pointer = WPHelpPointer[ i ];
            prevPointer = WPHelpPointer[ i-1 ];
            nextPointer = WPHelpPointer[ i+1 ];

            // Set the current pointer's options
            $( pointer.target ).pointer( {
                
                    content: pointer.options.content,
                    position: {
                        
                            edge: pointer.options.position.edge,
                            align: pointer.options.position.align
                            
                    },
                    close: function() {
                        
                            $.post( ajaxurl, {
                                
                                    pointer: pointer.pointer_id,
                                    action: 'dismiss-wp-pointer'
                                    
                            });
                            
                    }
                    
            }).pointer('open'); // and open it
            
            // If there is a previous pointer, then close it
            if( prevPointer !== undefined ) {
                $( prevPointer.target ).pointer( 'close' );
            }
            // And increase our count variable to keep track of our pointer position
            count++;

            // If there is a next pointer
            if( nextPointer !== undefined ) {
                // Remove the "Dismiss" button and add a "Next" button in its place
                $( '.wp-pointer-buttons' ).find( 'a.close' ).remove();
                $( '.wp-pointer-buttons' ).append('<a class="button-primary" id="jkl-pc-help-next">' + localize.nextButton + '</a>'); // and if so attach a "next" link to the current pointer
            } else {
                // Or, if it's the last pointer, change the "Dismiss" link's style to look like a button
                $( '.wp-pointer-buttons' ).find( 'a.close' ).addClass( 'button-primary' );  
                // And reset count to 0 so we can start the tour over again if necessary
                count = 0;
            }

    } // END wp_help_pointer_open(i)
    
}); // END jQuery function