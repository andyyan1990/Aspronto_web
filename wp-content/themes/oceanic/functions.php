<?php
/**
 * oceanic functions and definitions
 *
 * @package oceanic
 */
define( 'OCEANIC_THEME_VERSION' , '1.0.11' );

if ( ! function_exists( 'oceanic_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function oceanic_theme_setup() {
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}
	
	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' );
	add_editor_style( $font_url );

	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,400,300' );
	add_editor_style( $font_url );
	
	add_editor_style('editor-style.css');

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on oceanic, use a find and replace
	 * to change 'oceanic' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'oceanic', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'oceanic_blog_img_side', 352, 230, true );
    }

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'oceanic' ),
        'footer' => __( 'Footer Menu', 'oceanic' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	
	// The custom header is used for the logo
	add_theme_support( 'custom-header', array(
        'default-image' => '',
		'width'         => 280,
		'height'        => 91,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'oceanic_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    add_theme_support( 'title-tag' );
	
	add_theme_support( 'woocommerce' );
}
endif; // oceanic_theme_setup
add_action( 'after_setup_theme', 'oceanic_theme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function oceanic_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'oceanic' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
	
	register_sidebar(array(
		'name' => __( 'Oceanic Footer', 'oceanic' ),
		'id' => 'oceanic-site-footer',
        'description' => __( 'The footer will divide into however many widgets are put here.', 'oceanic' )
	));
}
add_action( 'widgets_init', 'oceanic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function oceanic_theme_scripts() {
    wp_enqueue_style( 'oceanic-google-body-font-default', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic', array(), OCEANIC_THEME_VERSION );
    wp_enqueue_style( 'oceanic-google-heading-font-default', '//fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,400,300', array(), OCEANIC_THEME_VERSION );
    
	wp_enqueue_style( 'oceanic-font-awesome', get_template_directory_uri().'/includes/font-awesome/css/font-awesome.css', array(), '4.2.0' );
	wp_enqueue_style( 'oceanic-style', get_stylesheet_uri(), array(), OCEANIC_THEME_VERSION );
    wp_enqueue_style( 'oceanic-woocommerce-style', get_template_directory_uri().'/templates/css/oceanic-woocommerce-style.css', array(), OCEANIC_THEME_VERSION );
	
	if ( get_theme_mod( 'oceanic-header-layout', false ) == 'oceanic-header-layout-centered' ) {
		wp_enqueue_style( 'oceanic-header-centered-style', get_template_directory_uri().'/templates/css/oceanic-header-centered.css', array(), OCEANIC_THEME_VERSION );
	} else {
		wp_enqueue_style( 'oceanic-header-standard-style', get_template_directory_uri().'/templates/css/oceanic-header-standard.css', array(), OCEANIC_THEME_VERSION );
	}

	wp_enqueue_script( 'oceanic-navigation', get_template_directory_uri() . '/js/navigation.js', array(), OCEANIC_THEME_VERSION, true );
	wp_enqueue_script( 'oceanic-caroufredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), OCEANIC_THEME_VERSION, true );
	
	wp_enqueue_script( 'oceanic-customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'), OCEANIC_THEME_VERSION, true );

	wp_enqueue_script( 'oceanic-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), OCEANIC_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'oceanic_theme_scripts' );

// Add the favicon to the header if set
function oceanic_site_favicon() {
    if ( get_theme_mod( 'oceanic-favicon', false ) ) :
        echo '<link rel="icon" href="' . esc_url( get_theme_mod( 'oceanic-favicon' ) ) . '">';
    endif;
}
add_action('wp_head', 'oceanic_site_favicon');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/inc/jetpack.php';

// Helper library for the theme customizer.
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';

// Define options for the theme customizer.
require get_template_directory() . '/customizer/customizer-options.php';

// Output inline styles based on theme customizer selections.
require get_template_directory() . '/customizer/styles.php';

// Additional filters and actions based on theme customizer selections.
require get_template_directory() . '/customizer/mods.php';

/**
 * Enqueue oceanic custom customizer styling.
 */
function oceanic_load_customizer_script() {
    wp_enqueue_script( 'oceanic-customizer-js', get_template_directory_uri() . '/customizer/customizer-library/js/customizer-custom.js', array('jquery'), OCEANIC_THEME_VERSION, true );
    
    wp_enqueue_style( 'oceanic-customizer-css', get_template_directory_uri() . '/customizer/customizer-library/css/customizer.css' );
}    
add_action( 'customize_controls_enqueue_scripts', 'oceanic_load_customizer_script' );

/* Display the recommended plugins notice that can be dismissed */
add_action('admin_notices', 'oceanic_recommended_plugin_notice');

function oceanic_recommended_plugin_notice() {
    global $pagenow;
    global $current_user;
    
    $user_id = $current_user->ID;
    
    /* If on plugins page, check that the user hasn't already clicked to ignore the message */
    if ( $pagenow == 'plugins.php' ) {
	    if ( ! get_user_meta( $user_id, 'oceanic_recommended_plugin_ignore_notice' ) ) {
	        echo '<div class="updated"><p>';
            printf( __('<p>Install the plugins <a href="http://www.freelancelot.co.za/" target="_blank">Freelancelot</a> recommends | <a href="%1$s">Hide Notice</a></p>', 'oceanic'), '?oceanic_recommended_plugin_nag_ignore=0' ); ?>
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'WooCommerce', 'oceanic' ), 'WordPress' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'Page Builder by SiteOrigin', 'oceanic' ), 'WordPress' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'Meta Slider', 'oceanic' ), 'WordPress' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'Contact Form 7', 'oceanic' ), 'WordPress' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'Breadcrumb NavXT', 'oceanic' ), 'WordPress' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=ifreelancelot'); ?>"><?php printf( __( 'Hupso Share Buttons for Twitter, Facebook & Google+', 'oceanic' ), 'WordPress' ); ?></a>
            <?php
	        echo "</p></div>";
	    }
	}
}
add_action('admin_init', 'oceanic_recommended_plugin_nag_ignore');

