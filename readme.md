![banner-1544x500](https://cloud.githubusercontent.com/assets/6644259/18836652/ee31ee80-843b-11e6-8d29-a5a5871ec79e.jpg)

#JKL Primary Categories

`Version 1.0.2`

* [Plugin Page](https://github.com/jekkilekki/plugin-jkl-primary-categories)
* [Author Page](http://www.aaronsnowberger.com/)

A simple plugin that allows you to set a Primary Category for a Post or Custom Post 
Type that has more than one category selected. Performs like Yoast SEO's implementation.

##Description

Requires WordPress 3.5 and PHP 5.5 or later.

After I updated [Yoast SEO to version 3.1](https://yoast.com/yoast-seo-3-1/) on one of my sites, I noticed there was a 
new "Primary" label attached to the main Category saved in a Post. On Posts with 
more than one Category selected, there also appeared a link to "Make Primary" that 
would allow me to instantly change the Primary Category (and permalink) for that Post
(if `/%category%/` was selected in the permalinks structure). 

I thought it was a __superb__ implementation of something that 
["SHOULD be in WordPress core"](https://yoast.com/yoast-seo-3-1/) but I also 
wanted to add a few minor tweaks to make it a bit more User friendly from the start.

###Special Features 

![icon256x256](https://cloud.githubusercontent.com/assets/6644259/18836661/f61ff164-843b-11e6-93ba-650179270675.png)

####General

1. This plugin supports both Post Categories and Custom Post Type Categories (though 
not yet Custom Taxonomies) - it does not load on Pages or other admin screens

####Category Meta box

1. Automatically assigns the first checked Category as the "Primary" Category 
when a Category checkbox is first clicked (jQuery) or the Post is first saved (post meta)
2. When a Post with multiple selected Categories is loaded, it rearranges the order
of Categories so that the Primary Category is always at the top of the list
3. Allows dynamic switching of the Primary Category, including deselection (it then assigns 
the first selected checkbox to "Primary" - if there is none selected, the interface
elements are removed)
4. Whenever the Primary Category is switched, the change (the new Primary Category) 
is briefly highlighted in light yellow

####Publish Meta box

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

###Screenshots

1. Post editor screen with permalink structure and Publish meta box

![screenshot-1](https://cloud.githubusercontent.com/assets/6644259/18836673/fc17f5a8-843b-11e6-89ea-2822f9e9b33a.png)

2. The Publish meta box and Category meta box with a Primary Category selected

![screenshot-2](https://cloud.githubusercontent.com/assets/6644259/18836684/033f859e-843c-11e6-8346-a9d1f5357ec6.png)

###Usage 
1. Write a Post
2. Assign one (or more) Categories
3. Select a Primary Category
4. Save the Post
5. (Optional) Use `/%category%/` in your Permalinks structure

###Notes
* __There is a plugin conflict with Yoast SEO__ because the functionality of the two 
plugins with regard to Primary Categories is virtually the same. Therefore, Yoast SEO 
should be deactivated if you want to use this plugin. You will receive an admin 
warning message if both plugins are activated at the same time (and double interface 
elements in the admin Posts' Category meta box).
* Upon activation of this plugin, you should be greeted with a Welcome Page that 
introduces the plugin, its features, and other notes in a more user friendly, graphical way.
* To take full advantage of the power of this plugin over the permalinks and site 
breadcrumbs, be sure to add `/%category%/` to your Permalinks structure in Settings.

###Planned Upcoming Features 
* An Admin Pointer to introduce the plugin usage when a user clicks "Help" in the 
Publish meta box on a Post page
* _Possibly_ support for Custom Taxonomies

###Translations 
* English (EN) - default
* Korean (KO) - upcoming

If you want to help translate the plugin into your language, please have a look 
at the `.pot` file which contains all definitions and may be used with a [gettext] 
editor.

If you have created your own language pack, or have an update of an existing one, 
you can send your [gettext .po or .mo file] to me so that I can bundle it in the
plugin.

##Documentation & Support
Full documentation of the Plugin and its uses can (currently) be found at its 
[GitHub page](https://github.com/jekkilekki/plugin-jkl-primary-categories) 

###Contact Me
If you have questions about, problems with, or suggestions for improving this 
plugin, please let me know at the [WordPress.org support forums](http://wordpress.org/support/plugin/jkl-timezones)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me 
[@jekkilekki](http://twitter.com/jekkilekki)

##Acknowledgements 

###This plugin uses:


##License
This program is free software; you can redistribute it and/or modify it under the terms 
of the GNU General Public License as published by the Free Software Foundation; either 
version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this 
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth 
Floor, Boston, MA 02110-1301 USA

##Changelog

###1.0.2 (Sept 30, 2016)
* Decouple Admin Pointer JavaScript from the PHP class
* Localize JavaScript for translations

###1.0.1 (Sept 29, 2016)
* Code restructuring, cleanup, and commenting

###1.0.1 (Sept 28, 2016)
* Initial release
