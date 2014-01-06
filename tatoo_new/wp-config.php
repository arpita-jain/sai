<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/* OPTIMIZATION DONE BY MINDBLAZETECH (MBT) START */
define('WP_MAX_MEMORY_LIMIT', '2048M');
define('WP_MEMORY_LIMIT', '2048M');
define('AUTOSAVE_INTERVAL', 120);
define('WP_ALLOW_REPAIR', false);
//define('SAVEQUERIES', true); /* TO DEBUG QUERIES */
/* OPTIMIZATION DONE BY MINDBLAZETECH (MBT) END */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tatoo_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
//define('DB_HOST', 'localhost');
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-_r>FR+*w30+fNr%FmFL9H^HR.9Tky+>2:ojjS]]vl:$+i,i(L3gWW`446Hb+?E?');
define('SECURE_AUTH_KEY',  'P++X$eWG7~FaS!dp4PaQ-AnW(_Q{%|A2wl&f.EqMt]V^}T*z8Vt,no9=c{NnKN{v');
define('LOGGED_IN_KEY',    '|ac|hyV,=Y,-8V.]-b+]k:+j*/c`aDKv)pgaxdFH<|R%y;M8QQA5-kSX=D -DTba');
define('NONCE_KEY',        '`0&J?W 4X#X&Wrkm~`+0g;#q}bZk.FWDP-q$EVrX5k0^jp0==@dX)jR:kWA)Krpe');
define('AUTH_SALT',        '&6#!(_uY}|3v$H;>:V:G}V0F!V!q49QjkO&6r4B&}pS.6(S3<A.U+);$dUl</0l*');
define('SECURE_AUTH_SALT', '!HGW|=0m4EU>/`b|m)9P,WW)F,P[Z~VBBZ U8^&JJ@@b84yX<8,_QBiA-$9X> r^');
define('LOGGED_IN_SALT',   '21cMjAXX2h^&Q =i%~8efs>qK1^(f_@NuW|4VE!+RZZ|Vj^Ub-1!}#@sn(>4{Wo-');
define('NONCE_SALT',       'Zxg!KdaGR)3eT!jW)efusunVC:;G9pjy%h1Df@.&w`!&1W-@FS8v]n+{C(/y&6Fl');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
