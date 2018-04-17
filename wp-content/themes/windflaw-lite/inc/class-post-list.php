<?php
/**
 * @package   Windflaw
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 * @copyright Copyright (c) 2016
 */

if(!class_exists('Windflaw_Post_List')){
	add_action('windflaw_post_list', 'Windflaw_Post_List::instance');

	class Windflaw_Post_List{
		private $metas = array('author', 'date', 'category', 'comments');
		static public $_instance = false;
		public static function instance(){
			if(self::$_instance === false){
				self::$_instance = new self();
			}
			self::$_instance->render();
		}
		/**
		 * @description main function to render the shortcode
		 */
		public function render(){
			// Output the html if any post exist, otherwise show the error message.
			if(have_posts()){
				$html  = $this->show_articles();
				$html .= $this->getPagination(); // Get the pagination.
				$this->clearup();

				echo $html;
			}
			else{
				echo '<div class="container"><p>'. esc_html__("Sorry, but nothing found.", 'windflaw-lite') . '</p></div>';
			}
		}
		/**
		* @description clearup
		*/
		private function clearup(){
			wp_reset_postdata();
		}
		private function show_articles(){
			$html = '';
			while(have_posts()){
				the_post();
				$html .= $this->getHTML();
			}
			return $html;
		}
		/**
		 * @description get list html
		 */
		private function getHTML(){
			$id	= get_the_ID();
			$excerpt = get_the_excerpt();
			$classes = array_merge(get_post_class(), array('post'));  // Get the post class array. We need to add our owns.
			has_post_thumbnail() ? '' : array_push($classes, 'no-featured-img'); // If there is no featured image set, add the class no-featured-img.
			empty($excerpt) ? array_push($classes, 'no-post-content') : '';
			$url   = get_permalink($id);
			$html  = '<article id="post-' . $id . '" class="' . implode(' ' , $classes) . '">';
			$html .= in_array('sticky', $classes) ? '<span class="sticky-post">' . esc_html__('Featured', 'windflaw-lite') . '</span>' : ''; // Add sticky post ribbon if needed.
			$html .= $this->get_media();
			$html .= '<div class="post-content">';
			$html .= '<h2 class="post-title"><a href="' . $url . '">' . get_the_title() . '</a></h2>';
			$html .= $this->getMetaArray();
			$html .= '<div class="post-excerpt">' . $excerpt . '</div>';
			$html .= '</div>';
			$html .= '</article>';
			return $html;
		}
		/**
		 * @return string html of pagination.
		 */
		private function getPagination(){
			return get_the_posts_pagination(array(
				'prev_text' => '<span><i class="fa fa-angle-left"></i></span>',
				'next_text' => '<span><i class="fa fa-angle-right"></i></span>'
			));
		}
		/**
		 * @description get meta for post
		 * @param string $meta meta name to retrieve
		 * @return string the meta value 
		 */
		private function getMeta($meta){
			$html = '';
			switch($meta){
				case 'author': // Author profile for post only.
					$html = Windflaw_Front::get_author_meta();
					break;
				case 'category':  // Taxonomy info.
					$html = Windflaw_Front::get_taxonomy_meta();
					break;
				case 'date':  // Date info.
					$html = Windflaw_Front::get_date_meta();
					break;
				case 'comments': // Comment info.
					$html = Windflaw_Front::get_comment_meta();
					break;
			}
			return $html;
		}
		/**
		 * @description get metas for post only, these metas will be separated by /
		 */
		private function getMetaArray(){
			$html = '';
			foreach($this->metas as $m){
				$metaHTML = $this->getMeta($m);
				!empty($metaHTML) ? ($HTMLs[] = $metaHTML) : '';
			}
			$html .= !empty($HTMLs) ? ('<aside class="post-meta">' . implode('', $HTMLs) . '</aside>') : '';
			return $html;
		}
		/**
		* Get media for post
		*/
		private function get_media(){
			$media 	= apply_filters('windflaw_get_post_format_media', false);
			$url 	= get_permalink();
			return empty($media) ? (has_post_thumbnail() ? sprintf('<figure class="featured-img"><a href="%s">%s</a></figure>', $url, get_the_post_thumbnail()) : false)
				: $media;
		}
	}
}