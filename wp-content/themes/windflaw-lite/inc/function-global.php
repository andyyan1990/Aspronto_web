<?php
/**
* @package Windflaw
* @author  Suihai Huang From Loft.Ocean team
* @link    http://www.loftocean.com
* @since   version 1.0.0
*/

/*
* Site wide helper functions
*/

/**
* @description recalculate the custom logo width and height
* @return array (src, width, height)
*/
function windflaw_change_custom_logo_width($image, $id, $size, $icon){
	$width = absint(get_theme_mod('windflaw_option_site_logo_width', 100));
	if((intval($width) > 0) && !empty($image[1])){
		$width = intval($width);
		$image[2] = $width / $image[1] * $image[2];
		$image[1] = $width;
	}
	return $image;
}
/**
* @description get site logo image
*/
function windflaw_the_custom_logo(){
	add_filter('wp_get_attachment_image_src', 'windflaw_change_custom_logo_width', 10, 4);
	the_custom_logo();
	remove_filter('wp_get_attachment_image_src', 'windflaw_change_custom_logo_width');
}
/**
* @generate custom css for theme customize
*/
function windflaw_generate_css($el, $prop, $val){
	return $el . ' { ' . $prop . ': ' . $val . '; } ';
}
/**
* @description helper function to get the image url by image id
*/
function windflaw_get_image_url($id, $size = "full"){
	$url = false;
	if(!empty($id)){
		$image = wp_get_attachment_image_src($id, $size);
		$url = ($image !== false) ? $image[0] : false;
	}
	return $url;
}
/**
* @description helper function get thumbnail url with specified size
*/
function windflaw_get_thumbnail_url($pid, $size = "full"){
	global $post;
	$pid = empty($pid) ? $post->ID : $pid;
	if(has_post_thumbnail($pid)){
		return windflaw_get_image_url(get_post_thumbnail_id($pid), $size);
	}
	return false;
}
/**
* @description helper function get the user info
*/
function windflaw_get_author_info($uid = 0){
	if(is_author()){
		global $wp_query;
		$author = $wp_query->get_queried_object();
		$uid = $author->ID;
	}
	else{
		global $post;
		$uid = ($uid > 0) ? $uid : $post->post_author;
	}
	$avatar = get_avatar($uid, 150); 
	$bio = apply_filters('the_content', get_the_author_meta('description', $uid));
	return array(
		'image' => $avatar,
		'bio'   => $bio,
		'name'  => get_the_author_meta('display_name', $uid),
		'url'   => get_author_posts_url($uid)
	);
}
/**
* @description get taxonomy list
*/
function windflaw_get_taxonomy_list($link = false, $separator = ', ', $pid = false){
	global $post;
	$terms	= get_the_terms((($pid === false) ? $post->ID : $pid), 'category');
	$termList = '';
	if(!empty($terms)){
		$termList = array();
		foreach($terms as $term){
			$termList[] = ($link === true) ? '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>' : esc_html($term->name);
		}
		$termList = implode($separator, $termList);
	}
	return $termList;
}
/**
* @description get tag cloud for post
*/
function windflaw_get_post_tags(){
	return get_the_tag_list('<aside class="post-tag-cloud"><div class="tagcloud">', '', '</div></aside>');
}
/**
* @description helper function get the backgroud srcset for webkit browser
*/
function windflaw_get_bg_srcset($default = array(WINDFLAW_BG_IMAGE_WIDTH, WINDFLAW_BG_IMAGE_HEIGHT), $retina = array(WINDFLAW_RETINA_BG_IMAGE_WIDTH, WINDFLAW_RETINA_BG_IMAGE_HEIGHT), $image_id = ''){
	$images = windflaw_get_image_set($default, $retina, $image_id);
	return $images ? 'background-image: -webkit-image-set(url(' . $images['default'] . ') 1x, url(' . $images['retina'] . ') 2x);' : '';
}
/**
 * @description get image srcset
 * @param string $default image size
 * @param string $retina image size
 * @return string background image srcset
 */
function windflaw_get_img_srcset($default = array(WINDFLAW_BG_IMAGE_WIDTH, WINDFLAW_BG_IMAGE_HEIGHT), $retina = array(WINDFLAW_RETINA_BG_IMAGE_WIDTH, WINDFLAW_RETINA_BG_IMAGE_HEIGHT), $image_id = ''){
	global $post;
	$image_id = !empty($image_id) ? $image_id : get_post_thumbnail_id($post->ID);
	$images = windflaw_get_image_set($default, $retina, $image_id);
	return $images ? 'srcset="' . $images['default'] . ', ' . $images['retina'] . ' 2x"' : '';
}
/**
 * @description helper method get image set(default and retina image with given size and image id)
 * @param string $default image size
 * @param string $retina image size
 * @return mix array if image exists otherwise false
 */
function windflaw_get_image_set($default = array(WINDFLAW_BG_IMAGE_WIDTH, WINDFLAW_BG_IMAGE_HEIGHT), $retina = array(WINDFLAW_RETINA_BG_IMAGE_WIDTH, WINDFLAW_RETINA_BG_IMAGE_HEIGHT), $image_id = ''){
	global $post;
	$image_id = !empty($image_id) ? $image_id : get_post_thumbnail_id($post->ID);
	$srcset = '';
	if($image_id > 0){
		$default = windflaw_get_image_url($image_id, (!empty($default) ? $default : array(WINDFLAW_BG_IMAGE_WIDTH, WINDFLAW_BG_IMAGE_HEIGHT)));
		$retina = windflaw_get_image_url($image_id, (!empty($retina) ? $retina : array(WINDFLAW_RETINA_BG_IMAGE_WIDTH, WINDFLAW_RETINA_BG_IMAGE_HEIGHT)));
		return !empty($default) ? array('default' => $default, 'retina' =>  $retina) : false;
	}
	return false;
}

/**
 * @description get normal page header
 */
function windflaw_get_page_header($tag = 'h1'){
	global $post;
	$pageTitle = '<div class="container"><' . $tag . ' class="page-title">' . get_the_title() . '</' . $tag . '></div>';
	if(has_post_thumbnail($post->ID)) : 
		$imageStyle = 'background-image: url(' . windflaw_get_thumbnail_url($post->ID) . '); ' . windflaw_get_bg_srcset();
?>
		<header class="page-header align-center fancy-page-header dark-page-header" style="<?php echo $imageStyle; ?> background-size: cover;">
			<div class="fancy-page-header-inner"><?php echo $pageTitle; ?></div>
		</header>
		<?php else : ?>
		<header class="page-header align-center <?php echo esc_attr(get_option('windflaw_theme_colors_scheme', 'light')); ?>-page-header"><?php echo $pageTitle; ?></header>
<?php
	endif;
}
