<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dellastore');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'c9SNo9h54G');
define('DB_PASSWORD', 'c9SNo9h54G');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Kok{QQ!:]U#.Rp5dmU~!v=jNqE|}7:YX$x@hh2.%d3$v.L/<z#r_BB_:]%)v^5&[');
define('SECURE_AUTH_KEY',  'Y9[HR&,i{F?Z+qQ&~?Jx[(`,OD;0B!VEfKa#_OLL2Hdo_s#6ed}pq&kQ.wo>Q.sN');
define('LOGGED_IN_KEY',    'ZQJl[VFybLdUYWYm0yP]_h_vH`5Ipd86qpbm7$uT+FGyw,7oSXvU&Ug(mpxKR8yI');
define('NONCE_KEY',        '*Y~}|Fd}47v+eZHD2kQd.!y6oIGVT`h{.ctq:oyEb{.u+y~N6;gL+eONz*&p9T3/');
define('AUTH_SALT',        'FT}Xa)9pA`b{uY>qy_Lt$2I}[*~z3o 9%llj-B][<`C2Z-Q2v<o$;4hq!T!k9TUx');
define('SECURE_AUTH_SALT', 'M(g1Q!nz1FnHTF^];BzD`d{j/+Z=fg<ZD[UK<p;ei`c?Tyz$;{s@H3]2t`L9tdlq');
define('LOGGED_IN_SALT',   'nb&p#jox0K+sy@py=/=Q]6o&Cs`7`J&*1@c8g~?]`[1~dKf`}q^:^et~$E^A[^z)');
define('NONCE_SALT',       'GqdjU3jyrPbK:O(!)5n/+JL!~w2mhzBZ-whPeM@)]!YDcy7pb08Ho:lizdG_?3?j');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'delstore_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
