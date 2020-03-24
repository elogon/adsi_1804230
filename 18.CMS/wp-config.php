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
define( 'DB_NAME', 'cms1804230' );

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
define( 'AUTH_KEY',         'r9[rR,C|xQ{-CH.%5F/hS`[^.T)i?d?vqq>3$!SM6T4e3DZz~R*k;636aZ^ -<t>' );
define( 'SECURE_AUTH_KEY',  'G4Sv&ylwr+A)*_E[/<ZRBpzQK^&qtmPWhO)}=x^/TLdX3,KI=$p`Ky6s^/Y8|A<1' );
define( 'LOGGED_IN_KEY',    ',0eZL@ag!kwL=G.|A(Y/=??!TLKwonhOe+3q-NM;q 5<JJSsY(ONlEi)~ll,s.b+' );
define( 'NONCE_KEY',        '#7#KK5#8{F(4T~GQUc9rSl,&|KMI+<Wm]nbI<ezYv&souXDB>0U4g%tWO9O<,~~G' );
define( 'AUTH_SALT',        'a:TDz<z;!DF4q9n%r{3vC-4J#l51!qu~,mW3z#RW:(7rX`kpkn+M$6oY ak+iKYS' );
define( 'SECURE_AUTH_SALT', 'ILb0W)UGC1Ckji?=+]VYg~b8wUqra-`qR ~/DEN_]%0(TKSpnqzyJ=lq]C9kn}b-' );
define( 'LOGGED_IN_SALT',   'g?G?C#mw] ~SiA*F<!O4R=i81G>nc_N?-SjXuShQtv_!QEWF4Z|bCCnblPS](+N%' );
define( 'NONCE_SALT',       '?zI^GHec^Tch|16ZwEN!ea>CE*9,W?fJg~5z&{i0d%5)Y_3}dS[x3R8-;sx=%R_o' );

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
