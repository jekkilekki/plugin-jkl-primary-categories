/**
 * @package     JKL_Primary_Categories
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * @since       0.0.1
 * 
 * Main jQuery function that controls all the functionality of the plugin.
 * 
 * 1) Defines functions created to deal with Primary Category button interactivity
 * 2) Adds "click" and "change" 
 * 
 * @param       jQuery  $
 * @link        https://github.com/Yoast/wordpress-seo/blob/trunk/js/dist/wp-seo-metabox-category-350.js
 *              Helpful to understand the necessary functionality for handling the Primary Category JS in the Categories meta box
 */

( function ( $ ) {
   "use strict";
   
   // Grab our array of string data from PHP
   var text = jklPc;
   
   /**
    * ==========================================================================
    * PRIMARY CATEGORY FUNCTIONS
    * ==========================================================================
    */
   
   /**
    * Highlights the Primary Category whenever some action happens regarding it
    * 
    * @since    0.0.1
    * 
    * @param    Object  term     The Primary Category <li> element
    */
   function highlightPrimary( term ) {
       
        $( term )
                .animate( { backgroundColor: "#ffffaa" }, 1 )
                .animate( { backgroundColor: "#ffffff" }, 2000 );
        
   } // END highlightPrimary()
   
   /**
    * Gets the Primary Category name from our Publish Metabox (which is set using the get_post_meta() function in PHP)
    * 
    * @since    0.0.1
    * 
    * @return   String      The current Primary Category name
    */
   function getPrimaryCategory() {
       
       return $( "#jkl-primary-cat" ).html();
       
   } // END getPrimaryCategory()
   
   /**
    * Function to be sure we always have a Primary Category labeled in the Publish Meta box if there is at least one Category checked
    * 
    * @since    0.0.1
    * 
    * @param    Object  term     The Primary Category <li> element
    */
   function ensurePrimaryCategory( term ) {
       
       // Get all selected Categories
       var checkedTerms = $( "#categorychecklist input[type='checkbox']:checked" );
       
        // If there is not Primary Category set now
        if( $( "#jkl-primary-cat" ).html() == "" ) {
            term = $( term );   // make a jQuery object
            // Change Primary Category name in Publish meta box
             $( "#jkl-primary-cat" ).html( getCategoryName( term, true ) );
        } 
        // OR if there are currently no selected Categories
        else if ( checkedTerms.length < 1 ) {
            // Then set the Publish meta box Primary Category value to an empty String
            $( "#jkl-primary-cat" ).html( "" );
        }
        
   } // END ensurePrimaryCategory()
   
   /**
    * Gets the Category name from an <input> element
    * 
    * @since    0.0.1
    * 
    * @param    Object  term            The current Primary Category
    * @param    bool    newPrimaryCat   True if we are setting a , false otherwise 
    * 
    * @return   String                  The name of the Primary Category
    */
   function getCategoryName( term, newPrimaryCat ) {
       
       // Get the HTML from the <label> closest to the term we are using
       var findPrimaryCat = term.closest( 'label' ).html();
       // Split the HTML into different elements so we can isolate the name of the Category from the rest of the HTML
       var htmlArr = findPrimaryCat.split( ' ' );
       
       // If our boolean is set to TRUE that this is a NEW Primary Category
       if( newPrimaryCat ) {
           // Find the opening < on the HTML tag, ...
           var end = htmlArr[ htmlArr.length - 4 ].indexOf( '<' );
           // ... and get the NAME of the Category up to that point
           var newCatName = htmlArr[ htmlArr.length - 4 ].substr(0, end);
           // Return the new Category name
           return newCatName;
       } 
       // Else, this is NOT a new Primary Category, but rather the first on a Post load
       else {
            // Return the last String in the HTML array (which is the Category name)
            return htmlArr[ htmlArr.length - 1 ];
        }
        
   } // END getCategoryName()
   
   /**
    * Make FIRST checked Category Primary
    * 
    * Makes the first Category the Primary Category (by default, or if unchecking the Primary Category)
    * 
    * @since    0.0.1
    */
   function setPrimaryCategoryFirst() {
       
       // Find the very first checkbox that is selected
       var firstCategory = $( "#categorychecklist input[type='checkbox']:checked:first" );
       
       // Remove the Primary Category class from the nearest <li> (just in case)
       firstCategory.closest( 'li' ).removeClass( 'jkl-primary-category' );
       
       // Remove any interface elements from the first selected checkbox
       firstCategory.next().remove();
       
       // Call the function to set THIS as the Primary Category
       setPrimaryCategory( firstCategory );

   } // END setPrimaryCategoryFirst()
   
   /**
    * Sets a new Primary Category
    * 
    * @since    0.0.1
    * 
    * @param    Object  term    The current Primary Category
    */
   function setPrimaryCategory( term ) {
       //$( "#jkl-primary-category" ).val( termId ).trigger( "change" );
        term = $( term );   // make a jQuery Object
        
        // Give the nearest <li> a class of 'jkl-primary-category'
        var listItem = term.closest( "li" );
        listItem.addClass( "jkl-primary-category" );
        
        // Add a disabled button (like a label) called "Primary" to the nearest <label>
        var label = term.closest( "label" );
        label.append( "<button class='jkl-category-label jkl-primary-category-button' disabled>" + text.primaryLabel + "</button>" );
        
        /* Change Primary Category name in Publish metabox */
        $( "#jkl-primary-cat" ).html( getCategoryName( term, true ) );
        $( "#jkl-primary-cat-hidden" ).val( getCategoryName( term, true ) );
        
   } // END setPrimaryCategory()
   
   /**
    * Primary Category updater
    * 
    * The MAIN function that handles all the updating of Primary Categories
    * Sees which Categories are checked and adds a 'jkl-category-checked/unchecked' class to each
    * 
    * @since    0.0.1
    */
   function updateCategories() {
       
       var checkedTerms = $( "#categorychecklist input[type='checkbox']:checked" );
       var uncheckedTerms = $( "#categorychecklist input[type='checkbox']:not(:checked)" );
       
       // Remove all classes for a consistent experience
       checkedTerms.add( uncheckedTerms ).closest( "li" )
               .removeClass( "jkl-category" )
               .removeClass( "jkl-category-checked" )
               .removeClass( "jkl-category-unchecked" );
       uncheckedTerms.closest( "li" ).removeClass( "jkl-primary-category" );
       
       // Remove all elements (buttons) with a jkl-category-label class (i.e. "Primary" and "Set Primary")
       $( ".jkl-category-label" ).remove();
       
       // Don't show the "Edit" option nor the Primary Category <span> in the 
       // Publish meta box if only one Category is selected
       if ( checkedTerms.length < 1 ) {
           $( "#jkl-primary-cat, #jkl-edit-primary-category" ).css( { "display" : "none" } );
           $( "#jkl-set-primary-category, .jkl-pc-help-button-text" ).css( { "display" : "inline" } );
           $( ".jkl-pc-help-button-text" ).removeClass( 'screen-reader-text' );
           return;
       } else {
           // Show "Edit" option and Primary Category <span> if there is 1 or more Categories selected
           $( "#jkl-primary-cat, #jkl-edit-primary-category" ).css( { "display" : "inline" } );
           $( "#jkl-set-primary-category, .jkl-pc-help-button-text" ).css( { "display" : "none" } );
           $( ".jkl-pc-help-button-text" ).addClass( 'screen-reader-text' );
       }
       
       // Variable to count the number of Primary Categories (could probably be a bool also)
       var hasPrimaryCat = 0;
       
       // Create the interface items if they don't yet exist
       checkedTerms.each( function( i, term ) {
            term = $( term );
            var listItem = term.closest( "li" );
            
            if ( listItem.hasClass( 'jkl-primary-category' ) ) {
                // Increase count of Primary Categories by 1 (
                hasPrimaryCat++;
            }
            
            // If the selected Category name matches the Primary Category name in the Publish meta box
            if ( getCategoryName( term, false ) === getPrimaryCategory() ) { 
                
                // Then set this Category as the Primary Category
                setPrimaryCategory( term );
                
                // If this is the first page load, then move the Primary Category to the top of the list
                if( pageLoad ) {
                    listItem.prependTo( "#categorychecklist" );
                }
                
            } else {
                
                // If the selected Category doesn't match the Primary Category in the Publish meta box
                // Then just add a "checked" class and remove the "primary" class
                listItem.addClass( "jkl-category-checked" );
                listItem.removeClass( "jkl-primary-category" );
                
                // Then, add a "Set Primary" button to the <label> for this Category
                var label = term.closest( "label" );
                // Also, embed an <a> tag so the button text gets the same link color as the rest of the admin 
                // (then we don't need a separate PHP function to pull admin colors and set the link color just for this element)
                label.append( "<button class='jkl-category-label jkl-make-primary-cat'><a>" + text.setPrimaryLabel + "</a></button>" );
                
            }
            
       } );
       
       // For all the unchecked Categories, add an "unchecked" class
       uncheckedTerms.closest( "li" ).addClass( "jkl-category-unchecked" );
       
       // If there is NO Primary Category set, and this is NOT the first Page Load,
       // Then, set the First selected checkbox to the Primary Category
       if( hasPrimaryCat < 1 && ! pageLoad  ) {
          setPrimaryCategoryFirst();
       }
       
   } // END updateCategories()
   
   
   /**
    * ==========================================================================
    * EVENT LISTENERS
    * ==========================================================================
    */
   
   /**
    * Checkbox handler
    * 
    * Checkbox handler for when a checkbox is clicked
    * Bind this function call to the document so that even when we create or destroy
    * our interface elements, each button will still work appropriately
    * 
    * @since    0.0.1
    */
    $( document ).on( "change", "#categorychecklist input:checkbox", function( e ) {
        // Call the function to be sure there is always a Primary Category if a Category is selected
        ensurePrimaryCategory( e.target );
        // And update the interface elements
        updateCategories();
    } );
    
    /**
     * Highlight on "Set"
     * 
     * Highlight the first Category <li> if the user clicks to "Set"
     * Also scroll the page down to focus on the Category meta box
     * 
     * @since   0.0.1
     */
    $( "#jkl-set-primary-category" ).click( function() {
        highlightPrimary( "#categorychecklist li:first-child" );
        $('html, body')
                .animate( {
                     scrollTop: $( "#categorydiv" ).offset().top
                }, 400);
    } );
    
    /**
     * Highlight on "Edit"
     * 
     * Highlight the current Primary Category <li> if the user clicks to "Edit" Category
     * Also scroll the page down to focus on the Category meta box
     * 
     * @since   0.0.1
     */
    $( "#jkl-edit-primary-category" ).click( function() {
        highlightPrimary( ".jkl-primary-category" );
        $('html, body')
                .animate( {
                     scrollTop: $( "#categorydiv" ).offset().top
                }, 400);
    } );
    
    /**
     * "Set Primary" button handler
     * 
     * Change "Primary" label when one of the "Set Primary" buttons is clicked
     * Bind this function call to the document so that even when we create or destroy
     * our interface elements, each button will still work appropriately
     * 
     * @since   0.0.1
     */
    $( document ).on( "click", ".jkl-category-label", function( e ) {
        
        e.preventDefault();
        
        /* Get all interface elements in CategoryDiv */
        var jklCategories = $( ".jkl-category-label" );
        
        // Remove any mention of "Primary" from the interface elements or their classes
        // Also, change EVERY interface element to a "Make Primary" button
        jklCategories
                .removeClass( 'jkl-primary-category-button' )
                .addClass( 'jkl-make-primary-cat' )
                .html( text.setPrimaryLabel )
                .prop( 'disabled', false );
        jklCategories.closest( 'li' )
                .removeClass( 'jkl-primary-category' )
                .addClass( 'jkl-category-checked' );
        
        // Set THIS interface element aside specifically for the "Primary" button
        // and add appropriate classes to its elements
        $( this )
                .removeClass( "jkl-make-primary-cat" )
                .addClass( "jkl-primary-category-button" )
                .html( text.primaryLabel )
                .prop( 'disabled', true );
        $( this ).closest( 'li' )
                .removeClass( 'jkl-category-checked' )
                .addClass( 'jkl-primary-category' );
        highlightPrimary( $( this ).closest( 'li' ) );
        
        /* Change Primary Category name in Publish meta box */
        $( "#jkl-primary-cat" ).html( getCategoryName( $(this), true ) );
        /* Also change the Primary Category ID in the second hidden Publish meta box */
        $( "#jkl-primary-cat-hidden" ).val( getCategoryName( $(this), true ) );
        
        /* Also, don't forget to update categories after that */
        updateCategories(); 
        
    } );
    
    
   /**
    * ==========================================================================
    * RUN PROGRAM
    * ==========================================================================
    */
   
    // On the first run of the program, set the pageLoad bool to true
    var pageLoad = true;
    // Add our interface elements
    updateCategories();
    // Set pageLoad to false so that all other interaction with the buttons will 
    // allow us to call the setPrimaryCategoryFirst() function
    pageLoad = false;
    
   
} ( jQuery ) );