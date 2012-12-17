=== BuddyPress Default Group Avatar ===
Contributors: Mike_Cowobo
Donate link: http://trenvo.com/
Tags: buddypress, groups, avatar, default
Requires at least: WordPress 3.5 and BuddyPress 1.6.2
Tested up to: WordPress 3.5 and BuddyPress 1.6.2

Adds a default group avatar to BuddyPress without disabling Gravatars for users.

== Description ==

*This plugin is tested only with BP 1.6.2 and WordPress 3.5, and is not meant to be backwards compatible! If you're running an older version of WordPress, use Vernon's original plugin [BuddyPress Group Default Avatar](http://wordpress.org/extend/plugins/buddypress-default-group-avatar/)*

Allows specifying the URL of an image to use as the BuddyPress default group avatar. This makes it easy to distinguish groups from members who are using the mystery man default user avatar.

It works in all situations (activity stream, groups, forums, directory, etc). Upload your image to somewhere within your theme and drop the full URL in the options screen.

If you had [BuddyPress Group Default Avatar](http://wordpress.org/extend/plugins/buddypress-default-group-avatar/) previously installed, this plugin will use the avatar set in that plugin. Otherwise it's bundled with a default avatar for groups (see screenshots).

Not tested on multisite/network install yet (please confirm if it's working!).

== Installation ==

1. Upload `bp-default-group-avatar` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to BP Group Avatar under the BuddyPress menu and set your image URL.

== Frequently Asked Questions ==

= Does the plugin allow me to upload images directly? =

No. Use the media uploader or FTP.

== Screenshots ==

1. Settings show the URL input and a preview of your image.

== Changelog ==

= 0.2 =

* Complete rewrite of Vernon's original plugin - only the admin page is left
