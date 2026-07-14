<?php
/*
Plugin Name: Protect WP Admin
Plugin URI: https://www.wp-experts.in/products/protect-wp-admin-pro
Description: Protect your admin area by customizing the login URL and restricting access to unauthorized users.
Version: 4.2
Author: WPExperts.in
Author URI: https://www.wp-experts.in
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: protect-wp-admin
Requires at least: 6.0
Tested up to: 6.9.1
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Initialize "Protect WP Admin" plugin admin menu 
 * @create new menu
 * @create plugin settings page
 */
add_action('admin_menu','init_pwa_admin_menu');
if(!function_exists('init_pwa_admin_menu')):
function init_pwa_admin_menu(){
	add_options_page('Protect WP Admin','Protect WP Admin','manage_options','pwa-settings','init_pwa_admin_option_page');
}
endif;
           
/**
* hook to add link under adminmenu bar
*/	
add_action( 'admin_bar_menu', 'toolbar_link_to_pwa', 999 );		 
function toolbar_link_to_pwa( $wp_admin_bar ) {
	$user = wp_get_current_user();
	if (!current_user_can('administrator') && is_admin()) return;
	
	$args = array(
		'id'    => 'pwa_menu_bar',
		'title' => 'Protect WP Admin',
		'href'  => admin_url('options-general.php?page=pwa-settings'),
		'meta'  => array( 'class' => 'pwa-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
	//second lavel
	$wp_admin_bar->add_node( array(
		'id'    => 'pwa-second-sub-item',
		'parent' => 'pwa_menu_bar',
		'title' => 'Settings',
		'href'  => admin_url('options-general.php?page=pwa-settings'),
		'meta'  => array(
			'title' => __('Settings', 'protect-wp-admin'),
			'target' => '_self',
			'class' => 'pwa_menu_item_class'
		),
	));
}
/** Define Action to register "Protect WP-Admin" Options */
add_action('admin_init','init_pwa_options_fields');
/** Register "Protect WP-Admin" options */
if(!function_exists('init_pwa_options_fields')):
function init_pwa_options_fields(){
	register_setting('pwa_setting_options','pwa_active', 'sanitize_text_field' );
	register_setting('pwa_setting_options','pwa_rewrite_text', 'sanitize_text_field' );	
	register_setting('pwa_setting_options','pwa_restrict', 'sanitize_text_field' );	
	register_setting('pwa_setting_options','pwa_logout', 'sanitize_text_field' );
	register_setting('pwa_setting_options','pwa_allow_custom_users', 'sanitize_text_field' );
	register_setting('pwa_setting_options','pwa_logo_path', 'sanitize_url' );
	register_setting('pwa_setting_options','pwa_login_page_bg_color', 'sanitize_text_field' );
	register_setting('pwa_setting_options','pwa_login_page_color', 'sanitize_text_field' );
} 
endif;

/** Add settings link to plugin list page in admin */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'pwa_action_links' );
if(!function_exists('pwa_action_links')):
function pwa_action_links( $links ) {
   $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=pwa-settings') .'">Settings</a> | <a href="http://www.wp-experts.in/products/protect-wp-admin-pro">GO PRO</a>';
   return ($links);
}
endif;
if ( ! function_exists( 'init_pwa_admin_option_page' ) ) :
function init_pwa_admin_option_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'protect-wp-admin' ) );
	}

	$permalink_structure_val = get_option( 'permalink_structure' ) ? 'yes' : 'no';
	?>
	<div class="wrap pwa-admin-settings-wrapper">
		<h1><?php esc_html_e( 'Protect WP-Admin Settings', 'protect-wp-admin' ); ?></h1>

		<form action="options.php" method="post" id="pwa-settings-form-admin">
			<?php settings_fields( 'pwa_setting_options' ); ?>
			<input type="hidden" id="check_permalink" value="<?php echo esc_attr( $permalink_structure_val ); ?>">

			<div id="pwa-tab-menu">
				<a id="pwa-general" class="pwa-tab-links active"><?php esc_html_e( 'General', 'protect-wp-admin' ); ?></a>
				<a id="pwa-admin-style" class="pwa-tab-links"><?php esc_html_e( 'Login Page Style', 'protect-wp-admin' ); ?></a>
				<a id="pwa-support" class="pwa-tab-links"><?php esc_html_e( 'Support & Our Other Plugins', 'protect-wp-admin' ); ?></a>
			</div>
			<hr>

			<div class="pwa-setting">

				<!-- General Settings Tab -->
				<div class="pwa-tab" id="div-pwa-general">
					<h2><?php esc_html_e( 'General Settings', 'protect-wp-admin' ); ?></h2>
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="pwa_active"><?php esc_html_e( 'Enable', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="pwa_active" name="pwa_active" value="1" <?php checked( get_option( 'pwa_active' ), '1' ); ?> />
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="pwa_rewrite_text"><?php esc_html_e( 'New Admin Slug', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="text" id="pwa_rewrite_text" name="pwa_rewrite_text" size="30" value="<?php echo esc_attr( get_option( 'pwa_rewrite_text' ) ); ?>" onkeyup="this.value=this.value.replace(/[^a-z]/g,'');" placeholder="<?php esc_attr_e( 'myadmin', 'protect-wp-admin' ); ?>">
								<p class="description"><?php esc_html_e( 'Only lowercase alphabets allowed. No special characters.', 'protect-wp-admin' ); ?></p>
								<?php
								if (
									! empty( get_option('pwa_active') ) &&
									! empty( get_option('pwa_rewrite_text') )
								) {
									$preview_url = site_url( get_option('pwa_rewrite_text') . '?preview=1' );
									echo '<p><a href="' . esc_url( $preview_url ) . '" target="_blank" style="color: #ff0000;">' . esc_html__( 'Preview of New Admin URL', 'protect-wp-admin' ) . '</a></p>';
									echo '<em><strong>' . esc_html__( 'Note:', 'protect-wp-admin' ) . '</strong> ' . esc_html__( 'Please check the new admin URL before logout.', 'protect-wp-admin' ) . '</em>';
								}
								?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Restrict Access to Non-Admins', 'protect-wp-admin' ); ?></th>
							<td>
								<input type="checkbox" id="pwa_restrict" name="pwa_restrict" value="1" <?php checked( get_option( 'pwa_restrict' ), '1' ); ?> />
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="pwa_allow_custom_users"><?php esc_html_e( 'Allow Access to Specific User IDs', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="text" id="pwa_allow_custom_users" name="pwa_allow_custom_users" value="<?php echo esc_attr( get_option( 'pwa_allow_custom_users' ) ); ?>" placeholder="1,2,3">
								<p class="description"><?php esc_html_e( 'Add comma-separated user IDs.', 'protect-wp-admin' ); ?></p>
							</td>
						</tr>
					</table>
				</div>

				<!-- Admin Style Tab -->
				<div class="pwa-tab" id="div-pwa-admin-style">
					<h2><?php esc_html_e( 'Login Page Style Settings', 'protect-wp-admin' ); ?></h2>
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="pwa_logo_path"><?php esc_html_e( 'Login Page Logo URL', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="text" id="pwa_logo_path" name="pwa_logo_path" value="<?php echo esc_url( get_option( 'pwa_logo_path' ) ); ?>" size="30">
								<input type="button" value="<?php esc_attr_e( 'Upload Image', 'protect-wp-admin' ); ?>" class="upload_image button">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="pwa_login_page_bg_color"><?php esc_html_e( 'Background Color', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="text" id="pwa_login_page_bg_color" name="pwa_login_page_bg_color" class="color-field" value="<?php echo esc_attr( get_option( 'pwa_login_page_bg_color' ) ); ?>" size="30">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="pwa_login_page_color"><?php esc_html_e( 'Text Color', 'protect-wp-admin' ); ?></label>
							</th>
							<td>
								<input type="text" id="pwa_login_page_color" name="pwa_login_page_color" class="color-field" value="<?php echo esc_attr( get_option( 'pwa_login_page_color' ) ); ?>" size="30">
							</td>
						</tr>
					</table>
				</div>

				<!-- Support Tab -->
				<div class="pwa-tab" id="div-pwa-support">
					<h2><?php esc_html_e( 'Plugin Support', 'protect-wp-admin' ); ?></h2>
					<p>
						<a href="https://www.wp-experts.in/products/protect-wp-admin-pro" class="button button-primary" target="_blank">
							<?php esc_html_e( 'Click here to download add-on', 'protect-wp-admin' ); ?>
						</a>
					</p>
					<p><strong><?php esc_html_e( 'Plugin Author:', 'protect-wp-admin' ); ?></strong> <a href="https://www.wp-experts.in" target="_blank">WP-Experts.In</a></p>
					<p><a href="mailto:raghunath.0087@gmail.com" target="_blank"><?php esc_html_e( 'Contact Author', 'protect-wp-admin' ); ?></a></p>
				</div>

			</div>

			<p>
				<?php
				submit_button( __( 'Save Settings', 'protect-wp-admin' ), 'primary', 'submit', false );
				?>
			</p>

			<p><strong style="color:red;"><?php esc_html_e( 'Important:', 'protect-wp-admin' ); ?></strong> <?php esc_html_e( "Don't forget to preview the new admin URL after updating the slug.", 'protect-wp-admin' ); ?></p>

		</form>
	</div>
	<?php
}
endif;

/** add js into admin footer */
if ( ! function_exists( 'init_pwa_admin_scripts' ) ) :
function init_pwa_admin_scripts( $hook_suffix ) {

    // Only enqueue on plugin settings page
    // WordPress gives hook_suffix like "settings_page_pwa-settings"
    if ( 'settings_page_pwa-settings' !== $hook_suffix ) {
        return;
    }

    // Capability check
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $plugin_version = '4.1';

    // Enqueue admin style
    wp_enqueue_style(
        'pwa_admin_style',
        plugins_url( 'css/pwa-admin-min.css', __FILE__ ),
        array(),
        $plugin_version
    );

    // Enqueue admin script
    wp_enqueue_script(
        'pwa-script',
        plugins_url( 'js/pwa.js', __FILE__ ),
        array( 'jquery', 'media-upload', 'thickbox', 'wp-color-picker' ),
        $plugin_version,
        true
    );

    // Enqueue WP native styles
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'thickbox' );

    /* Check if .htaccess file is writable */
    require_once ABSPATH . 'wp-admin/includes/file.php';

    global $wp_filesystem;
    if ( ! is_object( $wp_filesystem ) ) {
        WP_Filesystem();
    }

    $htaccess_writeable = '0';
    $htaccess_path      = str_replace( '/wp-admin/', '/', getcwd() ) . '/.htaccess';

    if ( $wp_filesystem->exists( $htaccess_path ) && $wp_filesystem->is_writable( $htaccess_path ) ) {
        $htaccess_writeable = '1';
    }

    // Use sanitize_text_field for IP
    $local_ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
    $pwa_active = get_option( 'pwa_active' );
    $url        = admin_url( 'options-permalink.php' );

    wp_localize_script(
        'pwa-script',
        'pwa_admin_object',
        array(
            'st' => $pwa_active,
            'ip' => $local_ip,
            'ht' => $htaccess_writeable,
            'ur' => $url,
        )
    );
}
endif;

add_action( 'admin_enqueue_scripts', 'init_pwa_admin_scripts' );



// Add Check if permalinks are set on plugin activation
register_activation_hook( __FILE__, 'is_permalink_activate' );
if(!function_exists('is_permalink_activate')):
function is_permalink_activate() {
    //add notice if user needs to enable permalinks
    if (! get_option('permalink_structure') )
        add_action('admin_notices', 'permalink_structure_admin_notice');
}
endif;
if(!function_exists('permalink_structure_admin_notice')):
function permalink_structure_admin_notice(){
    echo ('<div id="message" class="error"><p>Please Make sure to enable <a href="options-permalink.php">Permalinks</a>.</p></div>');
}
endif;
/** register_install_hook */
if( function_exists('register_install_hook') ){
register_uninstall_hook(__FILE__,'init_install_pwa_plugins'); 
}
//flush the rewrite
if(!function_exists('init_install_pwa_plugins')):
function init_install_pwa_plugins(){
	  flush_rewrite_rules();
}
endif; 
/** register_uninstall_hook */
/** Delete exits options during disable the plugins */
if( function_exists('register_uninstall_hook') ){
   register_uninstall_hook(__FILE__,'flush_rewrite_rules');
   register_uninstall_hook(__FILE__,'init_uninstall_pwa_plugins');   
}
//Delete all options after uninstall the plugin
if(!function_exists('init_uninstall_pwa_plugins')):
function init_uninstall_pwa_plugins(){
	delete_option('pwa_active');
	delete_option('pwa_rewrite_text');	
	delete_option('pwa_restrict');	
	delete_option('pwa_logout');
	delete_option('pwa_allow_custom_users');
	delete_option('pwa_logo_path');
	delete_option('pwa_login_page_bg_color');
	delete_option('pwa_login_page_color');
}
endif;
require dirname(__FILE__).'/pwa-class.php';
/** register_deactivation_hook */
/** Delete exits options during deactivation the plugins */
if( function_exists('register_deactivation_hook') ){
   register_deactivation_hook(__FILE__,'init_deactivation_pwa_plugins');  
}

//Delete all options after uninstall the plugin
if(!function_exists('init_deactivation_pwa_plugins')):
function init_deactivation_pwa_plugins(){
	delete_option('pwa_active');
	delete_option('pwa_logout');
	remove_action('init', 'init_pwa_admin_rewrite_rules' );
	flush_rewrite_rules();
}
endif;
/** register_activation_hook */
/** Delete exits options during disable the plugins */
if( function_exists('register_activation_hook') ){
   register_activation_hook(__FILE__,'init_activation_pwa_plugins');    
}
//Delete all options after uninstall the plugin
if(!function_exists('init_activation_pwa_plugins')):
function init_activation_pwa_plugins(){
	delete_option('pwa_logout');
   	flush_rewrite_rules();
}
endif;

add_action('admin_init','pwa_flush_rewrite_rules');
//flush_rewrite_rules after update value
if ( ! function_exists( 'pwa_flush_rewrite_rules' ) ) :
function pwa_flush_rewrite_rules() {

	// Only process on form submit
	if ( ! isset( $_POST['option_page'], $_POST['_wpnonce'] ) ) {
		return;
	}

	// Verify correct settings group
	$option_page = sanitize_text_field( wp_unslash( $_POST['option_page'] ) );
	if ( 'pwa_setting_options' !== $option_page ) {
		return;
	}

	// Capability check
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Nonce verification
	$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'pwa_setting_options-options' ) ) {
		return;
	}

	// Get plugin active status safely
	$pwa_active = isset( $_POST['pwa_active'] )
		? sanitize_text_field( wp_unslash( $_POST['pwa_active'] ) )
		: '';

	// Flush rewrite rules only when plugin is disabled
	if ( empty( $pwa_active ) ) {
		flush_rewrite_rules();
	}
}
endif;
/**
 * Replace default wp-login.php links in WordPress login/reset messages
 * Works with Protect WP Admin custom admin slug
 */
add_filter( 'gettext', 'pwa_custom_checkemail_link', 20, 3 );

function pwa_custom_checkemail_link( $translated_text, $text, $domain ) {

    // Target the exact WordPress string for "checkemail=confirm"
    if ( $text === 'Check your email for the confirmation link, then visit the login page.' ) {

        // Get Protect WP Admin custom slug
        $custom_slug = get_option( 'pwa_rewrite_text' );

        if ( ! empty( $custom_slug ) ) {
            $login_url = site_url( '/' . $custom_slug . '/' );

            // Replace the plain text login page with a clickable link
            $translated_text = sprintf(
                /* translators: %s: login URL */
                __( 'Check your email for the confirmation link, then visit the <a href="%s">login page</a>.', 'protect-wp-admin' ),
                esc_url( $login_url )
            );
        }
    }
	
	
	            // Handle session expired message
            if ( 'Your session has expired. Please log in again.' === $text ) {
                $translated_text = sprintf(
                    /* translators: %s: login URL */
                    __( 'Your session has expired. <a href="%s">Log in</a> again.', 'protect-wp-admin' ),
                    esc_url( $login_url )
                );
            }


    return $translated_text;
}

/*
* call hooks action on update
* @upgrader_process_complete
*/
add_action( 'upgrader_process_complete', 'pwa_upgrade_function',10, 2);
 
function pwa_upgrade_function( $upgrader_object, $options ) {
   
    $current_plugin_path_name = plugin_basename( __FILE__ );
 
    if ($options['action'] == 'update' && $options['type'] == 'plugin' ) {
       foreach($options['plugins'] as $each_plugin) {
          if ($each_plugin==$current_plugin_path_name) {
              
             		add_action('init', 'init_pwa_admin_rewrite_rules' );
                	flush_rewrite_rules();

          }
       }
    }
}

?>
