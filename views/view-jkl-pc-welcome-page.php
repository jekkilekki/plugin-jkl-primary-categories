<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="wrap about-wrap">
    <h1><?php esc_html_e( 'Welcome to JKL Primary Categories!', 'jkl-primary-categories' ); ?></h1>
    <p class="about-text">
        <?php esc_html_e( 'Built for 10up; performs like Yoast SEO\'s Primary Terms.', 'jkl-primary-categories' ); ?>
    </p>
    <div class="wp-badge tenup-style"><?php esc_html_e( 'Engineering Exercise', 'jkl-primary-categories' ); ?></div>
    
    <h2 class="nav-tab-wrapper wp-clearfix">
        <a href="#" class="nav-tab nav-tab-active">
            <?php esc_html_e( 'The Plugin', 'jkl-primary-categories' ); ?>
        </a>
        <!--<a href="#" class="nav-tab">
            <?php // esc_html_e( 'The Process', 'jkl-primary-categories' ); ?>
        </a>-->
    </h2>
    
    <div class="changelog point-releases">
        <h3><?php esc_html_e( 'Greetings 10up Team!', 'jkl-primary-categories' ); ?></h3>
        <p><?php esc_html_e( 'Thanks for asking me to work on this "small engineering exercise" '
                . 'that addresses the Challenge to "allow publishers to designate a '
                . 'Primary Category for Posts." It was a lot of fun (as demonstrated by '
                . 'my Optimus Prime artwork).', 'jkl-primary-categories' ); ?>
        </p>
    </div>
    
    <div class="feature-section">
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/assets/banner-1544x500.jpg' ) ); ?>">
    </div>
    <hr>
    
    <div class="changelog">
        <h2><?php esc_html_e( 'The Engineering Exercise', 'jkl-primary-categories' ); ?></h2>
        <div class="eng-exercise three-col">
            <div class="col">
                <h3><?php esc_html_e( 'Background', 'jkl-primary-categories' ); ?></h3>
                <p><?php esc_html_e( 'Many publishers use categories as a means to logically '
                        . 'organize their content.  However, many pieces of content have more '
                        . 'than one category. Sometimes it’s useful to designate a primary '
                        . 'category for posts (and custom post types). On the front-end, we '
                        . 'need the ability to query for posts (and custom post types) based '
                        . 'on their primary categories.', 'jkl-primary-categories' ); ?>
                </p>
            </div>
            <div class="col">
                <h3><?php esc_html_e( 'The Mission', 'jkl-primary-categories' ); ?></h3>
                <p><?php esc_html_e( 'Create a WordPress plugin that allows publishers to '
                        . 'designate a primary category for posts. We’ve intentionally left '
                        . 'implementation details out so you have a chance to show us '
                        . 'strategic thinking. The code you write should be secure and performant. '
                        . 'When you’re done, send us the code as an archive or a link to '
                        . 'a repository.', 'jkl-primary-categories' ); ?>
                </p>
            </div>
            <div class="col">
                <h3><?php esc_html_e( 'Time Tracking', 'jkl-primary-categories' ); ?></h3>
                <p><?php esc_html_e( 'Please track your time so we have an accurate understanding '
                        . 'of how long it took you to complete the project.', 'jkl-primary-categories' ); ?>
                </p>
                <ul>
                    <li><?php printf( wp_kses( __( '%s Initial research', 'jkl-primary-categories' ), array( '' ) ), '<strong>1.5 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( '%s coding the functionality', 'jkl-primary-categories' ), array( '' ) ), '<strong>10.5 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( '%s coding the Welcome Page', 'jkl-primary-categories' ), array( '' ) ), '<strong>2 hours</strong>' ); ?></li>
                </ul>

            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr>
    
    <div class="feature-section like-yoast">
        <h2><?php esc_html_e( 'Performs like Yoast SEO\'s Primary Term', 'jkl-primary-categories' ); ?></h2>
        <p>
            <?php printf( wp_kses( __( 'One of the things I really loved about the '
                    . '<a href="%s">3.1 update to Yoast SEO</a> was the addition of the '
                    . '"Make Primary" buttons in the Category selection '
                    . 'meta box on admin Post screens. This plugin mimics that functionality '
                    . 'but ALSO adds something I felt was missing in that plugin:', 'jkl-primary-categories' ),
                    array( 'a' => array( 'href' => array() ) ) ), esc_url( 'https://yoast.com/yoast-seo-3-1/' ) );
            ?>
        </p>
        <p>
            <strong>
            <?php esc_html_e( 'A one-line notification of the current Primary Category set in '
                    . 'the Publish meta box.', 'jkl-primary-categories' );
            ?>
            </strong>
        </p>
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/permalinks-publish.png' ) ); ?>">
    </div>
    <hr>
    <div class="feature-section git-meta-boxes two-col">
        <h2><?php esc_html_e( 'Easy, Instant Interaction', 'jkl-primary-categories' ); ?></h2>
        <div class="col">
            <h4><?php esc_html_e( 'jQuery Functionality', 'jkl-primary-categories' ); ?></h4>
            <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/primary-categories.gif' ) ); ?>">
            <p>
                <?php esc_html_e( 'When a Post is first saved, the first category becomes '
                        . 'the default Primary Category. However, jQuery powers the interactivity '
                        . 'that allows the user to instantly switch Primary Categories or deselect '
                        . 'them - and a new default Primary Category is assigned.', 'jkl-primary-categories' ); ?>
            </p>
            <p>
                <?php printf( wp_kses( __( 'When the Post is saved, a %s input '
                        . 'field records the value and stores it in a custom %s.', 'jkl-primary-categories' ),
                        array( '' ) ), '<code>hidden</code>', '<code>post meta key</code>' ); ?>
            </p>
            <p>
                <?php printf( wp_kses( __( 'There is also a function to retrieve the '
                        . 'Category ID of the Primary Category. This is important to '
                        . 'allow modification of the permalinks if %s is present in the '
                        . 'permalink structure.', 'jkl-primary-categories' ),
                        array( '' ) ), '<code>/%category%/</code>' ); ?>
            </p>
        </div>
        <div class="col">
            <h4><?php esc_html_e( 'Handy Highlighting', 'jkl-primary-categories' ); ?></h4>
            <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/category-highlighting.gif' ) ); ?>">
            <p>
                <?php esc_html_e( 'The Primary Category is highlighted every time it gets '
                        . 'changed or whenever the user clicks the "Edit" button in the '
                        . 'Publish meta box above.', 'jkl-primary-categories' ); ?>
            </p>
            <p>
                <?php esc_html_e( 'If there is no Primary Category set for a Post yet, '
                        . 'rather than seeing an "Edit" Primary Category link, the user '
                        . 'will see two different links: "Set" and "Help". If either '
                        . 'link is clicked,the first Category in the Category meta box is '
                        . 'highlighted, indicatingto the user that they need to first select '
                        . 'a Category before choosing a Primary Category.', 'jkl-primary-categories' ); ?>
            </p>
            <p>
                <?php esc_html_e( 'All the links in the Publish meta box additionally cause '
                        . 'the screen to scroll DOWN to focus on the Category meta box.', 'jkl-primary-categories' ); ?>
            </p>
        </div>
    </div>
    <hr>
    <div class="feature-section like-yoast">
        <h2><?php esc_html_e( 'Yoast SEO Conflict', 'jkl-primary-categories' ); ?></h2>
        <p>
            <?php esc_html_e( 'Because this plugin adds functionality that mimics Yoast SEO\'s '
                    . 'functionality, there is an obvious conflict if both plugins are '
                    . 'active at the same time. (They will each load their own jQuery '
                    . '"Make Primary" elements.)', 'jkl-primary-categories' ); ?>
        </p>
        <p>
            <?php printf( wp_kses( __( 'So, JKL Primary Categories first performs a check to '
                    . 'see if the %s class from Yoast SEO already exists. If so, it pops up '
                    . 'an admin error message. Then, after disabling Yoast, the '
                    . 'JKL Primary Categories Welcome Page is displayed.', 'jkl-primary-categories' ),
                    array( '' ) ), '<code>WPSEO_Primary_Term</code>' ); ?>
        </p>
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/yoast-conflict.png' ) ); ?>">
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
