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
                <h3><?php esc_html_e( 'Time Tracking (approximate)', 'jkl-primary-categories' ); ?></h3>
                <ul>
                    <li><?php printf( wp_kses( __( 'Initial research - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>1.5 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( 'Coding the functionality - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>11 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( 'Adding a Welcome Page - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>3 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( 'Adding Admin Pointers - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>2 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( 'Code cleanup and comments - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>1.5 hours</strong>' ); ?></li>
                    <li><?php printf( wp_kses( __( 'Readme documentation - %s', 'jkl-primary-categories' ), array( '' ) ), '<strong>2 hours</strong>' ); ?></li>
                </ul>
                <h4><?php esc_html_e( 'Total: around 20+ hours', 'jkl-primary-categories' ); ?></h4>
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
    
    <div class="feature-section admin-pointer">
        <h2><?php esc_html_e( 'Get Help', 'jkl-primary-categories' ); ?></h2>
        <p><?php esc_html_e( 'When adding a New Post, there are no Categories selected by '
                . 'default, so the interface buttons in the Publish meta box provide '
                . 'a nice tour of the plugin\'s functionality (using WP Admin Pointers) '
                . 'when you click "Help."', 'jkl-primary-categories' ); ?></p>
        <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/tour.gif' ) ); ?>">
    </div>
    <hr>
    
    <div class="feature-section learning three-col">
        <h2><?php esc_html_e( 'What I Learned', 'jkl-primary-categories' ); ?></h2>
        <div class="col">
            <h4><?php esc_html_e( 'The Publish meta box', 'jkl-primary-categories' ); ?></h4>
            <p><?php esc_html_e( 'I knew there was a way to modify the content that appears '
                    . 'in the Publish meta box because I\'ve seen numerous plugins doing that. '
                    . 'I just didn\'t know how initially (I thought I might have to use a '
                    . 'filter hook to add content there).', 'jkl-primary-categories' ); ?>
            </p>
            <p><?php printf( wp_kses( __( 'But then I found out the %s action hook was what I '
                    . 'needed to use.', 'jkl-primary-categories' ),
                    array( '' ) ), '<code>post_submitbox_misc_actions</code>' ); ?></p>
        </div>
        <div class="col">
            <h4><?php esc_html_e( 'Plugin Welcome Page', 'jkl-primary-categories' ); ?></h4>
            <p><?php esc_html_e( "I'd always been curious how plugin Welcome Pages were created "
                . "and why they showed up on plugin activation.", "jkl-primary-categories" ); ?>
            </p>
            <p><?php printf( wp_kses( __( 'By creating this plugin\'s Welcome Page (specifically for '
                    . 'the 10up team), I learned about transients (and that I must set them '
                    . 'in the base plugin file), activation hooks, and also that I should '
                    . 'use the %s action hook to check for other plugins that ' 
                    . 'might cause conflicts (like Yoast).', 'jkl-primary-categories' ),
                    array( '' ) ), '<code>plugins_loaded</code>' ); ?></p>
            </p>
        </div>
        <div class="col">
            <h4><?php esc_html_e( 'Admin Pointers', 'jkl-primary-categories' ); ?></h4>
            <p><?php esc_html_e( 'I knew from the beginning that I wanted some kind of "Help" '
                    . 'for new users of the plugin to better understand how the plugin worked.', 'jkl-primary-categories' ); ?>
            </p>
            <p><?php esc_html_e( 'My first idea was just a simple title attribute or a CSS '
                    . 'tooltip on the "Help" link that would pop up when hovered over. '
                    . 'However, as I got to investigating things, I came across Admin Pointers '
                    . 'and realized that they would provide the perfect solution.', 'jkl-primary-categories' ); ?>
            </p>        
        </div>
    </div>
    <div class="feature-section more-to-learn two-col">
        <h2><?php esc_html_e( 'More to Learn', 'jkl-primary-categories' ); ?></h2>
        <div class="col">
            <h3><?php esc_html_e( 'wp_localize_script()', 'jkl-primary-categories' ); ?></h3>
            <p><?php printf( wp_kses( __( 'I\'d still like to really learn how to use %s '
                    . 'in order to decouple my Admin Pointer JavaScript from its PHP class, and also '
                    . 'so that I can make my JavaScript strings translatable.', 'jkl-primary-categories' ),
                    array( '' ) ), '<code>wp_localize_script()</code>' ); ?>
            </p>
        </div>
        <div class="col">
            <h3><?php esc_html_e( 'Better i18n', 'jkl-primary-categories' ); ?></h3>
            <p><?php printf( wp_kses( __( 'I also need to learn some more about the proper way to '
                    . 'make Strings with HTML elements translatable. I know the basics of '
                    . '%s and %s, but need some more time to work with them.', 'jkl-primary-categories' ),
                    array( '' ) ), '<code>printf()</code>', '<code>sprintf()</code>' ); ?>
            </p>
        </div>
    </div>
    <hr>
    
    <div class="feature-section thanks">
        <h2><img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/optimus-prime-thumbs-up.gif' ) ); ?>"></h2>
        <h2><?php esc_html_e( 'Thanks 10up!', 'jkl-primary-categories' ); ?> <img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/10up-icon.png' ) ); ?>"></h2>
        <p><?php esc_html_e( 'Thanks again for this opportunity to work on a small engineering exercise for you!', 'jkl-primary-categories' ); ?></p>
        <p><?php esc_html_e( 'As you can see, I am very detail oriented, a bit of a perfectionist, '
                    . 'and I really like to challenge myself to push my boundaries and learn NEW '
                    . 'things with every new project. I hope we can continue our discussion about '
                    . 'possible employment with your team. I look forward to hearing from you!', 'jkl-primary-categories' ); ?>
        </p>
        <h2><img src="<?php echo esc_url( plugins_url( 'jkl-primary-categories/images/signature.png' ) ); ?>"></h2>
    </div>
    <hr>
    
    <div class="return-to-dashboard">
        <?php printf( wp_kses( __( '<a href="%s>Get started! &rarr; Choose a Primary Category for a Post</a>' ),
                    array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php' ) ) ); ?>
    </div>
</div>
<div class="clear"></div>
