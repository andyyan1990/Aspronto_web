<?php
/**
 * Configuration file for theme option sections
 *   Section Typography, its fields and the default settings
 * 
 * @package Windflaw
 * @link    http://www.loftocean.com/
 * @author	Suihai Huang from Loft Ocean Team
 * @since version 1.0
 */

if(!function_exists('windflaw_option_section_typography') && !function_exists('windflaw_option_fields_of_section_typography') && !function_exists('windflaw_option_settings_of_section_typography')){
	add_filter('windflaw_option_sections', 'windflaw_option_section_typography', 20);
    /**
     * @description hook callback function to register the theme option section Typography
     * @param array $sections
     * @return array merge the Typography section to the array passed by
     */
	function windflaw_option_section_typography($sections = array()){
		return array_merge((array)$sections, array('typography' => array(
			'title' => esc_html__('Typography',  'windflaw-lite'),
			'description' => '',
            'active_callback' => ''
		)));
	}
	add_filter('windflaw_option_fields_of_section_typography', 'windflaw_option_fields_of_section_typography');
    /**
     * @description hook callback function to register the fields of theme option section Styles_Typography
     * @param array $fields
     * @return array merge the Styles_Typography section fields to the array passed by
     */
	function windflaw_option_fields_of_section_typography($fields = array()){
		require_once('google-fonts.php');
		return array_merge((array)$fields, array(
			'windflaw_option_google_font_heading' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Headings - Google Font', 'windflaw-lite'),
					'choices' => $windflaw_googleFonts,
					'settings' => 'windflaw_option_google_font_heading'
				)
			),
			'windflaw_option_websafe_font_heading' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Headings - web safe font', 'windflaw-lite'),
					'choices' => $windflaw_webSafeFonts,
					'settings' => 'windflaw_option_websafe_font_heading'
				)
			),
			'windflaw_option_google_font_body_text' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Body Text - Google Font', 'windflaw-lite'),
					'choices' =>  $windflaw_googleFonts,
					'settings' => 'windflaw_option_google_font_body_text'
				)
			),
			'windflaw_option_websafe_font_body_text' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Body Text - web safe font', 'windflaw-lite'),
					'choices' => $windflaw_webSafeFonts,
					'settings' => 'windflaw_option_websafe_font_body_text'
				)
			),
			'windflaw_option_google_font_text_logo' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Site Title - Google Font', 'windflaw-lite'),
					'choices' => $windflaw_googleFonts,
					'settings' => 'windflaw_option_google_font_text_logo'
				)
			),
			'windflaw_option_websafe_font_text_logo' => array(
				'type' => 'select',
				'args' => array(
					'type' => 'select',
					'label' => esc_html__('Site Title - web safe font', 'windflaw-lite'),
					'choices' => $windflaw_webSafeFonts,
					'settings' => 'windflaw_option_websafe_font_text_logo'
				)
			)
		));
	}
	add_filter('windflaw_option_settings', 'windflaw_option_settings_of_section_typography');
    /**
     * @description hook callback function to set the default values of theme option section Styles_Typography
     * @param array $settings
     * @return array merge the Styles_Typography section values to the array passed by
     */
	function windflaw_option_settings_of_section_typography($settings){
		return array_merge((array)$settings, array('typography' => array(
			'windflaw_option_google_font_heading' => array(
				'default' => 'Abel',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			),
			'windflaw_option_websafe_font_heading' => array(
				'default' => 'Arial, Helvetica, sans-serif',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			),
			'windflaw_option_google_font_body_text' => array(
				'default' => 'Lato',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			),
			'windflaw_option_websafe_font_body_text' => array(
				'default' => 'Arial, Helvetica, sans-serif',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			),
			'windflaw_option_google_font_text_logo' => array(
				'default' => 'Abel',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			),
			'windflaw_option_websafe_font_text_logo' => array(
				'default' => 'Arial, Helvetica, sans-serif',
				'transport' => 'refresh',
				'sanitize_callback' => 'windflaw_sanitize_choices'
			)
		)));
	}
	/**
	* @description generate the custom css for typography
	*/
	add_filter('windflaw_option_custom_css', 'windflaw_option_custom_css_typography');
	function windflaw_option_custom_css_typography($style){
		$google_heading = esc_attr(get_theme_mod('windflaw_option_google_font_heading', 'Abel'));
		$websafe_heading = esc_attr(get_theme_mod('windflaw_option_websafe_font_heading', 'Arial, Helvetica, sans-serif'));
		$google_body = esc_attr(get_theme_mod('windflaw_option_google_font_body_text', 'Lato'));
		$websafe_body = esc_attr(get_theme_mod('windflaw_option_websafe_font_body_text', 'Arial, Helvetica, sans-serif'));
		$google_logo = esc_attr(get_theme_mod('windflaw_option_google_font_text_logo', 'Abel'));
		$websafe_logo = esc_attr(get_theme_mod('windflaw_option_websafe_font_text_logo', 'Arial, Helvetica, sans-serif'));

		$style .= "\n";
		$style .= windflaw_generate_css('h1, h2, h3, h4, h5, h6, blockquote p, .post-title', 'font-family', ($google_heading . ', ' . $websafe_heading)) . "\n";
		$style .= windflaw_generate_css('body, button, input, select, textarea, .ui-widget', 'font-family', ($google_body . ', ' . $websafe_body)) . "\n";
		$style .= windflaw_generate_css('.header .logo.text-logo', 'font-family',  ($google_logo . ', ' . $websafe_logo)) . "\n";

		return $style;
	}
}