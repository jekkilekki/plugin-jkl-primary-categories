/**
 * Main jQuery function that controls all the adding of <span> tags, classes, 
 * and resizing/responsiveness for the pricing tables
 * 
 * @since   0.0.1
 * @param   jQuery  $
 * @link    https://github.com/Yoast/wordpress-seo/blob/trunk/js/dist/wp-seo-metabox-category-350.js
 */

/**
 * Function that takes care of adding additional span classes to each individual box
 * 1. Removes * and adds "Recommended" to the default boxes
 * 2. Surrounds any dollar signs ($) in the price field with <span> tags for better styling
 * 3. Surrounds any "per" units (/month) in the price field with <span> tags for better styling
 */

//jQuery( document ).ready( function( $ ) {
//    alert( "Hello world!" );
//});

( function ( $ ) {
   "use strict";
   
   /**
    * Check if there are any Categories selected yet
    */
   function hasPrimaryCatElements( checkbox ) {
       return 1 === $( checkbox ).closest( "li" ).children( ".jkl-category" ).length;
   }
   
   /**
    * Creates the elements necessary to show something is a Primary Category, or to make it one
    */
   function addPrimaryCatElements( checkbox ) {
       var label, html;
       
       label = $( checkbox ).closest( "label" );
       
       html = 'In functions.js';
       
       label.after( html );
   }
   
   /**
    * Gets the Primary Category name
    */
   function getPrimaryCategory() {
       return $( "#jkl-primary-category" ).val();
   }
   
   /**
    * Sets the Primary Category
    */
   function setPrimaryCategory( termId ) {
       $( "#jkl-primary-category" ).val( termId ).trigger( "change" );
   }
   
   /**
    * Sees which Categories are checked and adds a 'jkl-category-checked/unchecked' class to each
    */
   function getCategories( ) {
       
       var checkedTerms = $( "#categorychecklist input[type='checkbox']:checked" );
       var uncheckedTerms = $( "#categorychecklist input[type='checkbox']:not(:checked)" );
       
       // Remove all classes for a consistent experience
       checkedTerms.add( uncheckedTerms ).closest( "li" )
               .removeClass( "jkl-category" )
               .removeClass( "jkl-category-checked" )
               .removeClass( "jkl-category-unchecked" );
       
       // Don't show the "Primary Category" options if only one Category is selected
       if ( checkedTerms.length <= 1 ) {
           return;
       }
       
       // Create the interface items if they don't yet exist
       checkedTerms.each( function( i, term ) {
            term = $( term );
            var listItem = term.closest( "li" );
            
            // Create the interface items if they don't yet exist
            if ( ! hasPrimaryCatElements( term ) ) {
                addPrimaryCatElements( term );
            }
            
            if ( term.val() === getPrimaryCategory() ) {
                listItem.addClass( "jkl-primary-category" );
                
                var label = term.closest( "label" );
                label.append( /* Create the button here */ );
            } else {
                listItem.addClass( "jkl-category-checked" );
            }
       } );
       
       // Obviously, hide the interface items on unchecked checkboxes
       uncheckedTerms.closest( "li" ).addClass( "jkl-category-unchecked" );
       
   }
   
   getCategories();
   
} ( jQuery ) );