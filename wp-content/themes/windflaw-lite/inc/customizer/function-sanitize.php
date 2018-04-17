<?php
/**
* @package Windflaw
* @author  Suihai Huang From Loft.Ocean team
* @link    http://www.loftocean.com
* @since   version 1.0.0
*/

/**
* @description helper sanitize functions for customize apis
*/
if(!function_exists('windflaw_sanitize_checkbox')){
	function windflaw_sanitize_checkbox($input){
		return empty($input) ? false : 'on';
	}
}

if(!function_exists('windflaw_sanitize_choices')){
	function windflaw_sanitize_choices($input, $setting){
		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control($setting->id)->choices;
		
		// If the input is a valid key, return it;
		// otherwise, return the default
		return (array_key_exists($input, $choices) ? $input : $setting->default);
	}
}

if(!function_exists('windflaw_active_filter_is_single_post')){
	function windflaw_active_filter_is_single_post(){
		return is_singular('post') ? true : false;
	}
}