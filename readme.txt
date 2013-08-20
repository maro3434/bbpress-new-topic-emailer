=== bbPress New Topic Emailer ===
Contributors: mattkeys
Tags: bbpress, subscribe, new topic, notification
Requires at least: 3.0
Tested up to: 3.5.2
Stable tag: 3.5.2

Create a list of emails to be notified whenever a new topic is created in the specified bbPress Forum. Emails can be chosen on a per-forum basis.

== Description ==

Create a list of emails to be notified whenever a new topic is created in the specified bbPress Forum. Emails to notify can be chosen (or not) on a per-forum basis.

This plugin is released freely and open source by UpTrending (http://uptrending.com) and Hortonworks (http://hortonworks.com). This plugin is provided "AS IS", without warranty of any kind, express or implied.

== Installation ==

1. Upload 'bbpress-new-topic-emailer' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the new menu item "bbPress Topic Emailer" under "settings"
4. Enabled which forums you want to receive notifications on, and input the emails that you want to receive the notifications at.
5. Click the "options" tab to modify the settings including:

* Global On/Off Switch
* Email Subject
* Append Forum Post Title to Subject
* Include Forum Post Content
* Trim Forum Post Content

== Screenshots ==

1. Configure which forums to enable for sending emails, and which emails to use per forum.

2. Configure email options

== HTML Email Template Customization ==

You will find a file called "html_template.html" in the includes/ folder of this plugin. This file can be modified if you would like to customize the way that your emails look.

Things to keep in mind:

* The file must be keep its name "html_template.html" and it must stay in the includes folder
* Inside of the file are four placeholders for content to be injected into the template, they can be moved around, but for the content to be injected properly, they must be somewhere within your file.

The four content placeholders are:

* &lt;!-- NEW_TOPIC_CONTENT_PLACEHOLDER --&gt;
* &lt;!-- NEW_TOPIC_TITLE_PLACEHOLDER --&gt;
* &lt;!-- AUTHOR_NAME_PLACEHOLDER --&gt;
* &lt;!-- NEW_TOPIC_URL_PLACEHOLDER --&gt;



== Changelog ==

= 1.0.0 =
* bbPress New Topic Emailer Initial Release, Enjoy!