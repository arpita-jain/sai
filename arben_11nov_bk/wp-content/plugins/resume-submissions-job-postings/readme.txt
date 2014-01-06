=== Plugin Name ===
Contributors: kandrews
Donate link: http://www.geerservices.com/products/wordpress-plugins/resume-submissions-job-postings/
Author URI: http://www.geerservices.com
Plugin URI: http://www.geerservices.com/products/wordpress-plugins/resume-submissions-job-postings/
Tags: resume submission, job postings, job listing, resume, jobs 
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 2.5.3

Allows the admin to create and show job postings. Users can submit their resume in response to a posting or for general purposes. 

== Description ==
= --- Quick Announcement --- =
After the first of the year and when current projects start to slow down, I plan on re-writing this plugin in order to add more features that I have in mind.
So if you have any suggests on what should be added to make this a better plugin, please let me know in the support forum. 
Thanks!

The Resume Submissions & Job Postings plugin will allow an admin to post jobs on their website.


When there are open jobs, users can go in and look at each one. They may also submit their resume for any job or for general purposes.


Once the user submits his/her information, the admin may look at, edit, or delete the submitted resume.


The admin may sort resumes by job, or anything else they search.

= New Features: =
* Now Using Custom Post Type for Posting Jobs
* Send Resume Submission's PDF to an email address
* Add the Submit Resume For This Job button anywhere


= Features: =
* Post Jobs
* Users Submit Resume
* Enable Captcha
* Send User 'Thank You' Email
* Widget to Show Job Postings
* Give User Ability to Use TinyMCE on the Cover Letter and the Resume fields
* Lets Admin choose what is shown and required
* Automatically fills in the first name, last name, and email fields if the user is logged in
* Allow User attachment
* Set the amount of allowed attachments and type of attachments
* Customize State list
* Save/Download Submitted Resume as PDF
* Display Submitted Resumes in posts or pages
* Allow Admin to create extra input fields (Coming Soon)

 
== Features ==

1. Post Jobs Using Custom Post Type!
2. Users Submit Resume
3. Enable Captcha
4. Send User 'Thank You' Email
5. Widget to Show Job Postings
6. Give User Ability to Use TinyMCE on the Cover Letter and the Resume fields
7. Lets Admin choose what is shown and required
8. Automatically fills in the first name, last name, and email fields if the user is logged in


== Installation ==

1. Upload the folder `resume-submissions-job-postings` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the shortcodes `[resumeForm]`, `[jobPostings]`, and `[resumeDisplay]` in their respected pages

== Frequently Asked Questions ==

= The line breaks and styling in the forms are not carrying over. =
If it is not keeping the styles, switch the option "Use wpautop()" to Disabled. If this does not work, then I would look into adding the plugin "TinyMCE Advanced".

= I click on "Submit Resume for this Job", but nothing happens or the page is not found. =
Make sure to have the "Resume Form Page" field filled out to go to the page that has the Form shortcode in it.

= I cannot get the Captcha to work correctly. =
You must make sure that the Captcha Key fields are correctly filled out. Also, make sure that the url for those keys is the same url as this site.

