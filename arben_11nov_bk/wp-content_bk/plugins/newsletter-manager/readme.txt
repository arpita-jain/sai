=== Newsletter Manager ===
Contributors: f1logic
Donate link: http://xyzscripts.com/donate/

Tags: newsletter, email newsletter, newsletter manager, email manager, mailing list manager, email marketing, opt-in form, subscription form, newsletter subscription, smtp newsletter, newsletter marketing, mass mail, batch mail
Requires at least: 2.8
Tested up to: 3.5.1
Stable tag: 1.2.3
License: GPLv2 or later

Create and send html, plain text or multipart email newsletters to your subscribers.

== Description ==

A quicklook into Newsletter Manager

	★ Opt-in form (html, shortcode and widget) with redirection options
	★ Unlimited email addresses with import/export options
	★ Plain text/HTML/Multipart messages
	★ Personalize email messages using name field
	★ SMTP sending to reduce spam 
	★ Automate email sending with cron job
	★ Send mails in batches with support for hourly limits
	★ Autoresponder on subscription

= Features in Detail =


Newsletter manager allows you to create and send html, plain text or multipart email newsletters to your subscribers. The plugin supports unlimited email campaigns, unlimited email addresses,  double opt-in anti-spam compliance, hourly email sending limit and much more. Opt-in form is available as HTML code, shortcode as well as standard Wordpress widget. The import/export tool allows to create and restore backup of your subscriber list. Newsletter manager also lets you  configuring multiple SMTP sender addresses.

= Features =

Opt-in Form

    HTML subscription (opt-in) forms for your websites
    Shortcode for opt-in form
    Opt-in form widget
    Flexible redirection options in opt-in form

Email addresses

    Unlimited email addresses
    Option to search email addresses
    Extract email addresses from any unformatted text
    Import email addresses from CSV or other text based files
    Backup email addresses by exporting as CSV file

Email Campaigns

    Unlimited email campaigns
    Create HTML or plain text messages
    Create multipart messages
    Create campaign messages using WYSIWYG editor
    Personalize your message using name field
    Upload unlimited attachments
    Easy to add unsubscription link
    Preview campaign by test mail
    Pause/resume active campaigns
    Selective execution of campaigns
    Email firing batch size for each campaign
    Automate email sending using cron job or scheduler
    Efficient email sending engine which prevents duplicate emails
    Detailed statistics of email campaigns

Email Sending Configurations

    Configure hourly limits
    Auto responders for subscription and unsubscription
    SMTP sending settings

Anti-spam compliance

    Email confirmation option for subscribers
    One click unsubscribe link for subscribers


= Want more features ? =

