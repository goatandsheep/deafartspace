<?php // hey day

    if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'] )) {
      if (strpos( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
        $_SERVER['HTTPS']='on';
      }
    };

    define( 'WP_MEMORY_LIMIT', '256M' );
    define( 'WP_MAX_MEMORY_LIMIT', '512M' );
    define( 'FS_METHOD', 'direct');
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
define( 'DB_NAME', 'deaf' );

/** MySQL database username */
define( 'DB_USER', 'preload' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Red0Fi!!' );

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
define( 'AUTH_KEY',         'DOTJEVp^.CG$kY`PEvS@O_TUn43Z+R^5J(~cA}v&A/x<`NvS+s72Ar7wV{nYq+!#' );
define( 'SECURE_AUTH_KEY',  '^z[]-v1Wf*4P`l=CfXfby26#XG[FG81%Nrz4AoqvitZM?J2;FfK^zhMaa%6>3syf' );
define( 'LOGGED_IN_KEY',    '@ s`WycSl[%p1Qw4hOBZjt[c(c3^7<UXZ .%(&V5oO;M8<aDys8(M+YeF`8COYHo' );
define( 'NONCE_KEY',        'd5`S6OQg(R}YU+n9n`;maZPLv]3[<(yF/4oP3;Pg$ed.kxCXx}nSF_A!rS:>-4Wo' );
define( 'AUTH_SALT',        'jgM~7)Ftm(3s6X$ntb.0-e_$YRySb!&,(xJuU0NMqorOU5:Ph$GTuLPf+q,_D;|V' );
define( 'SECURE_AUTH_SALT', 'hjSyV,%(J*PFj/yZv*og#.?4mj_+TK#?.{[{oO5?Ly19*Nisz,8;f*n<fj(]4YL&' );
define( 'LOGGED_IN_SALT',   '8M4X.&O#4ZJhl@,Q$ABP7Sk: SJd!H]$,7gYqw J+rl=`jv6LXqeJl&e4rfQqY++' );
define( 'NONCE_SALT',       'G@d=|tS}w8&!{|}^aF|B~G&#e-_f<Z,H]8#h{HuT)q0y[r2-Z ?1(]}DKj=p]nfp' );

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

define( 'WP_MEMORY_LIMIT', '256M' );

define( 'WP_DEBUG', false );
#define( 'WP_DEBUG', true);
#define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}


//define('WP_HOME','http://preload.test/');
//define('WP_SITEURL','http://preload.test/');

//define('FORCE_SSL_ADMIN', true);

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        $_SERVER['HTTPS']='on';

//define('FORCE_SSL_LOGIN', true);


/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