= Where can I get the Captcha Keys? =
The Keys can be downloaded at [reCaptcha](https://www.google.com/recaptcha). Follow the steps and you will have your keys.

= There is an error when downloading a Submission as a PDF. =
Make sure that the PDF Base File setting is calling the Document Root path and not the URL path.

= When looking at a submission, I get a FPDI Error in the downloads box. =
The PDF that you use for the base file MUST be saved in the PDF/A format.

== Screenshots ==

1. The Resume Submissions lets you view or edit submitted user resumes. Can also sort by job or keyword.
2. The New Job Postings page that now uses the custom post type feature.
3. The Settings page where you can set the Core Settings, reCaptcha, Attachments, and Emailing.
4. The Input Fields page where you can set which fields are display and/or required.

== Changelog ==
= 2.5.3 =
* Fixed: Updated querys that was giving the warning by the wpdb::prepare() function when updating to Wordpress 3.5
* Fixed: Took functions out of the shortcodes as they were giving an 'already declared' error
* Removed: Code to update old database tables as it looks like users have updated past that version

= 2.5.2 = 
* Fixed: Attachment security vulnerability
* Added: jQuery library function call since some themes don't always call it
* Added: Blank index file
* Coding: Reformated the way the posting are called
* Bug Fix: Date would not show in the widget or on some postings

= 2.5.1 =
* Fixed bug where the submit button function was trying to redeclare itself
* Fixed code that only showed 5 jobs in the drop down box on the submission form

= 2.5 =
* Job Postings now use the Custom Post Types feature
* Added the ability to send the pdf version of the resume submission to an email(s)
* Added the option to theme and localize the reCaptcha
* Added the option to enable/disable the wpautop() for the TinyMCE
* Added code to hide the form on a successful resume submission
* Replaced the php mail() with wp_mail()
* Corrected some minor coding errors
* Removed unused settings
* Removed Job Search feature since the jobs can now be search through the built in search

= 2.1.8 = 
* Added a Dashboard widget that displays the last 5 resume submissions
* Reversed the TinyMCE wpautop to false, which now shows the p tags and breaks
* Updated the menu links 
* Validated the html going through the inputs by the admin as well as the user

= 2.1.7 = 
* Added the ability to search within job postings
* Added the stripslashes_deep() to the backend textareas
* Fixed the display resumes bug 
* Re-coded the form validation to catch the attachment required bug

= 2.1.6 = 
* Reformatted the table on the form.php page so that it displays better into site designs

= 2.1.5 =
* Added a new shortcode that gives the ability to display submitted resumes in a page or post
* Fixed TinyMCE setting bug
* Added the text "There are no jobs available at this time." to the job postings list 

= 2.1.4 =
* Removed the "The following are current job opportunities provided by" text in the Job Postings list
* Corrected some coding for I18n
* Updated the .pot file

= 2.1.3 =
* Fixed Quick Tags Enable/Disable bug
* Added the ability to edit the 'Thank You' text
* Updated the language .pot file
* Updated the recaptchalib.php file 

= 2.1.1 =
* Fixed Job Postings pagination links

= 2.1 =
* Add the ability to download a submission to a PDF
* Fixed the attachments bug
* Fixed IE table view on the Submissions and Job Postings pages
* Fixed Widget bug that would display archived Job Postings
* Added text to the Widget if there are no jobs to display
* Fixed Job Postings data transfer to new table
* Allowed admin to set Quick Tags on the TinyMce
* Ability to dismiss the notice of old database tables

= 2.0 =
* Updated database tables
* Added the option to allow multiple uploads
* Admin has the ability to remove any files from submission
* Added setting to delete all attachments when submission is deleted
* Plugin creates a folder in wp-contents/uploads for user attachments
* Added the ability to download submission as a PDF and the submissions list as a CSV
* Made the state list an option on the Settings page
* Added the ability to bulk delete submissions and job postings
* Fixed "Send User Email" bug
* Cleaned up the page layouts
* Added jQuery to the Settings page for better layout
* Staged the code for the Extra Input Fields

= 1.9.7.4 =
* Fixed Job Postings Widget bug

= 1.9.7.2 =
* Added output buffering on the shortcodes

= 1.9.7 =
* Added icons to each admin page
* Corrected a few _e() function bugs where the text was not showing in the correct place
* Moved the print icon below the submission form on the admin side
* Attached a stylesheet
* Moved the widget code to includes/widget.php

= 1.9.6 =
* Fixed some coding errors that were in update 1.9.5
* Fixed permalink bug on form and widget

= 1.9.5 =
* Fixed bug where wp_editor() was showing an error if it is not present

= 1.9.4.3 =
* Added Spanish and Dutch .po files 

= 1.9.4 =
* Removed htmlentities function from the input
* Added I18n to the main text

= 1.9.3 =
* Added TinyMce to the Job Posting Description textarea

= 1.9.2 =
* Added the page "Input Fields" to the Admin
* Improved scripting for error reporting
* Admin can select which fields to show
* Admin can select whcih fields are required

= 1.8.8 =
* Fixed the link for the "View/Edit" Submission.

= 1.8.7 =
* Fixed the use of TinyMce.
* Allows the admin to enable/disable TinyMce on the Resume Form.

= 1.8.5 =
* Changed queries to comply with the Wordpress standards.
* Links grab the dynamic url instead of it being hard-coded.
* Cleaned up some bugs and typos.


== Upgrade Notice ==
= 2.5 =
* Job Postings are now created using custom post types
* Admin can now send a submission's pdf to an email address while on the submission's page

= 2.1.5 =
* Shortcode `[resumeDisplay]` added to display resumes in posts or pages

= 2.1 =
Admins can now download single submissions as a PDF

= 2.0 =
User can upload attachments
Admin can download submission list to CSV
Admin can customize the state list
Admin can bulk delete submissions and job postings

= 1.9.2 =
The Admin can now select which input fields are shown and which ones are required

= 1.8.7 =
Admin is now able to enable/disable TinyMce on the Resume Form.

= 1.8.5 =
This upgrade meets the standards of the Wordpress plugin development.