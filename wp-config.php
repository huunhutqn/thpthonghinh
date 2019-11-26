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
define('DB_NAME', 'honghinh');

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

// phần kết nối của android
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// if ($conn) {
//     echo "kết nối thành công";
// } else {
//     echo "kết nối thất bại";
// }
// kết thúc kết nối của android


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'V,|iUQ<e[&3BMty:/#5vkgh2C_{$?!R;L{n[#:Mznl^zplxum*CgHi)Yi+.k1[km');
define('SECURE_AUTH_KEY', '%M_XKVE}/P_m/S0$iv4#2SoS:lMFYam=8H$j00RE$d$u+oe580@3l`|,J-J3pPft');
define('LOGGED_IN_KEY', 'rM[O-GqYU)4bUS!.F+l44 Lx/z,$!Rq2.nN66WI;boyhZHEnY*$ eK=}$+lb7Uls');
define('NONCE_KEY', 'UcwrzTS+%yzuhA7C/GOGqxg8X|mz^Td(o0WxYKpd.!{y<{&ky;)52fv~I.SKRKL{');
define('AUTH_SALT', 'aY}foj_V%yDH}g3fUA2bxK@|/ N^nK8IDZ0K{7&A_e!6&hYDpSWoFr!+:#*^(kCc');
define('SECURE_AUTH_SALT', 'V.6pIn:wpaN|A_TG4>*L2-E.5gpj/Bj]8,R%[8bx7O0=bJavcB];RI*q*jGe$;wz');
define('LOGGED_IN_SALT', ')b@cerPc*z^^t%wp3IO{Z~oR)AM0ja#QET^M0vn_6avz[hl&IND#+ouue`jL_WUc');
define('NONCE_SALT', 'B<Y>1F<Zc(jI|:xUD?.9vn%W_zWV;9ST(D^k~Yas@}L;u59`+pMO?vk,%Ehg8sZ*');

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
define('WP_DEBUG', true);
define('SAVEQUERIES', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