Want more features and options ? Learn more about [XYZ Email Manager](http://xyzscripts.com/advertising/xyz-email-manager/details "XYZ Email Manager"), the standalone version of this plugin.

= About =

Newsletter Manager is developed and maintained by [XYZScripts](http://xyzscripts.com/ "xyzscripts.com"). For any support, you may [contact us](http://xyzscripts.com/support/ "XYZScripts Support").

★ [Newsletter Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager User Guide")
★ [Newsletter Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager FAQ")

== Installation ==

★ [Newsletter Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager User Guide")
★ [Newsletter Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager FAQ")

1. Extract `newsletter-manager.zip` to your `/wp-content/plugins/` directory.
2. In the admin panel under plugins activate Newsletter Manager.
3. You can configure the basic settings from Newsletter-Manager menu.
4. Once settings are done, you may add email addresses, generate opt-in forms and create email campaigns.

If you need any further help, you may contact our [support desk](http://xyzscripts.com/support/ "XYZScripts Support").

== Frequently Asked Questions ==

★ [Newsletter Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager User Guide")
★ [Newsletter Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager FAQ")

= 1. The Newsletter Manager is not working properly. =

Please check the wordpress version you are using. Make sure it meets the minimum version recommended by us. Make sure all files of the `newsletter manager` plugin uploaded to the folder `wp-content/plugins/`

= 2. Why are the emails are not being sent from newsletter manager ? =

Please ensure that PHP mail() function is enabled in your server. Also some servers enforce a validation which requires that the sender email address must belong to same domain,ie, if your site is xyz.com, then the sender email must be someone@xyz.com 

= 3. How can i automate email sending using newsletter manager ? =

You need to set a cron job or scheduled task in your hosting control panel. You can get the syntax of the cron job from the settings page. 

= 4. Can i use the opt-in form html code from newsletter manager in pages which are not part of wordpress ? =

Yes you can the opt-in form html code in any page (even in other websites). But the shortcode will work only in wordpress pages. 

= 5. How can i load an existing list of email addresses to the newsletter manager ? =

If you have any text based file like csv or txt, you can import the email addresses using the import tool. If your data is unformatted, you may use the 'Add Emails' option to extract emails. 

= 6. Can i use custom fields other than 'Name' in newsletter manager ? =

No, right now the plugin allows only one custom field called 'Name'. If you need more fields, you can check the standalone version of this plugin (XYZ Email Manager) at our site.

= 7. Can i multiple email lists in newsletter manager ? =

No, as of now the plugin allows only one default list. If you need to create more lists, you can check the standalone version of this plugin (XYZ Email Manager) at our site.

= 8. My hosting company has set an hourly limit on outgoing emails. Can the plugin take care of this ? =

Sure, you can specify the hourly outgoing limit and the plugin will ensure that no campaigns are fired once the limit is reached  for any particular hour. 

= 9. Does the newsletter manager comply with anti-spam policies  ? =

Yes, the plugin supports double opt-in which will ensure that subscriptions are genuine.  

= 10. Where can i get the standalone version of newsletter manager ? =

You can purchase the email manager script from our website [xyzscripts.com](http://xyzscripts.com/advertising/xyz-email-manager/details "XYZ Email Manager").

More questions ? [Drop a mail](http://xyzscripts.com/members/support/ "XYZScripts Support") and we shall get back to you with the answers.


== Screenshots ==

1. This is the configuration page where you can modify all the settings related to Newsletter Manager.
2. This is the opt-in form generation page.
3. This page is used to create an email campaign.
4. This page is used to export and import email addresses.

== Changelog ==

= 1.2.3 =
* Bug fix in adding emails from admin area
* Bug fix in importing name during import operation

= 1.2.2 =
* Support for auto subscription from Contact Form Manager plugin 
* Option to specify separate sender email in case of SMTP sending
* A few bug fixes

= 1.2.1 =
* Option to specify status in campaign restart
* A few bug fixes

= 1.2 =
* End date in campaigns
* Import name and email from files irrespective of order in which they are stored
* Support for name field in email subjects
* A few bug fixes

= 1.1.1 =
* A few bug fixes

= 1.1 =
* SMTP mailing settings
* Support for multipart messages
* Export emails based on status
* Support for multiple installation in same database
* A few bug fixes

= 1.0.2 =
* Option to search emails.
* Fix for tinymce &lt;p&gt; and &lt;br&gt; autoremoval.
* Bug fix in csv import. 

= 1.0.1 =
* Fix for utf-8 character issue.
* Admin widget for quick statistics.
* Option to activate unsubscribed emails.

= 1.0 =
* First official launch.

== Upgrade Notice ==

= 1.1.1 =
The plugin is more secure and robust with the recent bug fixes.   

= 1.1 =
If you require SMTP mailing settings and option for multipart emails you must do this upgrade.  

= 1.0.2 =
If you had some issue with &lt;p&gt; and &lt;br&gt; tags in  tinymce editor, you must do this update.  

= 1.0.1 =
If you had some issue with utf-8 characters, you must do this update.  


== More Information ==

★ [Newsletter Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager User Guide")
★ [Newsletter Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/newsletter-manager/ "Newsletter Manager FAQ")

= Troubleshooting =

Please read the User Guide and FAQ if you are having problems.

= Requirements =

    WordPress 2.8+
    PHP 5+ 

= Feedback =

We would like to receive your feedback and suggestions. You may submit them at our [support desk](http://xyzscripts.com/members/support/ "XYZScripts Support").
