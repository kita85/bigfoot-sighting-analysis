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
define( 'DB_NAME', 'cryptid' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '_D&Qtm.n]&%d fnliW&OH=FV%)hq:@oqvC=d?9TsrZvCjq{np$Z,~HLMIck=SFGD' );
define( 'SECURE_AUTH_KEY',  '`&&%]3cWJ+h`;ZB=&-mL9<0qgrHGR1ZIxWR]yt]CVS-2zkakBMGj2n_75)AJY`fo' );
define( 'LOGGED_IN_KEY',    '4_YnkBLHyNw+tJ5qs!XEBfJgfa9=.GeC=e$l*4+`&Oe=+1of Zh{!1%dEX%QFG5s' );
define( 'NONCE_KEY',        '@}]0]tiw.m1gas5szkZd5oiW#fCsMgmp+)NH|jF>f7>(RekhiebAAQzK>;tlUJHh' );
define( 'AUTH_SALT',        '!-OqESYMo/o6ib6T%HZ<lIz7&`mVKa3ai$7OfkO)%4e^W$X`e_5t/r<4}v36{7L!' );
define( 'SECURE_AUTH_SALT', '/3}.*4$X~?u_5J18?j Hr}a$$;J^oUMi&?7c=A<0rF/F^7?8j~WwT4_zn25Lr6C#' );
define( 'LOGGED_IN_SALT',   'Gt@)f@(/BBuW[Fx>1rr{K|*##7,T)_|UU+oJ@2Z1s:=Pffavm_>nL9C-Wct2IH<l' );
define( 'NONCE_SALT',       '{I]#ykwpTp< ]Jzf}+)bb$/7K|czkoKk!HZ+94|-2sylT_AR.V&kf$>bn3obr_JL' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
