<?php
/**
 * @since           0.0.1
 * @package         JKL_Primary_Categories
 * @author          Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @wordpress-plugin
 * Plugin Name:     JKL Primary Categories
 * Plugin URI:      https://github.com/jekkilekki/plugin-jkl-primary-categories
 * Description:     A simple plugin that allows you to set a Primary Category for a Post or Custom Post Type that has more than one category selected. Similar to Yoast SEO's implementation.
 * Version:         1.0.0
 * Author:          Aaron Snowberger
 * Author URI:      http://www.aaronsnowberger.com
 * Text Domain:     jkl-primary-categories
 * Domain Path:     /languages/
 * License:         GPL2
 * 
 * Requires at least: 3.5
 * Tested up to:    4.6
 */

/**
 * JKL Primary Categories allows you to set a Primary Category for a Post or Custom Post Type.
 * Copyright (C) 2016  AARON SNOWBERGER (email: JEKKILEKKI@GMAIL.COM)
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Plugin Notes:
 * 1) add_filter()? -> modify Publish metabox to show what the current Primary Category is (not set until Post Save)
 * 2) Add JS (append) -> to selected categories "Primary" to the Primary, "Make primary" to all others
 * 3) Save Post meta -> update_post_meta();
 */

/* Prevent direct access */
if ( ! defined( 'WPINC' ) ) die;

/*
 * The class that represents and defines the core plugin
 */
require_once plugin_dir_path( __FILE__ ) . 'class-jkl-primary-categories.php';

/*
 * The function that creates a new JKL_Primary_Categories object and runs the plugin
 */
function run_pcat() {
    // Instantiate the plugin class
    $JKL_PC = new JKL_Primary_Categories( 'jkl-primary-categories', '1.0.0' );
}

run_pcat();