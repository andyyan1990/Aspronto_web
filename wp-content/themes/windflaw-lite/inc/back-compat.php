<?php
/**
 * Prevents Windflaw from running on WordPress versions prior to 4.3
 *
 * @package Windflaw
 * @since version 1.0.0
 */

/**
 * Prevent switching to Windflaw on old versions of WordPress.
 * Switches to the default theme.
 */
function windflaw_switch_theme() {
	switch_theme(WP_DEFAULT_THEME, WP_DEFAULT_THEME);

	unset( $_GET['activated'] );

	add_action('admin_notices', 'windflaw_upgrade_notice');
}
add_action('after_switch_theme', 'windflaw_switch_theme');

/**
 * Adds a message for unsuccessful theme switch.
 * @global string $wp_version WordPress version.
 */
function windflaw_upgrade_notice() {
	$message = sprintf(esc_html__('Windflaw requires at least WordPress version 4.3. You are running version %s. Please upgrade and try again.', 'windflaw-lite'), $GLOBALS['wp_version']);
	printf('<div class="error"><p>%s</p></div>', $message);
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.3.
 *
 * @global string $wp_version WordPress version.
 */
function windflaw_customize() {
	wp_die( sprintf(esc_html__( 'Windflaw requires at least WordPress version 4.3. You are running version %s. Please upgrade and try again.', 'windflaw-lite'), $GLOBALS['wp_version']), '', array(
		'back_link' => true,
	));
}
add_action('load-customize.php', 'windflaw_customize');

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.3.
 *
 * @global string $wp_version WordPress version.
 */
function windflaw_preview(){
	if(isset($_GET['preview'])){
		wp_die(sprintf(esc_html__('Windflaw requires at least WordPress version 4.3. You are running version %s. Please upgrade and try again.', 'windflaw-lite'), $GLOBALS['wp_version']));
	}
}
add_action('template_redirect', 'windflaw_preview');