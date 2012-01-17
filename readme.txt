=== Pinterest RSS Widget ===
Contributors: bkmacdaddy
Donate link: None! Keep your money for important things!
Tags: Pinterest, rss, feed, widget
Requires at least: 2.8.4
Tested up to: 3.3.1
Stable tag: trunk

A widget to display thumbnails and titles of the latest Pinterest Pins from a specific user via their Pinterest RSS feed

== Description ==

This plugin allows you to place a widget on your sidebar that fetches the most recent contents of a Pinterest user's RSS feed and displays the corresponding thumbnail images. You can choose whether to show the title below the image, and you can set the height and width of the thumbnails to fit your theme.

You can also use this plugin from your theme templates, to display images lists anywhere else on your blog and you can easily give them a fixed size or a maximum size with CSS styling.

Note: This plugin is heavily based on the Image Feed Widget plugin created by Yorik van Havre (http://wordpress.org/extend/plugins/image-feed-widget/)

== Installation ==

1. Upload the folder `pinterest-rss-widget` and its contents to the `/wp-content/plugins/` directory or use the wordpress plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress
3. A new "Pinterest RSS Widget" will be available under Appearance > Widgets, where you can add it to your sidebar and edit all settings of the plugin.

== Frequently Asked Questions ==

= And how do I use the plugin in my theme? =

Anywhere in your theme templates, you can display a list of images coming from rss feeds. Just place the following code where you want the images to appear:

`<?php get_pins_feed_list($username, $maxfeeds, $divname, $printtext, $target, $useenclosures, $thumbwidth, $thumbheight); ?>`

Where:
* $username is the Pinterest username you wish to display Pins from (mandatory)
* $maxfeeds is the maximum number of Pins to display (optional, default = 90)
* $divname is a name suffix for the list class. "myList" will become "pins-feed-myList" (optional)
* $printtext must be 1 if you want the image title to be printed below the image (optional)
* $target is "samewindow" or "newwindow", depending on where you want links to open (optional, default = samewindow)
* $useenclosures is "yes" or "no" (optional, default = yes). Use this if you don't want to use the <enclosure> tag in the feed and force the script to find an image link in the feed item description.
* $thumbwidth is a number that will set the width in pixels of the Pin's thumbnail (optional, default = 150)
* $thumbheight is a number that will set the height in pixels of the Pin's thumbnail (optional, default = 150)

Example:

`<?php get_pins_feed_list('bkmacdaddy', 10, 'myList', 1, 'newwindow', 'yes', 125, 125); ?>` 

== Screenshots ==

1. Screenshot of the widget settings
2. Widget on the front end with 9 Pins and titles displaying

== Changelog ==

= 1.0 =
* First version

== Upgrade Notice ==

= 1.0 =