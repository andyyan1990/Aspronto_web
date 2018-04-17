<?php
Corporate_Landing_Page_Kirki::add_config( 'corporate_landing_page', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod',
        'disable_output'=> true,
    ) );
/* Option list of all posts */	
	$corporate_landing_page_options_posts = array();
	$corporate_landing_page_options_posts_obj = get_posts();
	$corporate_landing_page_options_posts[''] = __( 'Choose Post', 'corporate-landing-page' );
	foreach ( $corporate_landing_page_options_posts_obj as $corporate_landing_page_posts ) {
		$corporate_landing_page_options_posts[$corporate_landing_page_posts->ID] = $corporate_landing_page_posts->post_title;
	}

/* Option list of all categories */
	$args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
	); 
	$corporate_landing_page_option_categories = array();
	$corporate_landing_page_category_lists = get_categories( $args );
	$corporate_landing_page_option_categories[''] = __( 'Choose Category', 'corporate-landing-page' );
	foreach( $corporate_landing_page_category_lists as $corporate_landing_page_category ){
		$corporate_landing_page_option_categories[$corporate_landing_page_category->term_id] = $corporate_landing_page_category->name;
	}

/**
 * Basic customizations
 */
function corporate_landing_page_homepage_customize($wp_customize) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-branding .site-title a',
			'render_callback' => 'corporate_landing_page_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'corporate_landing_page_customize_partial_blogdescription',
		) );
	}

	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @return void
	 */
	function corporate_landing_page_customize_partial_blogname() {
		bloginfo( 'name' );
	}

	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @return void
	 */

	function corporate_landing_page_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}
add_action( 'customize_register', 'corporate_landing_page_homepage_customize', 10 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function corporate_landing_page_customize_preview_js() {
	wp_enqueue_script( 'corporate_landing_page-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'corporate_landing_page_customize_preview_js' );

/**
 * Customizer List
 */
get_template_part( 'inc/customizer/customize-homepage' );
get_template_part( 'inc/customizer/general' );
get_template_part( 'inc/customizer/header' );
get_template_part( 'inc/customizer/typography' );
get_template_part( 'inc/customizer/layouts' );
get_template_part( 'inc/customizer/breadcrumb' );
get_template_part( 'inc/fontawesome/fontawesome-readable-file' );
get_template_part( 'inc/animate/animate-options-file' );
