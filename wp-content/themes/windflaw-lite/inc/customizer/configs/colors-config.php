<?php
/**
 * Configuration file for theme option sections
 *   Section Colors, its fields and the default settings
 * 
 * @package Windflaw
 * @link    http://www.loftocean.com/
 * @author	Suihai Huang from Loft Ocean Team
 * @since version 1.0
 */

if(!function_exists('windflaw_option_section_theme_colors') && !function_exists('windflaw_option_fields_of_section_theme_colors') && !function_exists('windflaw_option_settings_of_section_theme_colors')){
	add_filter('windflaw_option_sections', 'windflaw_option_section_theme_colors', 70);
    /**
     * @description hook callback function to register the theme option section Colors
     * @param array $sections
     * @return array merge the Colors section to the array passed by
     */
	function windflaw_option_section_theme_colors($sections = array()){
		return array_merge((array)$sections, array('theme_colors' => array(
			'title' => esc_html__('Colors',  'windflaw-lite'),
			'description' => '',
            'active_callback' => ''
		)));
	}
	add_filter('windflaw_option_fields_of_section_theme_colors', 'windflaw_option_fields_of_section_theme_colors');
    /**
     * @description hook callback function to register the fields of theme option section Colors
     * @param array $fields
     * @return array merge the Colors section fields to the array passed by
     */
	function windflaw_option_fields_of_section_theme_colors($fields = array()){
		return array_merge((array)$fields, array(
			'windflaw_theme_colors_scheme' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Basic color scheme of the site', 'windflaw-lite'),
					'choices' => array(
						'light' => esc_html__('Light', 'windflaw-lite'),
						'dark' => esc_html__('Dark', 'windflaw-lite')
					),
					'settings' => 'windflaw_theme_colors_scheme'
				)
			),
			'windflaw_option_colors_primary_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Primary color', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_primary_color'
				)
			),
			'windflaw_option_colors_light_basic_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Basic text color - Light', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_light_basic_color'
				)
			),
			'windflaw_option_colors_light_content_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Title text color - Light', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_light_title_color'
				)
			),
			'windflaw_option_colors_light_background_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Background color - Light', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_light_background_color'
				)
			),
			'windflaw_option_colors_dark_basic_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Basic text color - Dark', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_dark_basic_color'
				)
			),
			'windflaw_option_colors_dark_content_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Title text color - Dark', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_dark_title_color'
				)
			),
			'windflaw_option_colors_dark_background_color' => array(
				'type' => 'color',
				'args' => array(
					'label' => esc_html__('Background color - Dark', 'windflaw-lite'),
					'settings' => 'windflaw_theme_colors_dark_background_color'
				)
			)
		));
	}

	add_filter('windflaw_option_settings', 'windflaw_option_settings_of_section_theme_colors');
    /**
     * @description hook callback function to set the default values of theme option section Colors
     * @param array $settings
     * @return array merge the Colors section values to the array passed by
     */
	function windflaw_option_settings_of_section_theme_colors($settings){
		return array_merge((array)$settings, array('theme_colors' => array(
			'windflaw_theme_colors_scheme' => array(
				'default' => 'light',
				'sanitize_callback' => 'windflaw_sanitize_choices',
				'type' => 'option',
				'sync' => array('section' => 'overall', 'option' => 'color_scheme')
			),
			'windflaw_theme_colors_primary_color' => array(
				'default' => '#58b88d',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'overall', 'option' => 'primary_color[color]')
			),
			'windflaw_theme_colors_light_basic_color' => array(
				'default' => '#3D454F',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'light_color_scheme[basic_color]')
			),
			'windflaw_theme_colors_light_title_color' => array(
				'default' => '#313740',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'light_color_scheme[title_text_color]')
			),
			'windflaw_theme_colors_light_background_color' => array(
				'default' => '#F7F7F7',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'light_color_scheme[background_color]')
			),
			'windflaw_theme_colors_dark_basic_color' => array(
				'default' => '#eeeeee',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'dark_color_scheme[basic_color]')
			),
			'windflaw_theme_colors_dark_title_color' => array(
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'dark_color_scheme[title_text_color]')
			),
			'windflaw_theme_colors_dark_background_color' => array(
				'default' => '#3D454F',
				'sanitize_callback' => 'sanitize_hex_color',
				'type' => 'option',
				'sync' => array('section' => 'color_scheme', 'option' => 'dark_color_scheme[background_color]')
			)
		)));
	}

	/**
	* @description generate the custom css for colors
	*/
	add_filter('windflaw_option_custom_css', 'windflaw_option_custom_css_colors');
	function windflaw_option_custom_css_colors($style){
		$primary_color = esc_attr(get_option('windflaw_theme_colors_primary_color', '#58b88d'));

		$light_basic_color = esc_attr(get_option('windflaw_theme_colors_light_basic_color', '#3d454f'));
		$light_title_color = esc_attr(get_option('windflaw_theme_colors_light_title_color', '#313740'));
		$light_bg_color = esc_attr(get_option('windflaw_theme_colors_light_background_color', '#f7f7f7'));

		$dark_basic_color = esc_attr(get_option('windflaw_theme_colors_dark_basic_color', '#eeeeee'));
		$dark_title_color = esc_attr(get_option('windflaw_theme_colors_dark_title_color', '#ffffff'));
		$dark_bg_color = esc_attr(get_option('windflaw_theme_colors_dark_background_color', '#3d454f'));

		$style .= <<<CSS
a,
.no-touch .site-header .nav ul li a:hover,
.site-header .nav ul li a:focus,
.no-touch .site-header .nav ul li.menu-item-has-children > button.dropdown-toggle:hover,
.site-header .nav ul li.menu-item-has-children > button.dropdown-toggle:focus,
.no-touch .site-header .menu-toggle:hover,
.site-header .menu-toggle:focus,
.archive .page-header .container p strong,
.search .page-header .container p strong,
.post-meta,
.author-bio .author-info h4,
.no-touch .single-blog .post-navigation .nav-links a:hover .post-title,
.no-touch #site-footer .widget a:hover {
    color: $primary_color;
}


mark,
ins,
a.more-link,
.pagination .page-numbers.current,
.no-touch .pagination a.page-numbers:hover,
.pagination a.page-numbers:focus,
.post-tag-cloud .tagcloud a,
.comments ol.comment-list li a.comment-reply-link,
#site-footer .widget.widget_calendar tbody td a,
#site-footer .widget.widget_tag_cloud .tagcloud a {
    background: $primary_color;
}

.pagination .page-numbers,
blockquote {
  border-color: $primary_color;
}

.pagination a.page-numbers {
	outline-color: $primary_color;
}

.dark-color-scheme,
.dark-page-header,
body.custom-background #main.dark-color-scheme:before {
    background-color: $dark_bg_color;
}

.light-color-scheme,
.light-page-header,
body.custom-background #main.light-color-scheme:before {
    background-color: $light_bg_color;
}

.dark-color-scheme,
.dark-page-header {
    color: $dark_basic_color;
}

.light-color-scheme,
.light-page-header {
    color: $light_basic_color;
}

.dark-color-scheme h1,
.dark-color-scheme h2,
.dark-color-scheme h3,
.dark-color-scheme h4,
.dark-color-scheme h5,
.dark-color-scheme h6 {
	color: $dark_title_color;
}

.light-color-scheme h1,
.light-color-scheme h2,
.light-color-scheme h3,
.light-color-scheme h4,
.light-color-scheme h5,
.light-color-scheme h6 {
	color: $light_title_color;
}

CSS;
		return $style;
	}
}