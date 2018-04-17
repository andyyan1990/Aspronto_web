<?php
/**
*  1. Define theme constants
*  2. Test WP core version
*  3. WP core supports
*  4. Theme helper functions
*  5. Theme customization class
*  6. Theme front class
*/

/**
* 1. Define site wide constants
*     theme name, theme version, theme root path, theme root uri, theme style files folder, theme js folder
*/
define('WINDFLAW_THEME_NAME', 'windflaw-lite');
define('WINDFLAW_THEME_VERSION', '1.1.0');
define('WINDFLAW_THEME_ROOT', get_template_directory() . '/');
define('WINDFLAW_THEME_URI', get_template_directory_uri() . '/');
define('WINDFLAW_THEME_CSS_URI', WINDFLAW_THEME_URI . 'assets/css/');
define('WINDFLAW_THEME_JS_URI', WINDFLAW_THEME_URI . 'assets/js/');

/**
 * 2. Windflaw only works in WordPress 4.3 or later.
 */
version_compare($GLOBALS['wp_version'], '4.3', '<') ? (require WINDFLAW_THEME_ROOT . 'inc/back-compat.php') : '';

/**
* 3. Sets up theme defaults and registers support for various WordPress features.
*/
if(!function_exists('windflaw_change_custom_background_cb')){
	// Change custom background css
	function windflaw_change_custom_background_cb(){
		$background = esc_url(get_background_image());
		if($background){
			$image = " background-image: url('$background');";
			$repeat = esc_attr(get_theme_mod('background_repeat', 'repeat'));
			if(!in_array($repeat, array('no-repeat', 'repeat-x', 'repeat-y', 'repeat')))
				$repeat = 'repeat';
			$repeat = " background-repeat: $repeat;";

			$position = esc_attr(get_theme_mod('background_position_x', 'left'));
			if(!in_array($position, array('center', 'right', 'left')))
				$position = 'left';
			$position = " background-position: top $position;";

			$attachment = esc_attr(get_theme_mod('background_attachment', 'scroll'));
			if(!in_array($attachment, array('fixed', 'scroll')))
				$attachment = 'scroll';
			$attachment = " background-attachment: $attachment;";

			$size = esc_attr(get_theme_mod('windflaw_option_background_size', 'auto'));
			if(!in_array($size, array('auto', 'cover')))
				$size = 'auto';
			$size = " background-size: $size";

			$style = $image . $repeat . $position . $attachment . $size;
			echo '<style type="text/css">body.custom-background #main { ' . trim( $style ) . ' } </style>';
		}
		return false;
	}
}
if(!function_exists('windflaw_wp_core_support')){
	// Add WP core support
	function windflaw_wp_core_support(){
		// Make theme available for translation.
		load_theme_textdomain('windflaw-lite');

		$GLOBALS['content_width'] = apply_filters('windflaw_content_width', 2280);

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		// Let WordPress manage the document title.
		add_theme_support('title-tag');

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1440, 9999);

		// Enable support for custom header
		add_theme_support('custom-header');
		// Enable support for custom page background
		add_theme_support('custom-background', array('wp-head-callback' => 'windflaw_change_custom_background_cb'));
		add_theme_support('custom-logo');

		add_theme_support('post-formats', array('video', 'audio'));

		// This theme uses wp_nav_menu() in one locations.
		register_nav_menus(array(
			'primary' 	=> esc_html__('Primary Menu', 'windflaw-lite'),
			'social'	=> esc_html__('Social Menu', 'windflaw-lite')
		));

		/*
		 * Switch default core markup for comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		));

		/*
		 * This theme styles the visual editor to resemble the theme style, specifically font, colors, icons, and column width.
		 */
		add_editor_style('style.css');
	}
	function windflaw_wp_sidebars(){
		// This theme uses one sidebar
		register_sidebar(array(
			'name'          => esc_html__('Footer Widget Area ', 'windflaw-lite'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here to appear in your footer main sidebar.', 'windflaw-lite'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h5>',
			'after_title'   => '</h5>'
		));
	}
	add_action('after_setup_theme', 'windflaw_wp_core_support');
	add_action('widgets_init', 'windflaw_wp_sidebars');
}


/**
*  4. Load the site wide helper functions
*/
require_once WINDFLAW_THEME_ROOT . 'inc/class-meta-box.php';
require_once WINDFLAW_THEME_ROOT . 'inc/function-global.php';

/**
*  5. Load the main class for theme customization and the configuratio files
*/
if(!class_exists('Windflaw_Customize_Manager')){
	$path = WINDFLAW_THEME_ROOT . 'inc/customizer/configs/';
	foreach(glob($path . "*-config.php") as $config){
		require_once $config;
	}
	require WINDFLAW_THEME_ROOT . 'inc/customizer/class-customize-controls.php';
	require WINDFLAW_THEME_ROOT . 'inc/customizer/class-customize-manager.php';
	require WINDFLAW_THEME_ROOT . 'inc/customizer/function-sanitize.php';
}

/**
* 6. Load the main class for theme front
*/
if(!class_exists('Windflaw_Front')){
	require_once WINDFLAW_THEME_ROOT . 'inc/Mobile_Detect.php'; // Import the mobile detect helper plugin, this is a third party code
	require_once WINDFLAW_THEME_ROOT . 'inc/class-post-list.php';
	require_once WINDFLAW_THEME_ROOT . 'inc/class-front.php';
}
