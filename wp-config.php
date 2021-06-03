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
define( 'DB_NAME', '223675_42cad70e1988a342a19cbc039fe0f2e0' );

/** MySQL database username */
define( 'DB_USER', 'easywp_436552' );

/** MySQL database password */
define( 'DB_PASSWORD', '2Ftj1stLFhwuNDmUPKA/f7tyWkuPIUGWZb/LUgn58bE=' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql-cluster-3-mysql-master.database.svc.cluster.local:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'E]@_N@4}[}V-gs16JWL_a2<k`JPuYfW}%@B(u 52RPmW6M7^`K.x1<m![oOnNc34' );
define( 'SECURE_AUTH_KEY',   'Qgkq5gAAR$f8M([)0q}j1`Hh>ODq|#Ut{y<D=Y.9A<c]sU}ZRd36DEeJH?,m&4/>' );
define( 'LOGGED_IN_KEY',     'Ty$)!5hCv)C9qD$3vgxwb %S<6K<xQx4_Ovo(EP;+7w8TMCIIs;CQM1wiae__p/3' );
define( 'NONCE_KEY',         '$;v<I9.WZNHM(vg}:aC`;4||wa[7FO;636;>{*;*HyU{1[FBEJ >//?=*>6>x%2.' );
define( 'AUTH_SALT',         '?F]E2Wi,/aQ7*fj(xH-dOO*-Jr_~>0_w;:~(7h_$KlH*+2&c*l=!ibWSa1K8Xt!T' );
define( 'SECURE_AUTH_SALT',  'GaY2]a[u6Pf4^^@|=]hQMjK?1[h<,mav8NUdzi$eznDN@e)M4t+.L(1!^9Imb/D4' );
define( 'LOGGED_IN_SALT',    'jlV}_h-V&wFFe dqj{%CT4w#[Jz=O)CvhmB@X$-MGvAXB[NE$qS{HmVM|+Y+Aa^a' );
define( 'NONCE_SALT',        'ZbCVV.QirSE{r4zS_OJjr!+6P6*=k8*>}#*:#<3o_a1%pfj(8EO1pJ+hxIITkx7S' );
define( 'WP_CACHE_KEY_SALT', 'VA,uik+YWB-zae|hb7bJ/1c[.D=WNc#!2cgDhx(GHz[t(mg7ixi .6N2sqWGhjiT' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', '/var/www/wptbox/wp-errors.log');

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('WP_HOME', 'https://deafartspace.ca');
define('WP_SITEURL','https://deafartspace.ca');
