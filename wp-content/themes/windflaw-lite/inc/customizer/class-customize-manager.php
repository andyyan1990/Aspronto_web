<?php
/**
* @package Windflaw
* @author  Suihai Huang From Loft.Ocean team
* @link    http://www.loftocean.com
* @since   version 1.0.0
*/

/*
* Main customization class
*/

if(!class_exists('Windflaw_Customize_Manager')){
	class Windflaw_Customize_Manager{
		protected static $_instance = null; // 
		public static function init(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		function __construct(){
			add_action('customize_register', array($this, 'customize_register'), 100);
			add_action('customize_preview_init', array($this, 'customize_script'));
			add_action('customize_controls_enqueue_scripts', array($this, 'background_image_control_js'), 100);
		}
		public function customize_script(){
			wp_enqueue_script('windflaw-customize', WINDFLAW_THEME_JS_URI . 'customize/customize-preview.js', array('jquery', 'customize-preview'), '1.0.0', true);
		}
		public function background_image_control_js(){
			wp_enqueue_script('windflaw_background_size', WINDFLAW_THEME_JS_URI . 'customize/controls.js', array('customize-controls', 'iris', 'underscore', 'wp-util', 'jquery'), '20160407', true);
		}

		public function customize_register($wp_customize ){
			$wp_customize->get_setting('blogname')->transport = 'postMessage';
			$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
			$wp_customize->get_section('header_image')->title = esc_html__('Header', 'windflaw-lite');
			$wp_customize->get_section('background_image')->title = esc_html__('Background', 'windflaw-lite');

			$sections = apply_filters('windflaw_option_sections', array());
			$settings = apply_filters('windflaw_option_settings', array());
			$theme_prefix = 'windflaw_option_';
			if(!empty($sections)){
				foreach($sections as $sid => $sargs){
					$controls = apply_filters('windflaw_option_fields_of_section_' . $sid, array());
					// Register settings
					if(!empty($settings[$sid])){
						foreach($settings[$sid] as $id => $args){
							$sanitize = isset($args['sanitize_callback']) ? $args['sanitize_callback'] : '';
							$wp_customize->add_setting($id, array_merge(array('sanitize_callback' => $sanitize), $args));
						}
					}
					// Register section
					if(!empty($sargs)){
						$sid = $theme_prefix . $sid;
						$wp_customize->add_section($sid, $sargs);
					}
					// Register controls
					foreach((array)$controls as $cid => $control){
						$type = $control['type'];
						$control['args']['section'] = $sid;
						switch($type){
							case 'select':
							case 'checkbox':
							case 'radio':
								$wp_customize->add_control(new WP_Customize_Control($wp_customize, $cid, $control['args']));
								break;
							case 'number':
								$wp_customize->add_control(new Windflaw_Customize_Number_Control($wp_customize, $cid, $control['args']));
								break;
							case 'image':
								$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $cid, $control['args']));
								break;
							case 'color':
								$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $cid, $control['args']));
								break;
						}
					}
				}
			}

			$wp_customize->remove_section('colors');

			$custom_logo = $wp_customize->get_control('custom_logo');
			$custom_logo->section = 'header_image';
			$custom_logo->priority = 3;
			$custom_logo->label = esc_html__('Upload your logo image', 'windflaw-lite');

			$wp_customize->get_setting('custom_logo')->transport = 'refresh';
			$wp_customize->get_control('display_header_text')->label = esc_html__('Display Site Tagline', 'windflaw-lite');
		}
	}
	Windflaw_Customize_Manager::init();
}