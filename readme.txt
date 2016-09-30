=== JKL Primary Categories ===
Contributors:           jekkilekki
Plugin Name:            JKL Primary Categories
Plugin URI:             https://github.com/jekkilekki/plugin-jkl-primary-categories
Author:                 Aaron Snowberger
Author URI:             http://www.aaronsnowberger.com/
Donate link:            https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=567MWDR76KHLU
Tags:                   categories, primary, permalinks, jquery, breadcrumbs, meta, post meta
Requires at least:      3.5
Tested up to:           4.6
Stable tag:             1.0.2
Version:                1.0.2
License:                GPLv2 or later
License URI:            http://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that allows you to set a Primary Category for a Post or Custom Post 
Type that has more than one category selected. Performs like Yoast SEO's implementation.

== Description ==

Requires WordPress 3.5 and PHP 5.5 or later.

After I updated Yoast SEO to version 3.1 on one of my sites, I noticed there was a 
new "Primary" label attached to the main Category saved in a Post. On Posts with 
more than one Category selected, there also appeared a link to "Make Primary" that 
would allow me to instantly change the Primary Category (and permalink) for that Post
(if `/%category%/` was selected in the permalinks structure). I thought it was a 
_superb_ implementation of something that "SHOULD be in WordPress core" but I also 
wanted to add a few minor tweaks to make it a bit more User friendly from the start.

= Usage = 
1. Write a Post
2. Assign one (or more) Categories
3. Select a Primary Category
4. Save the Post
5. (Optional) Use `/%category%/` in your Permalinks structure

== Special Features ==
 
= General =

1. This plugin supports both Post Categories and Custom Post Type Categories (though 
not yet Custom Taxonomies) - it does not load on Pages or other admin screens

= Category Meta box =

1. Automatically assigns the first checked Category as the "Primary" Category 
when a Category checkbox is first clicked (jQuery) or the Post is first saved (post meta)
2. When a Post with multiple selected Categories is loaded, it rearranges the order
of Categories so that the Primary Category is always at the top of the list
3. Allows dynamic switching of the Primary Category, including deselection (it then assigns 
the first selected checkbox to "Primary" - if there is none selected, the interface
elements are removed)
4. Whenever the Primary Category is switched, the change (the new Primary Category) 
is briefly highlighted in light yellow

= Publish Meta box =

1. Adds a single entry in the Publish meta box that declares the Primary Category 
for the Post to allow for easy observation of the Primary Category
2. The Category name in the Publish meta box automatically updates whenever a new 
Primary Category is set (by clicking the "Set Primary" link)
3. If there is no Category selected for the Post, the Primary Category space in the 
Publish meta box shows different interface elements - "Set" and "Help" links rather
than an "Edit" link
4. When clicking the "Set" or "Edit" links in the Publish meta box, the window 
scrolls down the page to focus on the Category meta box and the Primary (or first) 
Category are highlighted briefly in light yellow
5. When clicking the "Help" link in the Publish meta box, a helpful message is 
displayed to the user helping them to understand how to use the plugin

= Notes =
* _There is a plugin conflict with Yoast SEO_ because the functionality of the two 
plugins with regard to Primary Categories is virtually the same. Therefore, Yoast SEO 
should be deactivated if you want to use this plugin. You will receive an admin 
warning message if both plugins are activated at the same time (and double interface 
elements in the admin Posts' Category meta box).
* Upon activation of this plugin, you should be greeted with a Welcome Page that 
introduces the plugin, its features, and other notes in a more user friendly, graphical way.
* To take full advantage of the power of this plugin over the permalinks and site 
breadcrumbs, be sure to add `/%category%/` to your Permalinks structure in Settings.

= Planned Upcoming Features = 
* An Admin Pointer to introduce the plugin usage when a user clicks "Help" in the 
Publish meta box on a Post page
* _Possibly_ support for Custom Taxonomies

= Translations = 
* English (EN) - default
* Korean (KO) - upcoming

If you want to help translate the plugin into your language, please have a look 
at the `.pot` file which contains all definitions and may be used with a [gettext] 
editor.

If you have created your own language pack, or have an update of an existing one, 
you can send your [gettext .po or .mo file] to me so that I can bundle it in the
plugin.

= Contact Me = 
If you have questions about, problems with, or suggestions for improving this 
plugin, please let me know at the [WordPress.org support forums](http://wordpress.org/support/plugin/jkl-primary-categories)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me 
[@jekkilekki](http://twitter.com/jekkilekki)

== Installation ==

= Automatic installation =
1. Log into your WordPress admin
2. Go to `Plugins -> Add New`
3. Search for `JKL Primary Categories`
4. Click `Install Now`
5. Activate the Plugin

= Manual installation =
1. Download the Plugin
2. Extract the contents of the .ZIP file
3. Upload the contents of the `jkl-primary-categories` directory to your `/wp-content/plugins` 
folder of your WordPress installation
4. Activate the Plugin from the `Plugins` page

= Documentation = 
Full documentation of the Plugin and its uses can (currently) be found at its 
[GitHub page](https://github.com/jekkilekki/plugin-jkl-primary-categories) 

== Frequently Asked Questions ==

= Tips =
As a general rule, it is always best to keep your WordPress installation and all 
Themes and Plugins fully updated in order to avoid problems with this or any other 
Themees or Plugins. I regularly update my site and test my Plugins and Themes with
the latest version of WordPress.

= Why doesn't this work on Pages? =
Pages do not use Categories by default, so there is no need to load the plugin on Pages.

= What about Yoast SEO? =
Yes, there is a conflict with the Yoast SEO plugin. It is possible to activate and 
use both plugins at the same time, but honestly, WHY would you want to? You'll just 
end up with both JKL Primary Categories AND Yoast SEO's Primary Terms interface elements, 
implementation, and custom data (meta keys). It's best to just use one or the other.

* If you're more interested in excellent SEO, Yoast is an obvious choice.
* But, if you just want a very SIMPLE implentation of Primary Categories, this plugin provides that option.

= Why does the screen scroll down every time I click the "Edit" or "Set" buttons? =
It seems logical that if you want to Edit or Set a Primary Category, then the focus 
should be placed on the Category meta box. That's what this feature does - it 
scrolls down to put the Category meta box in focus, and highlights the Primary Category
(or first Category) to give you, the User, some visual cues as to how to use the plugin.

= Can you ADD / REMOVE / CHANGE features of the plugin? =
Sure, I'm always open to suggestions. Let me know what you're looking for. Feel
free to open a GitHub Issue on the [plugin repository](https://github.com/jekkilekki/plugin-jkl-primary-categories)
to let me know the specific features or problems you're having.

== Screenshots ==

1. Post editor screen with permalink structure and Publish meta box
2. The Publish meta box and Category meta box with a Primary Category selected

== Other Notes ==

= Support = 
[Click here to visit the forum for this plugin](https://wordpress.org/support/plugin/jkl-primary-categories)

= Acknowledgements = 
This plugin uses:


= License = 
This program is free software; you can redistribute it and/or modify it under the terms 
of the GNU General Public License as published by the Free Software Foundation; either 
version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this 
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth 
Floor, Boston, MA 02110-1301 USA

== Changelog ==

= 1.0.2 (Sept 30, 2016) =
* Decouple Admin Pointer JavaScript from the PHP class
* Localize JavaScript for translations

= 1.0.1 (Sept 29, 2016) =
* Code restructuring, cleanup, and commenting

= 1.0.0 (Sept 28, 2016) =
* Initial release