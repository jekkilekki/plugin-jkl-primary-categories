<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="wrap about-wrap">
    <h1><?php _e( 'Welcome to JKL Primary Categories!'); ?></h1>
    <p class="about-text">
        <?php _e( 'Built for 10up; performs like Yoast SEO\'s Primary Terms.' ); ?>
    </p>
    <div class="wp-badge tenup-style">Engineering Exercise</div>
    
    <h2 class="nav-tab-wrapper wp-clearfix">
        <a href="#" class="nav-tab nav-tab-active">
            <?php _e( 'The Plugin' ); ?>
        </a>
<!--        <a href="#" class="nav-tab">
            <?php // _e( 'The Process' ); ?>
        </a>-->
    </h2>
    
    <div class="changelog point-releases">
        <h3><?php _e( 'Initial 1.0.0 Release' ); ?></h3>
        <p><strong>Version 1.0.0</strong> addresses the Challenge to "allow publishers to designate a Primary Category for Posts."</p>
    </div>
    
    <div class="headline-feature feature-video">

    </div>
    <hr>
    
    <div class="changelog">
        <h2>The Engineering Exercise</h2>
        <div class="eng-exercise three-col">
            <div class="col">
                <h3><?php _e( 'Background' ); ?></h3>
                <p><?php _e( 'Many publishers use categories as a means to logically organize their content.  However, many pieces of content have more than one category. Sometimes it’s useful to designate a primary category for posts (and custom post types). On the front-end, we need the ability to query for posts (and custom post types) based on their primary categories.' ); ?></p>
            </div>
            <div class="col">
                <h3><?php _e( 'The Mission' ); ?></h3>
                <p><?php _e( 'Create a WordPress plugin that allows publishers to designate a primary category for posts. We’ve intentionally left implementation details out so you have a chance to show us strategic thinking. The code you write should be secure and performant. When you’re done, send us the code as an archive or a link to a repository.' ); ?></p>
            </div>
            <div class="col">
                <h3><?php _e( 'Time Tracking' ); ?></h3>
                <p><?php _e( 'Please track your time so we have an accurate understanding of how long it took you to complete the project.' ); ?></p>
                <ul>
                    <li><strong>1.5 hours</strong> Initial research</li>
                    <li><strong>10.5 hours</strong> coding the functionality</li>
                    <li><strong>2 hours</strong> coding the Welcome Page</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr>
    
    <div class="feature-section like-yoast">
        <h2>Performs like Yoast SEO's Primary Term</h2>
        <p>
            One of the things I really loved about the 
            <a href="https://yoast.com/yoast-seo-3-1/">3.1 update to Yoast SEO</a> 
            was the addition of the <strong>"Make Primary"</strong> buttons in the 
            Category selection meta box on admin Post screens. This plugin mimics 
            that functionality but ALSO adds something I felt was missing in that plugin:
            <br><br><strong>A one-line notification of the current Primary Category set in 
            the Publish meta box.</strong>
        </p>
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/permalinks-publish.png' ) ); ?>">
    </div>
    <hr>
    <div class="feature-section git-meta-boxes two-col">
        <div class="col">
            <h4>jQuery Functionality</h4>
            <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/primary-categories.gif' ) ); ?>">
            <p>
                When a Post is first saved, the first category becomes the default 
                Primary Category. However, jQuery powers the interactivity that 
                allows the user to instantly switch Primary Categories or deselect 
                them - and a new default Primary Category is assigned.
                <br><br>
                When the Post is saved, a <code>hidden</code> input field records 
                the value and stores it in a custom <code>post meta key</code>.
                <br><br>
                There is also a function to retrieve the Category ID of the Primary 
                Category. This is important to allow modification of the permalinks 
                if <code>/%category%/</code> is present in the permalink structure.
            </p>
        </div>
        <div class="col">
            <h4>Handy Highlighting</h4>
            <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/category-highlighting.gif' ) ); ?>">
            <p>
                The Primary Category is highlighted every time it gets changed 
                or whenever the user clicks the "Edit" button in the Publish meta 
                box above. 
                <br><br>
                If there is no Primary Category set for a Post yet, 
                rather than seeing an "Edit" Primary Category link, the user will 
                see two different links: "Set" and "Help". If either link is clicked,
                the first Category in the Category meta box is highlighted, indicating
                to the user that they need to first select a Category before 
                choosing a Primary Category.
                <br><br>
                All the links in the Publish meta box additionally cause the screen
                to scroll DOWN to focus on the Category meta box.
            </p>
        </div>
    </div>
    <hr>
    <div class="feature-section like-yoast">
        <h2>Yoast SEO Conflict will prevent loading</h2>
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/yoast-conflict.png' ) ); ?>">
        <p>
            Because this plugin adds functionality that mimics Yoast 
            SEO's functionality, there is an obvious conflict if both plugins are 
            active at the same time. 
            <br></br>
            So, JKL Primary Categories first performs a check to see if the 
            <code>WPSEO_Primary_Term</code> class from Yoast SEO already exists. 
            If so, it does not create an instance of itself, but rather pops up 
            an admin error message.
        </p>
    </div>
    <hr>
    
    <div class="feature-section admin-pointer two-col">
        <h2>Get Help</h2>
        <div class="col">
            <img>
            <h3>Buttons in the Publish Meta box</h3>
            <p></p>
        </div>
        <div class="col">
            <img>
            <h3>Handy highlighting</h3>
            <p></p>
        </div>
    </div>
</div>
<div class="clear"></div>
