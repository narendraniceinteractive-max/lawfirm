<?php
/*
 * Protect WP-Admin (C)
 * @register_install_hook()
 * @register_uninstall_hook()
 * */
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $getPwaOptions;
/** Get all options value */
if ( ! function_exists( 'get_pwa_setting_options' ) ) :
function get_pwa_setting_options() {
	// Static cache to avoid repeated option loading during single request
	static $cached_options = null;

	if ( null !== $cached_options ) {
		return $cached_options;
	}

	$option_keys = array(
		'pwa_active',
		'pwa_rewrite_text',
		'pwa_restrict',
		'pwa_logout',
		'pwa_allow_custom_users',
		'pwa_logo_path',
		'pwa_login_page_bg_color',
		'pwa_login_page_color',
	);

	$options = array();
	foreach ( $option_keys as $key ) {
		$options[ $key ] = get_option( $key, '' );
	}

	$cached_options = $options;

	return $cached_options;
}
endif;

$getPwaOptions = get_pwa_setting_options();
if(isset($getPwaOptions['pwa_active']) && '1'==$getPwaOptions['pwa_active'])
{
add_action('login_enqueue_scripts','pwa_load_jquery');
add_action('init', 'init_pwa_admin_rewrite_rules' );
add_action('init', 'pwa_admin_url_redirect_conditions' );
add_action('login_enqueue_scripts','check_login_status',20);

	if(isset($getPwaOptions['pwa_logout']))
	{
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	}
}
if(!function_exists('check_login_status')):
	function check_login_status()
	{
		$getPwaOptions = get_pwa_setting_options();
		$current_uri = pwa_get_current_page_url($_SERVER);
		$newadminurl = site_url($getPwaOptions['pwa_rewrite_text']);
		 if ( is_user_logged_in() && $current_uri==$newadminurl) 
		 {
				wp_safe_redirect(admin_url()); exit();
			} else {
				//echo 'slient';
			}
		
		
		}
endif;

if ( ! function_exists( 'pwa_logout_user_after_settings_save' ) ) :
function pwa_logout_user_after_settings_save() {
	$getPwaOptions = get_pwa_setting_options();

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Safe usage, read-only check after settings save
	$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Safe usage, read-only check after settings save
	$settings_updated = isset( $_GET['settings-updated'] ) ? sanitize_text_field( wp_unslash( $_GET['settings-updated'] ) ) : '';

	if ( $page === 'pwa-settings' && $settings_updated ) {

		flush_rewrite_rules();

		if ( is_array( $getPwaOptions ) && ! empty( $getPwaOptions['pwa_logout'] ) && ! empty( $getPwaOptions['pwa_rewrite_text'] )) {
			wp_safe_redirect( site_url( '/' . $getPwaOptions['pwa_rewrite_text'] ) );
			exit;
		}
	}
}
endif;

/** Create a new rewrite rule for change to wp-admin url */
if(!function_exists('init_pwa_admin_rewrite_rules')):
function init_pwa_admin_rewrite_rules() {
	$getPwaOptions=get_pwa_setting_options();
    if(isset($getPwaOptions['pwa_active']) && (isset($getPwaOptions['pwa_rewrite_text']) && $getPwaOptions['pwa_rewrite_text']!='')){
    $newurl = wp_strip_all_tags( $getPwaOptions['pwa_rewrite_text'] );
    add_rewrite_rule( $newurl.'/?$', 'wp-login.php', 'top' );
    add_rewrite_rule( $newurl.'/register/?$', 'wp-login.php?action=register', 'top' );
    add_rewrite_rule( $newurl.'/lostpassword/?$', 'wp-login.php?action=lostpassword', 'top' );
    
    }
}
endif;
/** 
 * Update Login, Register & Forgot password link as per new admin url
 * */
if(!function_exists('pwa_load_jquery')):
function pwa_load_jquery()
{
wp_enqueue_script("jquery"); 
}
endif;

