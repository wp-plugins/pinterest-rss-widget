=== Pinterest RSS Widget ===
Contributors: bkmacdaddy, AidaofNubia, thewebprincess
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SXTEL7YLUSFFC
Tags: Pinterest, rss, feed, widget
Requires at least: 2.8.4
Tested up to: 3.3.1
Stable tag: trunk

A widget to display thumbnails and titles of the latest Pinterest Pins from a specific user via their Pinterest RSS feed

== Description ==

This plugin allows you to place a widget on your sidebar that fetches the most recent contents of a Pinterest user's RSS feed and displays the corresponding thumbnail images. You can choose whether to show the title below the image, and you can set the height and width of the thumbnails to fit your theme. You also have the option of showing the official "Follow Me On Pinterest" button below all your pins.

You can also use this plugin from your theme templates, to display images lists anywhere else on your blog and you can easily give them a fixed size or a maximum size with CSS styling.

Note: This plugin is heavily based on the Image Feed Widget plugin created by Yorik van Havre (http://wordpress.org/extend/plugins/image-feed-widget/). It also utilizes the timthumb PHP script for image resizing (http://code.google.com/p/timthumb/)

== Installation ==

1. Upload the folder `pinterest-rss-widget` and its contents to the `/wp-content/plugins/` directory or use the wordpress plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress
3. A new "Pinterest RSS Widget" will be available under Appearance > Widgets, where you can add it to your sidebar and edit all settings of the plugin.

== Frequently Asked Questions ==

= How do I use the plugin in my theme? =

Anywhere in your theme templates, you can display the list of latest Pins thumbnails by placing the following code where you want them to appear:

`<?php get_pins_feed_list($username, $maxfeeds, $divname, $printtext, $target, $useenclosures, $thumbwidth, $thumbheight, $showfollow); ?>`

Where:

* **username** is the Pinterest username you wish to display Pins from (mandatory)
* **maxfeeds** is the maximum number of Pins to display (optional, default = 90)
* **divname** is a name suffix for the list class. "myList" will become "pins-feed-myList" (optional)
* **printtext** must be 1 if you want the image title to be printed below the image (optional)
* **target** is "samewindow" or "newwindow", depending on where you want links to open (optional, default = samewindow)
* **useenclosures** is "yes" or "no" (optional, default = yes). Use this if you don't want to use the <enclosure> tag in the feed and force the script to find an image link in the feed item description.
* **thumbwidth** is a number that will set the width in pixels of the Pin's thumbnail (optional, default = 150)
* **thumbheight** is a number that will set the height in pixels of the Pin's thumbnail (optional, default = 150)
* **showfollow** is "yes" or "no" (optional, default = yes). Use this if you want to show the "Follow Me On Pinterest" button below the thumbnails.

Example:

`<?php get_pins_feed_list('bkmacdaddy', 10, 'myList', 1, 'newwindow', 'yes', 125, 125, 'yes'); ?>` 

= The images are not showing. What went wrong? =

There are so many variables that are related to hosting servers and such that it's impossible to provide all of the possible answers. However, images not showing is most likely a problem with the timthumb image resizing script. Here are some possible solutions:

* TimThumb requires the GD library, which is available on any host sever with PHP 4.3+ installed. Make sure your host has this installed (most do).
* Once installed and in-use, TimThumb will automatically create a /cache/ subfolder with proper write-permissions. If your host server doesn't allow this by default, be sure to manually create the /cache/ folder within the pinterest-rss-widget directory and set the /cache/ folder permissions to 755. If this still doesn't work, try setting the /cache/ folder permissions to 777.
* Known issue with timthumb.php on **Hostgator**: If your website is hosted on Hostgator, you may need to contact HostGator to request "mod_security whitelisting". More info here: http://support.hostgator.com/articles/specialized-help/technical/timthumb-basics

== Screenshots ==

1. Screenshot of the widget settings
2. Widget on the front end with 9 Pins and titles displaying

== Changelog ==

= 1.2.3 =
* Added FAQS based on some troubleshooting
* Added 2 contributors for their testing assistance and suggestions
* Tweaked instructions on the widget settings

= 1.2.2 =
* Fixed directory path errors on WP Multisite

= 1.2.1 =
* Corrected "Follow Me On Pinterest" button image errors

= 1.2 =
* Added "Follow Me On Pinterest" button

= 1.1 =
* Improved CSS styles for better universal use

= 1.0 =
* First version

== Upgrade Notice ==

= 1.2.3 =