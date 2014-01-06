<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'DB1344291');

/** MySQL database username */
define('DB_USER', 'U1344291');

/** MySQL database password */
define('DB_PASSWORD', 'tp5LAwN2B3iBhENy9');

/** MySQL hostname */
define('DB_HOST', 'rdbms.strato.de:');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1Qc^Me1mV%uIlmpa#d!10XcO*^)%u8D8l%UKK4#l#zWisxK^EAeNwj)XQtBSv*6Y');
define('SECURE_AUTH_KEY',  '1kPzCBA63xaWU3Dn@TSXNnZw%H^Q9Dn76#7!PGuo*vz%8wiSgGzYTxpRkS*ifF@O');
define('LOGGED_IN_KEY',    '5WlAIfh6EnXoDkU5vT8eaw8ww!5Rc6tJfnKt%6cZhKyqIGAs)6CPh4gs90HWeli^');
define('NONCE_KEY',        '9W5$bGkwQzE%!yXg&sCVbkvuKz%*zr5)jBd&QIHH)uY6RXHumWVl1$plwjF%LKW2');
define('AUTH_SALT',        'nLR*KnYmn9OGgJqvm9Fr4gEA1RF4^26hXVkOt(KYSGy*M8&zN4q8nOEBlrjWEWt4');
define('SECURE_AUTH_SALT', 'A6g$iy!Wf6FQu5d2XmK2WrKCvvHaErduw0hL$w43WT@ShVnAK87U$u2)hk1LQVAC');
define('LOGGED_IN_SALT',   'p3gU2ZvExzdbOikUhm@&v^yU3tBOrg$qYJcDH!g*oZs1%xht@v2Kz#Nhcv(4X^#k');
define('NONCE_SALT',       'BGGo3%R8BT#$qK)mxiUgr!Y&SC9RlXVa1huzQXF%XYlECBfAi7G7FFToZu1iW*Ec');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

?>
