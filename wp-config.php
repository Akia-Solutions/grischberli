<?php
define( 'WP_CACHE', true ); // Added by WP Rocket
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "wp_grisch_db" );

/** MySQL database username */
define( 'DB_USER', "root" );

/** MySQL database password */
define( 'DB_PASSWORD', "" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         'sauIG1INMO9W4q4r2oFfy6jBKrOjtdA0a8GL1Mec7ZqVMaRvw985KbOEfdnFpE7w' );
define( 'SECURE_AUTH_KEY',  'CtNdSqMi8izKKPkvTcTjo2qRXSGEyyR2qaVTAoZ7H0.tOim516vaQiAsQPcNLw4h' );
define( 'LOGGED_IN_KEY',    'BR4pX2zQWLUSVjTIF817WvvfS9AApJonBL.5MNJ.CL4DYjy2jONETM3uXwpqXl2I' );
define( 'NONCE_KEY',        'zTseSv80MP9mWX7ysg.NpSOWqHnLs40sXjU9rHTXi0FNmQJNNOtKWyUTHIg4V48B' );
define( 'AUTH_SALT',        'joV7VH07AcR7i5HWX3AflJcKx4S91aCU9AkcV6Kh6UcqH262QD6wW.l7YDCi5OjI' );
define( 'SECURE_AUTH_SALT', 'jGSo5X2jGgTF0Yd6CvrZjP6.LsSkcus5iPRX.QK1hYpmm/Rkylzz0CflCDykzsqN' );
define( 'LOGGED_IN_SALT',   'kksA91T9Ii1AmsGwiQ1TOSq6cByDuoP6d9ZccfJ4KsY9h.L5sZXHIm/NTcUOPNKE' );
define( 'NONCE_SALT',       'vEAyyGQLbEETvFdacS6j.K6PSbvnFuKmBst2BMbIiwErT1Gd5xDCf9wD3sBVZeWt' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