if ( ! function_exists( 'pwa_admin_url_redirect_conditions' ) ) :
function pwa_admin_url_redirect_conditions() {

	$getPwaOptions = get_pwa_setting_options();

	$pwaActualURLAry = array(
		site_url( '/wp-login.php' ),
		site_url( '/wp-login.php/' ),
		site_url( '/wp-login' ),
		site_url( '/wp-login/' ),
		site_url( '/wp-admin' ),
		site_url( '/wp-admin/' ),
	);

	$request_url = pwa_get_current_page_url( $_SERVER );
	$newUrl = explode( '?', $request_url );

	if ( ! is_user_logged_in() && in_array( $newUrl[0], $pwaActualURLAry, true ) ) {

		if ( wp_doing_ajax() && $newUrl[0] === site_url( '/wp-admin/admin-ajax.php' ) ) {
			return true;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Safe read-only access
		$login  = isset( $_GET['login'] ) ? sanitize_text_field( wp_unslash( $_GET['login'] ) ) : '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Safe read-only access
		$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Safe read-only access
		$error  = isset( $_GET['error'] ) ? sanitize_text_field( wp_unslash( $_GET['error'] ) ) : '';

		if ( $action === 'rp' && $login !== '' ) {
			if ( username_exists( $login ) ) {
				// valid user, allow reset
			} else {
				wp_safe_redirect( home_url( '/' ), 301 );
				exit;
			}
		} elseif ( $action === 'rp' ) {
			// silent
		} elseif ( $action === 'lostpassword' && $error === 'invalidkey' ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		} elseif ( $action === 'resetpass' ) {
			// silent
		} else {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}

	// Restrict wp-admin access for non-admin users
	if ( isset( $getPwaOptions['pwa_restrict'] ) && (int) $getPwaOptions['pwa_restrict'] === 1 && is_user_logged_in() ) {
		global $current_user;
		wp_get_current_user();
		$user_roles = (array) $current_user->roles;
		$user_ID    = $current_user->ID;
		$user_role  = array_shift( $user_roles );

		$allowed_ids = array();
		if ( ! empty( $getPwaOptions['pwa_allow_custom_users'] ) ) {
			$allowed_ids_raw = explode( ',', $getPwaOptions['pwa_allow_custom_users'] );
			$allowed_ids     = array_map( 'absint', $allowed_ids_raw );
		}

		if ( $user_role !== 'administrator' && ! in_array( $user_ID, $allowed_ids, true ) ) {
			show_admin_bar( false );
			wp_safe_redirect( home_url( '/' ) );
			exit;
		}
	}
}
endif;

/** Get the current url*/
if(!function_exists('pwa_current_path_protocol')):
function pwa_current_path_protocol($s, $use_forwarded_host=false)
{
    $pwahttp = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $pwasprotocal = strtolower($s['SERVER_PROTOCOL']);
    $pwa_protocol = substr($pwasprotocal, 0, strpos($pwasprotocal, '/')) . (($pwahttp) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$pwahttp && $port=='80') || ($pwahttp && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $pwa_protocol . '://' . $host;
}
endif;

if( !function_exists( 'pwa_get_current_page_url' ) ):
 function pwa_get_current_page_url( $s, $use_forwarded_host=false ) {
     
    $requesturl = preg_replace('/(\/+)/','/',$s['REQUEST_URI']); // remove more then 1 slash from url
     
    $url = pwa_current_path_protocol($s, $use_forwarded_host) . $requesturl;
    
    return $url;
 }
endif;

add_action( 'login_enqueue_scripts', 'pwa_update_login_page_logo' );

if ( ! function_exists( 'pwa_update_login_page_logo' ) ) :
function pwa_update_login_page_logo() {

    $plugin_version = '4.1'; // Use plugin version or filemtime() for cache-busting

    // Enqueue login page JS with proper version
    wp_enqueue_script(
        'pwa-login',
        plugin_dir_url( __FILE__ ) . 'js/pwa-login.js',
        array(),          // dependencies
        $plugin_version,  // version
        true              // in footer
    );

    // Prepare localized data
    $newadmin = 'nwp' . get_option( 'pwa_rewrite_text' );
    $bg       = get_option( 'pwa_login_page_bg_color' );
    $color    = get_option( 'pwa_login_page_color' );
    $logo     = get_option( 'pwa_logo_path' );
    $su       = site_url();

    wp_localize_script(
        'pwa-login',
        'pwaawp_object',
        array(
            'u' => $newadmin,
            's' => $su,
            'l' => $logo,
            'b' => $bg,
            'c' => $color,
        )
    );
}
endif;


function pwa_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'pwa_login_logo_url' );

/*************************************************************
  Hooks to overide option value before save it into database 
* ************************************************************/
function pwa_update_field_rewrite_text( $new_value, $old_value ) {
$new_value = str_replace('/', '-', trim(stripslashes(wp_strip_all_tags($new_value))));
return $new_value;
}
add_filter( 'pre_update_option_pwa_rewrite_text', 'pwa_update_field_rewrite_text', 10, 2 );


/**
 * Filter password reset request email's body.
 *
 * @param string $message
 * @param string $key
 * @param string $user_login
 * @return string
 */
function pwa_reset_password_message( $message, $key, $user_login ) {
	$site_name  = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	
	$getPwaOptions=get_pwa_setting_options();
    if(isset($getPwaOptions['pwa_active']) && (isset($getPwaOptions['pwa_rewrite_text']) && $getPwaOptions['pwa_rewrite_text']!='')){
        
        $adminurl = $getPwaOptions["pwa_rewrite_text"]."/?action=rp&key=$key&login=" . rawurlencode( $user_login );
        
   
    
	$reset_link = network_site_url( $adminurl, 'login' );

	// Create new message
	
// translators: %s: Username of the person resetting the password.
$message = sprintf( __( 'Hi %s', 'protect-wp-admin' ), $user_login ) . "\n";
		
// translators: 1: Username of the user requesting password reset. 2: The home URL of the site.
$message .= sprintf( __( 'Someone has requested a password reset for the following account %1$s on %2$s.', 'protect-wp-admin' ), $user_login, network_home_url( '/' ) ) . "\n";



// translators: %s is the username.
$message .= sprintf( __( '
Username: %s', 'protect-wp-admin' ), $user_login ) ."\n";

$message .= __( "
If you didn't make this request, just ignore this email. If you'd like to proceed:", 'protect-wp-admin' ) . "\n";

$message .= __( '
To reset your password, visit the following address:', 'protect-wp-admin' ) . "\n";

$message .= $reset_link . "\n";

return $message;
 }else {
        
       return $message;
    }
    
}

add_filter( 'retrieve_password_message', 'pwa_reset_password_message', 20, 3 );
