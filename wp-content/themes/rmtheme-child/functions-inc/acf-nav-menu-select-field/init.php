<?php
/**
 * Registration logic for the new ACF field type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'sidebar_include_acf_field_nav_menu_select_field' );
/**
 * Registers the ACF field type.
 */
function sidebar_include_acf_field_nav_menu_select_field() {
	if ( ! function_exists( 'acf_register_field_type' ) ) {
		return;
	}

	require_once __DIR__ . '/class-sidebar-acf-field-nav-menu-select-field.php';

	acf_register_field_type( 'sidebar_acf_field_nav_menu_select_field' );
}
