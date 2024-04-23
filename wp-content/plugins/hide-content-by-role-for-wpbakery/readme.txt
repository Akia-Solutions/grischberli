=== Hide Content by User Role for WPBakery ===
Contributors: wpterra, wpterrade
Donate link: https://wpterra.com
Tags: wpbakery, hide, show, post, page
Requires at least: 4.7.0
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Hide/show/restrict elements based on user roles like administrator in WPBakery page builder (formerly Visual Composer).

== Description ==

This plugin adds settings to all elements in WPBakery page builder to hide/show the content elements on your website based on user roles. This way you can easily restrict content in WPBakery pages and posts.

For example you can hide a specific column element on your page or post for all users but editors or only show it to logged-out users.

By default (with no checkboxes checked) the content will be visible for all users.

The hidden content will also be removed from the HTML.

= Features =

* can hide content in the frontend for specific user roles and logged out users
* works with all visual composer elements
* removes hidden content from HTML Code
* also works with added custom roles
* no hidden costs, completely free plugin

== Issues with specific Themes / Plugin versions ==

There are alot of themes that are using modified versions of WPBakery Page Builder. Some may not work together well with this plugin.

= Uncode Theme =

The Uncode WPBakery version did not show the tab Visible for roles at all. We fixed this by changing the hook when to add the our tab.

= Salient Theme =

The Salient Theme transforms checkboxes to switches and removes the labels. We fixed that in 1.2.1 and put the labels back there.


== Installation ==

1. Upload the zip to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set the roles for which to hide the content in the WPBakery rows or columns settings

== Frequently Asked Questions ==

= What about feature X =

Just go to the support forums and kindly ask for it, then we´ll see what we can do. Thank you!

== Screenshots ==

1. Hide or show rows and columns with these settings in WPBakery

2. Fixed display of checkbox (which are converted to switches) labels in Salient Theme

3. Fixed tab in Uncode Theme

== Changelog ==

= 1.2.2 =
* fix tab in Uncode Theme

= 1.2.1 =
* fix display of checkbox labels in Salient Theme

= 1.2 =
* add settings to all visual composer elements

= 1.1 =
* add option to show content only for guests (not logged in users)

= 1.0.1 =
* add setting description
* add assets

= 1.0.0 =
* Initial release




