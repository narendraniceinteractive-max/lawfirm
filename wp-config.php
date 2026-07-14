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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Na&Y}3(aH:]o:Z(bpTIQf$gza5xZ^_f^j?nFFHP,@0hWI3k{W?>{at8(_EnVt[zc' );
define( 'SECURE_AUTH_KEY',   '=KqI<0/lFG~/ZAvJO<WzsItlz)4NFWVg@=iBz)LRQ)@^U|ytJ|EM+SEu&nUh)LK^' );
define( 'LOGGED_IN_KEY',     '3[FZPai53M}$^?o]5W>#lMZ&-E$Ddmu(Z{mal[j,Zdx{?J>O%uknvw`fCYMRgY+K' );
define( 'NONCE_KEY',         'lr`1E4#;,^5SR&=eO}3tH9M@If_K{rO|E0Xkp&YleKo6%>=30iUgQb/+$L]U8#K:' );
define( 'AUTH_SALT',         '!>J198f#4ob)VIornKE.X23[XkJP1{@gHy-Yq[h3tfZTJ;V!rn+`<yQG/5M6ZmQi' );
define( 'SECURE_AUTH_SALT',  'k3S+;)_R^X`*J?4);2@5n<N B$qg:>xEUO;CHhCM.3GW{~v4R!w_d%/gm*RrLv`|' );
define( 'LOGGED_IN_SALT',    'X~ms0OKrPZ=/-_k5o)Q6Zp5u8]+FIzyVR^z@T3k~~lZm]vE}XCAyo;/XDZ(FLa4x' );
define( 'NONCE_SALT',        '~aU4I0#>B/Xv4f?/3fn0~Zs.B0wTXS)&Z(T_PRq^ _4YLO@Cz0M@)qVu;7+Ld,e@' );
define( 'WP_CACHE_KEY_SALT', 'IibcQ{F3UhUn:zqR &/J.[dW9|@]@xS`_^VzDSrQ%JS{Lj3&q N$s!Ebr}yg&J!{' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
