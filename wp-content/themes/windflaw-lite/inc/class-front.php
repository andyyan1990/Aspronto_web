<?php
/**
* @package Windflaw
* @author  Suihai Huang From Loft.Ocean team
* @author URI: http://www.loftocean.com
* @since version 1.0.0
*/

/*
* Main front end class
*/

if(!class_exists('Windflaw_Front')){
	$windflaw_mobile_detect = new Mobile_Detect();
	$windflaw_image_sizes = array(
		'phone' 	=> array('default' => array('width' => 480, 	'height' => 999999), 	'retina' => array('width' => 960, 	'height' => 999999)),
		'tablet' 	=> array('default' => array('width' => 1024, 	'height' => 999999), 	'retina' => array('width' => 1440, 	'height' => 999999)),
		'computer' 	=> array('default' => array('width' => 1440, 	'height' => 999999), 	'retina' => array('width' => 2880, 	'height' => 999999))
	);
	$windflaw_device = $windflaw_mobile_detect->isMobile() ? ($windflaw_mobile_detect->isTablet() ? 'tablet' : 'phone') : 'computer';
	define('WINDFLAW_BG_IMAGE_WIDTH', $windflaw_image_sizes[$windflaw_device]['default']['width']);
	define('WINDFLAW_BG_IMAGE_HEIGHT', $windflaw_image_sizes[$windflaw_device]['default']['height']);
	define('WINDFLAW_RETINA_BG_IMAGE_WIDTH', $windflaw_image_sizes[$windflaw_device]['retina']['width']);
	define('WINDFLAW_RETINA_BG_IMAGE_HEIGHT', $windflaw_image_sizes[$windflaw_device]['retina']['height']);

	class Windflaw_Front{
		function __construct(){
			add_filter('body_class', 			array($this, 'body_class'), 999);
			add_filter('post_class', 			array($this, 'post_class'), 999);
			add_filter('excerpt_more', 			array($this, 'excerpt_more'));
			add_filter('get_the_excerpt', 		array($this, 'get_excerpt'), 100);
			add_action('wp_enqueue_scripts', 	array($this, 'front_scripts_styles')); // Enqueue scripts for front end
			add_action('windflaw_site_header', 	array($this, 'site_header'));
			add_action('windflaw_site_footer', 	array($this, 'site_footer'));
			add_action('windflaw_archive_page_header', array($this, 'archive_page_header'));
		}
		/**
		 * @description register and enqueue scripts for front end display
		 */
		public function front_scripts_styles(){
			$google_fonts = array(
				get_theme_mod('windflaw_option_google_font_heading', 'Abel')	. ':100,200,300,400,500,600,700,800',
				get_theme_mod('windflaw_option_google_font_body_text', 'Lato') 	. ':100,200,300,400,500,600,700,800',
				get_theme_mod('windflaw_option_google_font_text_logo', 'Abel') 	. ':100,200,300,400,500,600,700,800'
			);

			wp_enqueue_script('jquery-fitvids', WINDFLAW_THEME_JS_URI . 'libs/jquery.fitvids.min.js', array('jquery'), '1.1', true);
			wp_register_script('windflaw-main', WINDFLAW_THEME_JS_URI . 'front/windflaw-main.js', array('jquery-fitvids'), WINDFLAW_THEME_VERSION, true);
			wp_localize_script('windflaw-main', 'screenReaderText', array(
				'expand' => esc_js(__('expand child menu', 'windflaw-lite')),
				'collapse' => esc_js(__('collapse child menu', 'windflaw-lite'))
			));
			wp_enqueue_script('windflaw-main');

			wp_register_script('jquery-touch-swipe', WINDFLAW_THEME_JS_URI  . 'libs/jquery.touchSwipe.min.js', array('jquery'), '1.6.18');
			wp_is_mobile() ? wp_enqueue_script('jquery-touch-swipe') : '';

			wp_enqueue_script('modernizr', WINDFLAW_THEME_JS_URI . 'libs/modernizr.min.js', array(), '2.8.3');
			// Load the html5 shiv.
			wp_enqueue_script('html5shiv', WINDFLAW_THEME_JS_URI . 'libs/html5shiv.min.js', array(), '3.7.3');
			wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');	

			// Add Google font in safe way. Refer to https://gist.github.com/richtabor/b85d317518b6273b4a88448a11ed20d3
			if(!empty($google_fonts)){
				$fonts_url = 
				wp_enqueue_style(
					'google-font',
					add_query_arg(array('family' => urlencode(implode('|', array_unique($google_fonts)))), 'https://fonts.googleapis.com/css'),
					array(), 
					WINDFLAW_THEME_VERSION
				);
			}
			wp_enqueue_style('windflaw-front', get_stylesheet_uri(), array(), WINDFLAW_THEME_VERSION);
			wp_enqueue_style('awsomefont', WINDFLAW_THEME_URI . 'assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0');
			is_rtl() ? wp_enqueue_style('windflaw-rtl', WINDFLAW_THEME_URI . 'rtl.css', array(), WINDFLAW_THEME_VERSION) : '';

			wp_add_inline_style('windflaw-front', apply_filters('windflaw_option_custom_css', ''));
		}
		/**
		* @description add theme special body classes
		*/
		public function body_class($class){
			$header_scheme = esc_attr(get_theme_mod('windflaw_option_site_header_color_scheme', 'dark')) . '-header';
			$new_classes = array('content-layout-default', $header_scheme);
			is_singular('post') ? array_push($new_classes, 'single-blog') : ''; // Single post page
			is_search() ? array_push($new_classes, 'search-result') : ''; // Search result page
			return array_merge((array)$class, $new_classes);
		}
		/**
		* @description remove hentry related post class
		*/
		public function post_class($class){
			return array_diff($class, array('hentry', 'h-entry'));
		}
		/**
		* @description show site header
		*/
		public function site_header(){
			if(!is_page_template('template-no-header-footer.php')){ ?>

			<header id="masthead" class="site-header header<?php echo has_nav_menu('primary') ? '' : ' no-menu'; ?>" role="banner" <?php if(get_header_image() != '') { echo 'style="background-image: url(' . esc_url(get_header_image()) . ');"'; } ?>>
				<div class="container">
					<?php if(get_theme_mod('custom_logo')) : ?>
						<div id="site-logo" class="logo img-logo"><?php windflaw_the_custom_logo(); ?></div>
					<?php else : ?>
						<div id="site-logo" class="logo text-logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
						</div>
					<?php endif; ?>
					<p class="site-description"><?php echo bloginfo('description'); ?></p>
					<?php if(has_nav_menu('primary')) : ?>
					<button id="menu-toggle" class="menu-toggle"><?php esc_html_e('Menu', 'windflaw-lite'); ?></button>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'primary',
							'container'       => 'nav',
							'container_class' => 'nav main-navigation',
							'container_id'    => 'site-navigation',
							'menu_class'      => '',
							'menu_id'         => '',
							'depth'           => 3,
							'items_wrap'      => '<ul>%3$s</ul>',
						));
					?>
					<?php endif; ?>
				</div><!-- .container -->
			</header><!-- .site-header --> <?php

			}
		}
		/**
		* @description show site footer
		*/
		public function site_footer(){
			if(!is_page_template('template-no-header-footer.php')) :
?>
			<footer class="footer <?php echo esc_attr(get_option('windflaw_theme_colors_scheme', 'light')); ?>-color-scheme" id="site-footer">
				<?php get_sidebar(); ?>
				<?php
					if(has_nav_menu('social')){
						wp_nav_menu(array(
							'theme_location' 	=> 'social',
							'container' 		=> 'div',
							'container_class' 	=> 'footer-social-navigation',
							'container_id' 		=> 'footer-social-navigation',
							'menu_class' 		=> '',
							'menu_id' 			=> '',
							'depth' 			=> 1,
							'items_wrap' 		=> '<ul>%3$s</ul>',
						));
					}
				?>
				<div class="site-info">&copy; <?php echo esc_html(get_bloginfo('name')) . ' ' . date('Y'); ?>. <?php printf(__('Windflaw designed by %sLoft.Ocean.%s', 'windflaw-lite'), '<a href="' . esc_url('https://www.loftocean.com'). '" title="' . esc_attr__('WordPress Themes by Loft.Ocean', 'windflaw-lite') . '">', '</a>'); ?></div>
			</footer>
			<?php endif; ?>
			<a href="#" class="to-top"><i class="fa fa-chevron-up"></i></a>
<?php
		}
		/**
		* @description show archive page header
		*/
		public function archive_page_header(){
			if(is_author()){
				$author = windflaw_get_author_info();
				echo '<aside class="author-bio">';
				echo '<div class="author-bio-inner">';
				echo !empty($author['image']) ? '<div class="author-photo">' . $author['image'] . '</div>' : '';
				echo '<div class="author-info">';
				echo '<span class="author-tag">' . esc_html__('Author', 'windflaw-lite') . '</span>';
				echo '<h4>' . esc_html($author['name']) . '</h4>';
				echo !empty($author['bio']) ? $author['bio'] : '';
				echo '</div>';
				echo '</div>';
				echo '</aside>';
			}
			else if(is_search() || is_archive()){
				global $wp_query;
				$founded = $wp_query->found_posts;
				echo '<header class="page-header ' . esc_attr(get_option('windflaw_theme_colors_scheme', 'light')) . '-page-header align-default">';
				echo '<div class="container">';
				if(is_search()){
					echo '<h3 class="page-title">' . esc_html__('Search Result', 'windflaw-lite') . '</h3>';
					echo '<p>' . sprintf(_n('%s Result for: ', '%s Results for: ', $founded, 'windflaw-lite'), $founded) . '<strong>' . esc_html(get_search_query()) . '</strong></p>';
				}
				else if(is_date()){
					$title = is_year() ? esc_html__('Yearly Archive', 'windflaw-lite')
						: (is_month() ? esc_html__('Monthly Archive', 'windflaw-lite') : esc_html__('Daily Archive', 'windflaw-lite'));

					echo '<h3 class="page-title">' . $title . '</h3>';
					echo '<p>' . sprintf(_n('%s Entry in: ', '%s Entries in: ', $founded, 'windflaw-lite'), $founded) . '<strong>';
					echo is_year() ? get_the_date(_x('Y', 'yearly archives date format', 'windflaw-lite'))
						: (is_month() ? get_the_date(_x('F Y', 'monthly archives date format', 'windflaw-lite')) : get_the_date(_x('F j, Y', 'daily archives date format', 'windflaw-lite')));

					echo '</strong></p>';
				}
				else{
					$title = is_category() ? esc_html__('Category', 'windflaw-lite')
						: (is_tag() ? esc_html__('Tag Archive', 'windflaw-lite') : __('Archive', 'windflaw-lite'));
					$term  = $wp_query->get_queried_object();
					echo '<h3 class="page-title">' . $title . '</h3>';
					echo '<p>' . sprintf(esc_html(_n('%s Entry in: ', '%s Entries in: ', $founded, 'windflaw-lite')), $founded) . '<strong>';
					echo esc_html($term->name);
					echo '</strong></p>';
				}
				echo '</div>';
				echo '</header>';
			}
		}
		/**
		* @description move wp_link_pages after read more
		*   Not show wp_link_page in search result page
		*/
		public function get_excerpt($excerpt){
			$link = is_search() ? '' : wp_link_pages(array(
				'next_or_number' => 'number',
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'windflaw-lite') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'echo' => 0
			));
			return preg_match('/\[\[wp-link-page\]\]/', $excerpt) ? preg_replace('/\[\[wp-link-page\]\]/', $link, $excerpt) : ($excerpt . $link);
		}
		/**
		* @descirption add custom excerpt more string
		*/
		public function excerpt_more(){
			return ' [...][[wp-link-page]]<div class="more-link-wrapper"><a class="more-link" href="' . get_permalink() . '">' . esc_html__('Read More', 'windflaw-lite') . '</a></div>';
		}
		// Helper functions below

		/**
		 * @description get the author meta.
		 */
		static function get_author_meta(){
			$author = windflaw_get_author_info();
			return '<a href="' . esc_url($author['url']) . '" title="' . esc_attr($author['name']) . '"><span class="author-name">' . esc_html($author['name']) . '</span></a>';
		}
		/**
		* @description get the date meta
		*/
		static function get_date_meta(){
			return '<a href="' . get_the_permalink() .'" title="' . esc_attr(get_the_title()) . '"><time class="publish-date" datetime="' . get_the_date('Y-m-d') . '">' . get_the_date() . '</time></a>';
		}
		/**
		 * @description get the taxonomy list.
		 */
		static function get_taxonomy_meta(){
			$categories = windflaw_get_taxonomy_list(true);
			return !empty($categories) ? ('<div class="categories">' . $categories . '</div>') : '';
		}
		/**
		 * @description get comment meta for post only. 
		 */
		static function get_comment_meta($text = false){
			$number = get_comments_number();
			if(($number > 0) || comments_open()){
				global $post;
				$url = $text ? '' : trailingslashit(get_permalink($post->ID));
				$commentText = ($number < 1) ? esc_html__('no comment', 'windflaw-lite') : sprintf(esc_html(_n('%d comment', '%d comments', $number, 'windflaw-lite')), $number);
				return '<span class="comments-link"><a href="' . $url . '#comments">' . esc_html($commentText) . '</a></span>';
			}
			return false;
		}
	}
	new Windflaw_Front();
}