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
define('DB_NAME', 'wp_starkeymtg');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '.I56~W_vuV3s,}UVVQzCC0X-23J$gU>2y(-zWSelVRxv1_.gx*&W}M8xO-w&h!b`');
define('SECURE_AUTH_KEY',  'j=pyF5qahzH@j6S,AE9^?=0ns/zNJar@3-J^.soNby6d--Tq&0/sjDqeYRd5QX9C');
define('LOGGED_IN_KEY',    '??GE# (|*a#(`;)!7D1} PmK =Ci$:zJeh7ykCvW-s3G6SKK|(sf$mSpQqXJ$x$y');
define('NONCE_KEY',        ',;g8Vv9<@X4L+h`BoVEMkMmHb*h78V*50;(SV>CJZB|sk($hoB$4NP#HKUF@uv+_');
define('AUTH_SALT',        'ghpvB(.W;0Y>H1MVA}aK&4JG5qr{cXZC$-/e0kh#$?![SIi@5Z-`#^/1zKzLdizJ');
define('SECURE_AUTH_SALT', '4q-cdY);@CW$<M}r@/Vs ld<uyLZ{X>ieK^^(U[BF+mEM)(n(!; >>YeQD<>tv9@');
define('LOGGED_IN_SALT',   '?3O=O|:J8?#BBkihJ3|)8 sY| *LbPxcR@7E,g|W!0TF17bQDO[O3K3AH7ih_[*#');
define('NONCE_SALT',       'k.#$Mf71ct2CgDI+CL<+}Kt4|0p!~P<dzG^b*lVeiEM4Zy0R*E/%yJROsuEiN%&X');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
