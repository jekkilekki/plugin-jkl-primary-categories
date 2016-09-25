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

( function ( $ ) {
   "use strict";
   
   /**
    * Highlights the Primary Category whenever some action happens regarding it
    */
   function highlightPrimary( term ) {
        $( term )
                .animate( { backgroundColor: "#ffffaa" }, 1 )
                .animate( { backgroundColor: "#ffffff" }, 2000 );
   }
   
   /**
    * Gets the Primary Category name from our Publish Metabox (which is set using the get_post_meta() function in PHP)
    */
   function getPrimaryCategory() {
       return $( "#jkl-primary-cat" ).html();
   }
   
   /**
    * Function to be sure we always have a Primary Category labeled in the Publish Meta box if there is at least one Category checked
    */
   function ensurePrimaryCategory( term ) {
       
       var checkedTerms = $( "#categorychecklist input[type='checkbox']:checked" );
       
        if( $( "#jkl-primary-cat" ).html() == "" ) {
            term = $( term );
            //alert( term.value() );
            /* Change Primary Category name in Publish metabox */
             $( "#jkl-primary-cat" ).html( getCategoryName( term, true ) );
        } else if ( checkedTerms.length < 1 ) {
            $( "#jkl-primary-cat" ).html( "" );
        }
        
   }
   
   /**
    * Gets the Category name from an <input> element
    */
   function getCategoryName( term, newPrimaryCat ) {
       var findPrimaryCat = term.closest( 'label' ).html();
       var htmlArr = findPrimaryCat.split( ' ' );
       if( newPrimaryCat ) {
           var end = htmlArr[ htmlArr.length - 4 ].indexOf( '<' );
           var newCatName = htmlArr[ htmlArr.length - 4 ].substr(0, end);
           return newCatName;
       } else {
            return htmlArr[ htmlArr.length - 1 ];
        }
   }
   
   /**
    * Makes the first Category the Primary Category (by default, or if unchecking the Primary Category)
    */
   function setPrimaryCategoryFirst() {
       
       var firstCategory = $( "#categorychecklist input[type='checkbox']:checked:first" );
       firstCategory.closest( 'li' ).removeClass( 'jkl-primary-category' );
       firstCategory.next().remove();
       setPrimaryCategory( firstCategory );
       // updateCategories();
   }
   
   /**
    * Sets a new Primary Category
    */
   function setPrimaryCategory( term ) {
       //$( "#jkl-primary-category" ).val( termId ).trigger( "change" );
        term = $( term );
        var listItem = term.closest( "li" );
        listItem.addClass( "jkl-primary-category" );
        
        var label = term.closest( "label" );
        label.append( "<button class='jkl-category-label jkl-primary-category-button' disabled>Primary</button>" );
        
        /* Change Primary Category name in Publish metabox */
        $( "#jkl-primary-cat" ).html( getCategoryName( term, true ) );
        $( "#jkl-primary-cat-hidden" ).val( getCategoryName( term, true ) );
        
   }
   
   /**
    * Sees which Categories are checked and adds a 'jkl-category-checked/unchecked' class to each
    */
   function updateCategories( ) {
       
       var checkedTerms = $( "#categorychecklist input[type='checkbox']:checked" );
       var uncheckedTerms = $( "#categorychecklist input[type='checkbox']:not(:checked)" );
       
       // Remove all classes for a consistent experience
       checkedTerms.add( uncheckedTerms ).closest( "li" )
               .removeClass( "jkl-category" )
               .removeClass( "jkl-category-checked" )
               .removeClass( "jkl-category-unchecked" );
       uncheckedTerms.closest( "li" ).removeClass( "jkl-primary-category" );
       
       $( ".jkl-category-label" ).remove();
       
       // Don't show the "Primary Category" options if only one Category is selected
       if ( checkedTerms.length < 1 ) {
           $( "#jkl-primary-cat, #jkl-edit-primary-category" ).css( { "display" : "none" } );
           $( "#jkl-set-primary-category, #jkl-pc-help" ).css( { "display" : "inline" } );
           return;
       } else {
           $( "#jkl-primary-cat, #jkl-edit-primary-category" ).css( { "display" : "inline" } );
           $( "#jkl-set-primary-category, #jkl-pc-help" ).css( { "display" : "none" } );
       }
       
       var hasPrimaryCat = 0;
       
       // Create the interface items if they don't yet exist
       checkedTerms.each( function( i, term ) {
            term = $( term );
            var listItem = term.closest( "li" );
            
            if ( listItem.hasClass( 'jkl-primary-category' ) ) {
                hasPrimaryCat++;
                
            }
            
            if ( getCategoryName( term, false ) === getPrimaryCategory() ) { 
                
                setPrimaryCategory( term );
                if( pageLoad ) {
                    listItem.prependTo( "#categorychecklist" );
                }
                
//                listItem.addClass( "jkl-primary-category" );
//                var label = term.closest( "label" );
//                label.append( "<button class='jkl-category-label jkl-primary-category-button' disabled>Primary</button>" );
                
            } else {
                
                listItem.addClass( "jkl-category-checked" );
                listItem.removeClass( "jkl-primary-category" );
                var label = term.closest( "label" );
                label.append( "<button class='jkl-category-label jkl-make-primary-cat'>Set Primary</button>" );
                
            }
       } );
       
       // Obviously, hide the interface items on unchecked checkboxes
       uncheckedTerms.closest( "li" ).addClass( "jkl-category-unchecked" );
       
       if( hasPrimaryCat < 1 && ! pageLoad  ) {
          setPrimaryCategoryFirst();
       }
       
   }
   
   
   
   var pageLoad = true;
   updateCategories();
   pageLoad = false;
   
   /**
    * Checkbox handler for when a checkbox is clicked
    */
//   $( "#categorychecklist input:checkbox" ).change( function() { 
//       updateCategories(); 
//   } );
    $( document ).on( "change", "#categorychecklist input:checkbox", function( e ) {
        ensurePrimaryCategory( e.target );
        updateCategories();
    } );
    
    /**
     * Highlight the first Category li if the user clicks to "Set" or get "Help"
     */
    $( "#jkl-set-primary-category, #jkl-pc-help" ).click( function() {
        highlightPrimary( "#categorychecklist li:first-child" );
        $('html, body')
                .animate( {
                     scrollTop: $( "#categorydiv" ).offset().top
                }, 400);
    } );
    
    /**
     * Highlight the current Primary Category li if the user clicks to "Edit" Category
     */
    $( "#jkl-edit-primary-category" ).click( function() {
        highlightPrimary( ".jkl-primary-category" );
        $('html, body')
                .animate( {
                     scrollTop: $( "#categorydiv" ).offset().top
                }, 400);
    } );
    
    /**
     * Change "Primary" label when one of the "Set Primary" buttons is clicked
     */
    //$( ".jkl-category-label" ).click( function( e ) {
    $( document ).on( "click", ".jkl-category-label", function( e ) {
        e.preventDefault();
        
        /* Change all other interface elements in CategoryDiv */
        var jklCategories = $( ".jkl-category-label" );
        jklCategories
                .removeClass( 'jkl-primary-category-button' )
                .addClass( 'jkl-make-primary-cat' )
                .html( "Set Primary" )
                .prop( 'disabled', false );
        jklCategories.closest( 'li' )
                .removeClass( 'jkl-primary-category' )
                .addClass( 'jkl-category-checked' );
        $( this )
                .removeClass( "jkl-make-primary-cat" )
                .addClass( "jkl-primary-category-button" )
                .html( "Primary" )
                .prop( 'disabled', true );
        $( this ).closest( 'li' )
                .removeClass( 'jkl-category-checked' )
                .addClass( 'jkl-primary-category' );
        highlightPrimary( $( this ).closest( 'li' ) );
        
        /* Change Primary Category name in Publish metabox */
        $( "#jkl-primary-cat" ).html( getCategoryName( $(this), true ) );
        $( "#jkl-primary-cat-hidden" ).val( getCategoryName( $(this), true ) );
        
        /* Also, don't forget to update categories after that */
        updateCategories(); 
        
    } );
   
} ( jQuery ) );