<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_portfolio_db' );

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
define( 'AUTH_KEY',         'lJ?/gRL|!147.6$>L4QQ?(0q$O #4>:;6|?_xb-<p0PZFpOurpypIg;iIlO^nhQ3' );
define( 'SECURE_AUTH_KEY',  '[P.m_j&E:(P:1B&ec`hwpM@iTw=VqYZzh!Zjn.zQ(<o~?Q7H5sbFLko}v=o7V7GU' );
define( 'LOGGED_IN_KEY',    'Ra#caTsFE(FvsGUIb~O-Udpbz(.Z5s/]1,/]6!{$@/o&.7JL{.DnPTO<t;Z]%&vK' );
define( 'NONCE_KEY',        'a0J![kcDnCf3-3yCr1|tT?iB94DW$M{*2z_tSB{zXxH;:L*xO:NF/^v,.}uto4bq' );
define( 'AUTH_SALT',        '^uc*^.[^$@4K)Ev|IGHX`37V?G|CU)xs~;<|g?4BLXd1lHl(wKKZty~G%$T6xP2t' );
define( 'SECURE_AUTH_SALT', '/eaj//erDlic0%%;?[R9}0-`4Q:PZh%r)gw(f3L`l@-mf6votnfpM$-9DRuua(Ei' );
define( 'LOGGED_IN_SALT',   'l|dskZYkI-$RCnd_q|<5m1OlLhM55e.7ty94 kOl>u@%NR8|?#D8/=gj3|xm=$G,' );
define( 'NONCE_SALT',       'z$,{ro{8-d|czHI.qx(o<ju,Q#smhw]sH3hQ2:29dunbPm>75OC(4/uesJ%*}^xl' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
