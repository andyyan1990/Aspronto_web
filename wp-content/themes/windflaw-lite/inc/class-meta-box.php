<?php
/**
* Add extra settings for post format
*/

if(!class_exists('Windflaw_Meta_Box')){
	// Add meta box/column for posts
	class Windflaw_Meta_Box {
		private $format_media = false;
		private $format_meta_name = 'windflaw-format-media';
		private $background_video = array();
		public function __construct(){
			add_action('save_post', array($this, 'save_meta'), 10, 3);

			add_filter('windflaw_background_video', array($this, 'background_video'), 10, 2);
			add_filter('windflaw_has_background_video', array($this, 'has_background_video'), 10, 2);

			add_action('admin_footer-post-new.php', array($this, 'format_meta_box'));
			add_action('admin_footer-post.php', array($this, 'format_meta_box'));
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_script'));

			add_filter('windflaw_get_post_format_media', array($this, 'get_post_format_media'));
		}
		// Enqueue script for wp admin
		public function admin_enqueue_script(){
			wp_enqueue_media();
			wp_enqueue_script('windflaw_admin_script', WINDFLAW_THEME_URI . 'assets/js/admin/meta-box.js', array('jquery'), WINDFLAW_THEME_VERSION, true);
		}
		/*
		* @description show background video
		* @param string video html string
		* @param int post id
		* @return string video html string or empty
		*/
		public function background_video($video, $pid){
			$key = 'post-' . $pid;
			if(array_key_exists($key, $this->background_video)){
				return $this->background_video[$key];
			}

			if(!empty($pid) && (false !== get_post_status($pid))){
				$p = get_post($pid);
				$p_type = $p->post_type;
				$video = '';
				if(('post' == $p_type) && ('video' == get_post_format($pid))){
					$media = get_post_meta($pid, $this->format_meta_name, true);
					$video = (is_array($media) && isset($media['video-code'])) ? $media['video-code'] : '';
				}
				$this->background_video[$key] = empty($video) ? '' : do_shortcode($video);
				return $this->background_video[$key];
			}
			return '';
		}
		/*
		* @description test if has background video
		* @param boolean current result
		* @param int post id
		* @return boolean true if background video exists
		*/
		public function has_background_video($has, $pid){
			$video = $this->background_video('', $pid);
			return !empty($video);
		}
		// Save loftloader shortcode meta
		public function save_meta($post_id, $post, $update){
			if(empty($update) || !in_array($post->post_type, array('post', 'page'))) return;

			if(wp_verify_nonce($_REQUEST['windflaw_nonce'], 'windflaw_nonce') !== false){
				if($post->post_type == 'post'){
					$format_media = empty($_REQUEST[$this->format_meta_name]) ? '' : $_REQUEST[$this->format_meta_name];
					$format_media['gallery-code'] 	= $this->sanitize_textarea($format_media, 'gallery-code');
					$format_media['gallery-id'] 	= $this->sanitize_textarea($format_media, 'gallery-id');
					$format_media['audio-code'] 	= $this->sanitize_html($format_media, 'audio-code');
					$format_media['audio-id'] 		= $this->sanitize_num($format_media, 'audio-id');
					$format_media['video-code'] 	= $this->sanitize_html($format_media, 'video-code');
					$format_media['video-id'] 		= $this->sanitize_num($format_media, 'video-id');
					$format_media['quote-text'] 	= $this->sanitize_textarea($format_media, 'quote-text');
					$format_media['quote-byline'] 	= $this->sanitize_textarea($format_media, 'quote-byline');
					$format_media['link-text'] 		= $this->sanitize_textarea($format_media, 'link-text');
					$format_media['link-url'] 		= $this->sanitize_url($format_media, 'link-url');

					update_post_meta($post_id, $this->format_meta_name, $format_media);
				}
			}
			return $_post_id;
		}
		// Add js template for format extra info
		public function format_meta_box(){
			global $post; 
			if(($post->post_type == 'post') && current_theme_supports('post-formats') && post_type_supports($post->post_type, 'post-formats')) :
				$pid = $post->ID;
				$format = get_post_format($pid);  ?>
				<script type="text/html" id="windflaw-tmpl-format-meta-box" data-format="<?php echo $format; ?>">
					<div id="windflaw-format-media" style="padding-top:10px;">
						<h4><?php esc_html_e('Post Format Content', 'windflaw-lite'); ?> </h4>
						<div class="format audio">
							<p><a href="#" class="format-media audio"><?php esc_html_e('Choose Audio', 'windflaw-lite'); ?></a></p>
							<label>
								<?php esc_html_e('Or type manually:', 'windflaw-lite'); ?>
								<textarea class="audio-code" <?php $this->get_format_name('audio-code'); ?> style="width: 98%; height: 115px;"><?php $this->get_format_content('audio-code'); ?></textarea>
								<input class="audio-id" type="hidden" <?php $this->get_format_name('audio-id'); ?> value="<?php $this->get_format_content('audio-id'); ?>" />
							</label>
						</div>
						<div class="format video">
							<p><a href="#" class="format-media video"><?php esc_html_e('Choose Video', 'windflaw-lite'); ?></a></p>
							<label>
								<?php esc_html_e('Or type manually:', 'windflaw-lite'); ?>
								<textarea class="video-code" <?php $this->get_format_name('video-code'); ?> style="width: 98%; height: 115px;"><?php $this->get_format_content('video-code'); ?></textarea>
								<input class="video-id" type="hidden" <?php $this->get_format_name('video-id'); ?> value="<?php $this->get_format_content('video-id'); ?>" />
							</label>
							<p>
								<span><?php esc_html_e('Note: If use self hosted video, the video type must be supported by html5 video.', 'windflaw-lite'); ?></span>
							</p>
							<?php do_action('windflaw_post_metabox_format_video', $post); ?>
						</div>
					</div>
					<input type="hidden" name="windflaw_nonce" value="<?php echo wp_create_nonce('windflaw_nonce'); ?>" />
				</script> <?php
			endif;
		}
		// Post Format Media
		public function get_post_format_media($media){
			global $post, $content_width;
			$format_media = '';
			$format_content = get_post_meta($post->ID, $this->format_meta_name, true);
			if(!empty($format_content) && is_array($format_content)){
				$width = $content_width;
				$content_width = 1440; // Make the initial width to 1440.
				switch(get_post_format()){
					case 'video':
						$format_media = empty($format_content['video-code']) ? '' : do_shortcode($format_content['video-code']);
						break;
					case 'audio':
						$format_media = empty($format_content['audio-code']) ? '' : do_shortcode($format_content['audio-code']);
						break;
					default: 
						$format_media = false;
				}
				$content_width = $width; // Reset the default content width.
				return $format_media;
			}
		}
		/**
		* @description get excerpt for quote/link in post list page
		*/
		private function get_quote_excerpt($quote, $byline, $in_list = false){
			if($in_list && apply_filters('windflaw_post_format_quote_need_excerpt', false)){
				$length = apply_filters('excerpt_length', 0);
				if(!empty($length)){
					$text = $quote . ' ' . $byline;
					if(!$this->test_text_length($text, $length)){
						if($this->test_text_length($quote, $length, true)){
							$words = preg_split("/[\n\r\t ]+/", $quote, -1, PREG_SPLIT_NO_EMPTY);
							if(count($words) < $length){ 
								$this->test_text_length($byline, ($length - count($words)), true);
							}
						}
						else{
							$byline = '';
						}
					}
				}
			}
			$byline = empty($byline) ? '' : sprintf(
				'<cite>%s</cite>', 
				esc_html($byline)
			);
			$wrap = is_singular('post') ? '<blockquote><p>%s</p></blockquote>'
				: '<blockquote><h2 class="post-title">%s</h2></blockquote>';
			return empty($quote) ? '' : sprintf($wrap, esc_html($quote) . $byline);
		}
		private function get_link_excerpt($text, $in_list = false){
			if($in_list && apply_filters('windflaw_post_format_link_need_excerpt', false)){
				$length = apply_filters('excerpt_length', 0);
				if(!empty($length)){
					$this->test_text_length($text, $length, true);
				}
			}
			return $text;
		}
		/**
		* @description helper function to test the length of string is < the length provided
		* @param reference, text need to test the length of
		* @param int, the length to test
		* @param boolean, determine return cut string or test result
		* @return boolen, true if <, otherwise false. If either the paramaters empty, return true
		*/
		private function test_text_length(&$text, $length, $cut = false){
			if(!empty($text) && !empty($length)){
				$words = preg_split("/[\n\r\t ]+/", $text, $length + 1, PREG_SPLIT_NO_EMPTY);
				if(count($words) > $length){
					if($cut){
						array_pop($words);
						$text = implode(' ', $words) . ' ...';
					}
					return false;
				}
			}
			return true;
		}
		/**
		* @description helper function to get format media content for post format meta box
		* @param string post format type name
		* @return string post format media if exists
		*/
		private function get_format_content($name){
			global $post;
			$media = $this->format_media ? $this->format_media : get_post_meta($post->ID, $this->format_meta_name, true);

			echo !empty($media) && isset($media[$name]) ? esc_attr($media[$name]) : '';
		}
		// Helper function to get format media name
		private function get_format_name($name){
			if(!empty($name)){
				printf('name="%s[%s]"', $this->format_meta_name, $name);
			}
		}
		// Helper function santize textarea
		private function sanitize_textarea($values, $name){
			return empty($values[$name]) ? '' : sanitize_text_field($values[$name]);
		}
		// Helper function sanitize html string
		private function sanitize_html($values, $name){
			if(current_user_can( 'unfiltered_html')){
				return $values[$name];
			}
			else{
				global $allowedposttags;
				return empty($values[$name]) ? '' : wp_kses($values[$name], array_merge($allowedposttags, array(
					'iframe' => array(
						'width' => true,
						'height' => true,
						'src' => true,
						'frameborder' => true,
						'allowfullscreen' => true
					))));
			}
		}
		// Helper function sanitize number
		private function sanitize_num($values, $name){
			return empty($values[$name]) ? '' : absint($values[$name]);
		}
		// Helper function sanitize url
		private function sanitize_url($values, $name){
			return empty($values[$name]) ? '' : esc_url_raw($values[$name]);
		}
	}
	new Windflaw_Meta_Box();
}