<?php
/**
* Plugin Name: First Picture as First Image
* Description: Use fist picture in your post or page as featured image. Just activate plugin and they'll work!
* Version: 0.1
* Author: Deblyn Prado
* Text Domain: fpfi
* Domain Path: /languages
* Author URI: http://deblynprado.com
* License: GPL2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class First_Picture_as_FirstImage {
	function get_first_image() {
		$fpfi_query = array();
		$the_query = get_posts( 'post_type=post' );

		foreach ( $the_query as $post ) : setup_postdata( $post );

		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		$first_img = $matches [1][0];
		return $first_img;
		endforeach;
		wp_reset_postdata();
		return $fpfi_query;
	}

	function check_thumbnail_image() {
		$fpfi_query = array();
		$the_query = get_posts( 'post_type=post' );

		foreach ( $the_query as $post ) : setup_postdata( $post );
		if ( !has_post_thumbnail( $post->ID ) ) :
			set_new_thumbnail_image( $post->ID );
		endif;
		endforeach;
		wp_reset_postdata();
		return $fpfi_query;
	}

	function set_new_thumbnail_image( $postid ) {
		$fpfi_query = array();
		$the_query = get_posts( 'post_type=post' );

		foreach ( $the_query as $post ) : setup_postdata( $post );
			$firstImage = get_first_image();
			$attachment_id = attachment_url_to_postid( $firstImage );
			set_post_thumbnail( $postid, $attachment_id );
		endforeach;
			wp_reset_postdata();
		return $fpfi_query;
	}
}

/*
** Init the __construct
*/	
add_action( "init", "First_Picture_as_FirstImage", 1 );

function First_Picture_as_FirstImage() {
	global $First_Picture_as_FirstImage;
	$First_Picture_as_FirstImage = new First_Picture_as_FirstImage();
}