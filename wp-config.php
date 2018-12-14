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
define('DB_NAME', 'rydetech_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '12%c!1l@2$');

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
define('AUTH_KEY',         '1MZ_iX}SdlmTX)WW:FBu+B+N%$GH;uh]<W.N@w}-*b7^b^>`i4`GQV^rJQ?a$;O ');
define('SECURE_AUTH_KEY',  'N0W=Mu1,&dW)*oJb*WB5,/&c-D>!-B@M]g.gHP(Edi.[Yh}V={^{bNEc_[00|-0I');
define('LOGGED_IN_KEY',    '6w>O`>4=n|-TvOlL1W?I;A,(J`?<,zXxyWBRk8IPb[DD|84q.LQFwkd)ARlltHMO');
define('NONCE_KEY',        '7qo79,;I!_dnkHib(jpoT|xYa`N?K1:;ukZHHV,z[qo+T;jn-m`gBnl?MT:F(|-%');
define('AUTH_SALT',        'sAZSWn5o e%t>Fh-%daNN(q+4+<Tms4?@$/#*lKn<]I5}Y_1flqa9g:Eu(PybMg,');
define('SECURE_AUTH_SALT', '`T X9$nNv,2ajRhjY[2a&4|z5tF&(1tB:ALFo9XTR[ v3Mg>0pL`ke{)F@Rm&kXj');
define('LOGGED_IN_SALT',   'n^2vpD[;IXhL95jP{RNnpg)*;%q>Izxml8Qs,QFCY1#~/uM>~Ib3|,,/}=vwK.CZ');
define('NONCE_SALT',       'vlG-kYf!IBN.V}7ty#=zs!5)C`Gm7!b2=9sw(|>e<U_0MzB_^-{#aje|3$=e(PTf');

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