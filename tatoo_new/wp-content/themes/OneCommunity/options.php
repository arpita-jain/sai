<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	$themename = 'onecommunity';
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/images/';
		
	$options = array();


	$options[] = array( "name" => "General Settings",
						"type" => "heading");
							
	$options[] = array( "name" => "Uploader",
						"desc" => "You can upload your logo or something else and paste path below.",
						"id" => "example_uploader",
						"type" => "upload");


	$options[] = array( "name" => "Your logo`s path",
						"desc" => "Put your logo`s path here. You can upload your logo using Uploader",
						"id" => "logo_path",
						"std" => "http://www.demo1.diaboliquedesign.com/4/logo.png",
						"type" => "text");

	$options[] = array( "name" => "Your favicon`s path",
						"desc" => "Put your favicon`s path here. You can upload your favicon using the Uploader above",
						"id" => "favicon_path",
						"std" => "http://www.demo1.diaboliquedesign.com/4/favicon.gif",
						"type" => "text");


	$options[] = array( "name" => "Hello!",
						"desc" => "`Hello!` message on the frontpage",
						"id" => "hello",
						"std" => "Hello!",
						"type" => "text");



	$options[] = array( "name" => "Info about your website",
						"desc" => "Information visible below `Hello!`",
						"id" => "info",
						"std" => "BuddyPress lets users register on your site and start creating profiles, posting messages, making connections, creating and interacting in groups and much more.",
						"type" => "textarea");


	$options[] = array( "name" => "Enable WP bar",
	"desc" => "Make WP bar invisible", "options_check",
	"id" => "wpbar",
	"std" => "0",
	"type" => "checkbox");


	$options[] = array( "name" => "Number of recent posts on widget",
						"desc" => "",
						"id" => "widget-1",
						"std" => "3",
						"type" => "text");

	$options[] = array( "name" => "Number of recent forums topics on widget",
						"desc" => "",
						"id" => "widget-2",
						"std" => "4",
						"type" => "text");


	$options[] = array( "name" => "Website Analytics",
						"desc" => "You can paste analytics code here",
						"id" => "analytics",
						"std" => "",
						"type" => "textarea");







	$options[] = array( "name" => "Translations",
						"type" => "heading");

	$options[] = array( "name" => "Password Recovery",
						"desc" => "`Password Recovery` translation",
						"id" => "t-1",
						"std" => "Password Recovery",
						"type" => "text");


	$options[] = array( "name" => "Recent posts",
						"desc" => "`Recent posts` translation",
						"id" => "t-2",
						"std" => "Recent posts",
						"type" => "text");
							

	$options[] = array( "name" => "On the Forums",
						"desc" => "`On the Forums` translation",
						"id" => "t-3",
						"std" => "On the Forums",
						"type" => "text");


	$options[] = array( "name" => "All rights reserved by",
						"desc" => "`All rights reserved by` translation",
						"id" => "t-4",
						"std" => "All rights reserved by",
						"type" => "text");


	$options[] = array( "name" => "`or` translation (Tile)",
						"desc" => "`or` translation (Tile)",
						"id" => "t-6",
						"std" => "or",
						"type" => "text");

	$options[] = array( "name" => "Hello",
						"desc" => "`Hello` translation",
						"id" => "t-7",
						"std" => "Hello",
						"type" => "text");


	$options[] = array( "name" => "Search",
						"desc" => "`Search` translation",
						"id" => "t-8",
						"std" => "Search",
						"type" => "text");


	$options[] = array( "name" => "Popular",
						"desc" => "`Popular` translation",
						"id" => "t-9",
						"std" => "Popular",
						"type" => "text");

	$options[] = array( "name" => "Active",
						"desc" => "`Active` translation",
						"id" => "t-10",
						"std" => "Active",
						"type" => "text");


	$options[] = array( "name" => "Alphabetical",
						"desc" => "`Alphabetical` translation",
						"id" => "t-11",
						"std" => "Alphabetical",
						"type" => "text");


	$options[] = array( "name" => "Newest",
						"desc" => "`Newest` translation",
						"id" => "t-12",
						"std" => "Newest",
						"type" => "text");

	$options[] = array( "name" => "Message on the Activity page",
						"desc" => "",
						"id" => "t-13",
						"std" => "You can browse all activities here. Use menu below if you want to browse only specific activities like Group Memberships, New Topics, New Members ...",
						"type" => "textarea");

	$options[] = array( "name" => "Message on the Recovery Password page",
						"desc" => "`A message will be sent to your email address.` password",
						"id" => "t-14",
						"std" => "A message will be sent to your email address.",
						"type" => "textarea");


	$options[] = array( "name" => "Blog categories",
						"desc" => "`Blog categories` translation",
						"id" => "t-15",
						"std" => "Blog categories",
						"type" => "text");

	$options[] = array( "name" => "Not Found",
						"desc" => "`Not Found!` translation",
						"id" => "t-16",
						"std" => "Not Found!",
						"type" => "text");

	$options[] = array( "name" => "Active Members",
						"desc" => "`Active Members` translation",
						"id" => "t-17",
						"std" => "Active Members",
						"type" => "text");

	$options[] = array( "name" => "Popular Members",
						"desc" => "`Popular Members` translation",
						"id" => "t-19",
						"std" => "Popular Members",
						"type" => "text");


	$options[] = array( "name" => "`Login to your account and check new messages` translation",
						"desc" => "`Login to your account and check new messages.` translation",
						"id" => "t-18",
						"std" => "Login to your account and check new messages.",
						"type" => "text");



	$options[] = array( "name" => "`Related Posts` translation",
						"desc" => "`Related Posts` translation",
						"id" => "t-20",
						"std" => "Related Posts",
						"type" => "text");


	$options[] = array( "name" => "`Read more` translation",
						"desc" => "`Read more` translation",
						"id" => "t-21",
						"std" => "Read more",
						"type" => "text");


	$options[] = array( "name" => "`Guest` translation (Tile)",
						"desc" => "`Guest` translation (Tile)",
						"id" => "t-22",
						"std" => "Guest",
						"type" => "text");

	$options[] = array( "name" => "`GROUPS` translation (Tile)",
						"desc" => "`GROUPS` translation (Tile)",
						"id" => "t-23",
						"std" => "GROUPS",
						"type" => "text");

	$options[] = array( "name" => "`groups` slug (Tile)",
						"desc" => "`groups` slug (Tile)",
						"id" => "t-23a",
						"std" => "groups",
						"type" => "text");

	$options[] = array( "name" => "`FORUM` translation (Tile)",
						"desc" => "`FORUM` translation (Tile)",
						"id" => "t-24",
						"std" => "FORUM",
						"type" => "text");

	$options[] = array( "name" => "`forum` slug (Tile)",
						"desc" => "`forum` slug (Tile)",
						"id" => "t-24a",
						"std" => "forums",
						"type" => "text");

	$options[] = array( "name" => "`BLOG` translation (Tile)",
						"desc" => "`BLOG` translation (Tile)",
						"id" => "t-25",
						"std" => "BLOG",
						"type" => "text");

	$options[] = array( "name" => "`blog` slug (Tile)",
						"desc" => "`blog` slug (Tile)",
						"id" => "t-25a",
						"std" => "blog",
						"type" => "text");

	$options[] = array( "name" => "`MEMBERS` translation (Tile)",
						"desc" => "`MEMBERS` translation (Tile)",
						"id" => "t-26",
						"std" => "MEMBERS",
						"type" => "text");

	$options[] = array( "name" => "`members` slug (Tile)",
						"desc" => "`members` slug (Tile)",
						"id" => "t-26a",
						"std" => "members",
						"type" => "text");

	$options[] = array( "name" => "`ACTIVITY` translation (Tile)",
						"desc" => "`ACTIVITY` translation (Tile)",
						"id" => "t-27",
						"std" => "ACTIVITY",
						"type" => "text");

	$options[] = array( "name" => "`activity` slug (Tile)",
						"desc" => "`activity` slug (Tile)",
						"id" => "t-27a",
						"std" => "activity",
						"type" => "text");

	$options[] = array( "name" => "`ABOUT US` translation (Tile)",
						"desc" => "`ABOUT US` translation (Tile)",
						"id" => "t-28",
						"std" => "ABOUT US",
						"type" => "text");

	$options[] = array( "name" => "`about-us` slug (Tile)",
						"desc" => "`about-us` slug (Tile)",
						"id" => "t-28a",
						"std" => "about-us",
						"type" => "text");

	$options[] = array( "name" => "`Comments` translation",
						"desc" => "`Comments` translation",
						"id" => "t-29",
						"std" => "Comments",
						"type" => "text");
		
	$options[] = array( "name" => "`Latest posts` translation",
						"desc" => "`Latest posts` translation",
						"id" => "t-30",
						"std" => "Latest posts",
						"type" => "text");

	$options[] = array( "name" => "`Most popular` translation",
						"desc" => "`Most popular` translation",
						"id" => "t-31",
						"std" => "Most popular",
						"type" => "text");

	$options[] = array( "name" => "`60 days` translation",
						"desc" => "`60 days` translation",
						"id" => "t-32",
						"std" => "60 days",
						"type" => "text");

	$options[] = array( "name" => "`You can change your avatar...` translation",
						"desc" => "`You can change your avatar on the Gravatar.com` translation",
						"id" => "t-33",
						"std" => "You can change your avatar on the Gravatar.com",
						"type" => "text");

	$options[] = array( "name" => "`Create an account` translation",
						"desc" => "",
						"id" => "t-34",
						"std" => "Create an account",
						"type" => "text");

	$options[] = array( "name" => "`Started by` translation",
						"desc" => "",
						"id" => "t-35",
						"std" => "Started by",
						"type" => "text");

	$options[] = array( "name" => "`Sign Up` translation",
						"desc" => "",
						"id" => "t-36",
						"std" => "Sign Up",
						"type" => "text");

	$options[] = array( "name" => "`Last post by ` translation",
						"desc" => "",
						"id" => "t-37",
						"std" => "Last post by ",
						"type" => "text");

	$options[] = array( "name" => "`Started by` translation",
						"desc" => "",
						"id" => "t-38",
						"std" => "Started by",
						"type" => "text");

	return $options;
}