function oceanic_recommended_plugin_nag_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
        
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['oceanic_recommended_plugin_nag_ignore']) && '0' == $_GET['oceanic_recommended_plugin_nag_ignore'] ) {
        add_user_meta( $user_id, 'oceanic_recommended_plugin_ignore_notice', 'true', true );
    }
}

// Create function to check if WooCommerce exists.
if ( ! function_exists( 'oceanic_is_woocommerce_activated' ) ) :
    
function oceanic_is_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
}

endif; // oceanic_is_woocommerce_activated

if ( oceanic_is_woocommerce_activated() ) {
    require get_template_directory() . '/includes/inc/woocommerce-inc.php';
}

/**
 * Adjust is_home query if oceanic-slider-cats is set
 */
function oceanic_set_blog_queries( $query ) {
    
    $slider_cats = get_theme_mod( 'oceanic-slider-cats', false );
    
    if ( $slider_cats ) {
	    $slider_cats = explode(',', esc_html( $slider_cats ));
	    $slider_cat_ids = array();
	    
	    for ($i=0; $i<count($slider_cats); ++$i) {
	    	$cat_id = get_cat_ID( $slider_cats[$i] );
	    	if ($cat_id > 0) $slider_cat_ids[$i] = $cat_id;
	    }
	    
	    if ( count($slider_cat_ids) > 0) {
	        // do not alter the query on wp-admin pages and only alter it if it's the main query
	        if ( !is_admin() && !is_front_page() || is_front_page() && $query->get('id') != 'slider' ){
                $query->set( 'category__not_in', $slider_cat_ids );
	        }
	    }
	}
	    
}
add_action( 'pre_get_posts', 'oceanic_set_blog_queries' );

function filter_recent_posts_widget_parameters( $params ) {

	$slider_cats = get_theme_mod( 'oceanic-slider-cats', false );

	if ( $slider_cats ) {
		$slider_cats = explode(',', esc_html( $slider_cats ));
		$slider_cat_ids = array();
		 
		for ($i=0; $i<count($slider_cats); ++$i) {
			$cat_id = get_cat_ID( $slider_cats[$i] );
			if ($cat_id > 0) $slider_cat_ids[$i] = $cat_id;
		}
		 
		if ( count($slider_cat_ids) > 0) {
			// do not alter the query on wp-admin pages and only alter it if it's the main query
			$params['category__not_in'] = $slider_cat_ids;
		}
	}
	
	return $params;
}
add_filter('widget_posts_args','filter_recent_posts_widget_parameters');

/**
 * Adjust the widget categories query if oceanic-slider-cats is set
 */
function oceanic_set_widget_categories_args($args){
	$slider_cats = get_theme_mod( 'oceanic-slider-cats', false );
	
	if ( $slider_cats ) {
		$slider_cats = explode(',', esc_html( $slider_cats ));
		$slider_cat_ids = array();
		 
		for ($i=0; $i<count($slider_cats); ++$i) {
			$cat_id = get_cat_ID( $slider_cats[$i] );
			if ($cat_id > 0) $slider_cat_ids[$i] = $cat_id;
		}
		 
		if ( count($slider_cat_ids) > 0) {
			$exclude = implode(',', $slider_cat_ids);
			$args['exclude'] = $exclude;
		}
	}

	return $args;
}
add_filter('widget_categories_args', 'oceanic_set_widget_categories_args');

function oceanic_set_widget_categories_dropdown_arg($args){
	$slider_cats = get_theme_mod( 'oceanic-slider-cats', false );
	
	if ( $slider_cats ) {
		$slider_cats = explode(',', esc_html( $slider_cats ));
		$slider_cat_ids = array();
			
		for ($i=0; $i<count($slider_cats); ++$i) {
			$cat_id = get_cat_ID( $slider_cats[$i] );
			if ($cat_id > 0) $slider_cat_ids[$i] = $cat_id;
		}
			
		if ( count($slider_cat_ids) > 0) {
			$exclude = implode(',', $slider_cat_ids);
			$args['exclude'] = $exclude;
		}
	}
	
	return $args;
}
add_filter('widget_categories_dropdown_args', 'oceanic_set_widget_categories_dropdown_arg');

/**
* Display the upgrade to Premium page & load styles.
*
* @action admin_menu
*/
function oceanic_premium_admin_menu() {
   global $oceanic_upgrade_page;
   $oceanic_upgrade_page = add_theme_page( __( 'Oceanic Premium', 'oceanic' ), __( 'Oceanic Premium', 'oceanic' ), 'edit_theme_options', 'premium_upgrade', 'oceanic_upgrade_page_render' );
}

add_action( 'admin_menu', 'oceanic_premium_admin_menu' );

/**
* Render the theme upgrade page
*/
function oceanic_upgrade_page_render() {
   locate_template( 'upgrade/freelancelot-upgrade-page.php', true, false );
}

/**
* Enqueue Oceanic admin stylesheet only on upgrade page.
*/
function oceanic_load_admin_style($hook) {
   global $oceanic_upgrade_page;

   if( $hook != $oceanic_upgrade_page )
       return;
   
   wp_enqueue_style( 'oceanic-upgrade-css', get_template_directory_uri() . '/upgrade/css/freelancelot-admin.css' );
}    
add_action( 'admin_enqueue_scripts', 'oceanic_load_admin_style' );
