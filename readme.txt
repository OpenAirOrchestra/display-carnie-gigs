=== Display Carnie Gigs ===
Contributors: Darryl F
Donate link: http://www.thecarnivalband.com/
Tags: gigs, calendar
Requires at least: 5.3.1
Tested up to: 6.1
Stable tag: 1.1

Display Gig Calendar on a second website for The Carnival Band.

== Description ==

Display Gigs from carnie-gigs plugin on a second, public website.

The shortcode [display-carniegigs] is used to display gigs.  Here are some examples:

	 [display-carniegigs] 
         [display-carniegigs time="past"] 
         [display-carniegigs time="future"] 
         [display-carniegigs display="short"] 
         [display-carniegigs display="long"] 

== Installation ==

1. Upload `display-carnie-gigs.zip` to the `/wp-content/plugins/` directory and unzip.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to settings for the plugin and specify the database information to pull the carnie gigs from.
4. Add the shortcode [display-carniegigs] to a page to list all gigs.
5. Add the shortcode [display-carniegigs time="past"] to a page to list past gigs.
6. Add the shortcode [display-carniegigs time="future"] to a page to list future gigs.


== Frequently Asked Questions ==


== Changelog ==

= 0.1 =
* Initial version.

= 0.2 =
* Github updater integration

= 1.0 =
* Bug fix

= 1.1 =
Don't display time for 00:00:00