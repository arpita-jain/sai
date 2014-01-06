---------------------------------------
How to change the max image resolution
---------------------------------------

Change the constants in MBT/functions.php
define( 'MBT_MAX_IMAGE_WIDTH', 750);
define( 'MBT_MAX_IMAGE_HEIGHT', 650);

visit the webpage http://domain/system/
The above page will regenerate the images for Buddypress activity plus

For RTMedia, goto http://domain/wp-admin/admin.php?page=rtmedia-settings
Goto Sizes tab
Set the Large size.

Goto tools, http://domain/wp-admin/tools.php?page=regenerate-thumbnails
Goto Settings, Media http:/domain/wp-admin/options-media.php
Change Large image size