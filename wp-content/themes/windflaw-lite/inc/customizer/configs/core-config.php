<?php
/**
 * Configuration file for theme option sections
 *   WP Core customization section modification
 * 
 * @package Windflaw
 * @link    http://www.loftocean.com/
 * @author	Suihai Huang from Loft Ocean Team
 * @since version 1.0
 */

// Title_tagline section
if(!function_exists('windflaw_option_custom_css_title_tagline')){
	add_filter('windflaw_option_custom_css', 'windflaw_option_custom_css_title_tagline');
	function windflaw_option_custom_css_title_tagline($style){
		$display_header_text = display_header_text();
		$style .= windflaw_generate_css('p.site-description', 'display', ($display_header_text ? 'block' : 'none'));

		return $style;
	}
}

// Image Header section
if(!function_exists('windflaw_option_section_header_image') && !function_exists('windflaw_option_fields_of_section_header_image') && !function_exists('windflaw_option_settings_of_section_header_image')){
	add_filter('windflaw_option_sections', 'windflaw_option_section_header_image', 10);
	function windflaw_option_section_header_image($sections = array()){
		return array_merge((array)$sections, array('header_image' => array()));
	}
	add_filter('windflaw_option_fields_of_section_header_image', 'windflaw_option_fields_of_section_header_image');
	function windflaw_option_fields_of_section_header_image($fields = array()){
		return array_merge((array)$fields, array(
			'windflaw_option_site_logo_width' => array(
				'type' => 'number',
				'args' => array(
					'type' => 'number',
					'label' => esc_html__('Site logo width', 'windflaw-lite'),
					'settings' => 'windflaw_option_site_logo_width',
					'input_attrs' => array('after' => ' px'),
					'priority' => 5
				)
			),
			'windflaw_option_site_header_color_scheme' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Site header color scheme', 'windflaw-lite'),
					'choices' => array(
						'light' => esc_html__('Light', 'windflaw-lite'),
						'dark' => esc_html__('Dark', 'windflaw-lite')
					),
					'settings' => 'windflaw_option_site_header_color_scheme',
					'priority' => 6
				)
			)
		));
	}
	add_filter('windflaw_option_settings', 'windflaw_option_settings_of_section_header_image');
	function windflaw_option_settings_of_section_header_image($settings){
		return array_merge((array)$settings, array('header_image' => array(
			'windflaw_option_site_logo_width' => array(
				'default' => '100',
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint', 
			),
			'windflaw_option_site_header_color_scheme' => array(
				'default' => 'dark',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			)
		)));
	}
}

// Background section
if(!function_exists('windflaw_option_section_background') && !function_exists('windflaw_option_fields_of_section_background') && !function_exists('windflaw_option_settings_of_section_background')){
	add_filter('windflaw_option_sections', 'windflaw_option_section_background', 10);
	function windflaw_option_section_background($sections = array()){
		return array_merge((array)$sections, array('background_image' => array()));
	}
	add_filter('windflaw_option_fields_of_section_background_image', 'windflaw_option_fields_of_section_background');
	function windflaw_option_fields_of_section_background($fields = array()){
		return array_merge((array)$fields, array(
			'windflaw_option_background_size' => array(
				'type' => 'radio',
				'args' => array(
					'label' => esc_html__('Background Size', 'windflaw-lite'),
					'type' => 'radio',
					'settings' => 'windflaw_option_background_size',
					'choices' => array(
						'auto' => esc_html__('Auto', 'windflaw-lite'),
						'cover' => esc_html__('Cover', 'windflaw-lite')
					),
					'priority' => 50
				)
			)
		));
	}
	add_filter('windflaw_option_settings', 'windflaw_option_settings_of_section_background');
	function windflaw_option_settings_of_section_background($settings){
		return array_merge((array)$settings, array('background_image' => array(
			'windflaw_option_background_size' => array(
				'default' => 'auto',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			)
		)));
	}
}