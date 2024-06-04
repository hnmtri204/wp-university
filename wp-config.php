<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'university' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'RIp2gE|-CmTWw):H%6m].!T&n6zFnN<v<ihP*$tT)x]PdL^(3+z2a%D1Uk_?CDu,' );
define( 'SECURE_AUTH_KEY',  '|4KwW&gCI=wv]Fr6lc;2PvqF/5GzD<gD#M|aZDPRxEIfY^1g_36xqF|k4VZrUyrT' );
define( 'LOGGED_IN_KEY',    '?fl-2&eqd+ya8olE<k6;BNvuTmGt7i|qv$f?XdCia;jOh5qw(1~u=L*HPPnNI3Wj' );
define( 'NONCE_KEY',        'w%2!)QCLjAoIvO(~`0&<!/#Lz885YLL_Z)hI&pl;c{8u;Ld7bf[~:=rd$e6KQr?*' );
define( 'AUTH_SALT',        'y)cURx6^2%lWEm@#@d^02bq&?lp|*!a|*gCB?oTB4oAHl;[mCiu;E-!W4+kj]*9{' );
define( 'SECURE_AUTH_SALT', 'RSs&l]=#QZ4)n3vd*wrq,TQR#V(S~1!+JOwYxc4jKD%{59e]V#9]8tD;=3yK~@+^' );
define( 'LOGGED_IN_SALT',   ' rm}K.%Ym/=XNyFD}3X}<%<oDo$Rtwl&k4[>V eHx.~1Oi{C~kG(H9Ln;M/d3NgL' );
define( 'NONCE_SALT',       '$SlfL@W;6g.W>iw8o7^CG pFVNm(L!3XzWp&XbDAX1]KimifUo(?U;-B4D>w*4oO' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
