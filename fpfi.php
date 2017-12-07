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
* 
* First Picture as First Image is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*  
* First Picture as First Image is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*  
* You should have received a copy of the GNU General Public License
* along with First Picture as First Image. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
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

require_once( 'admin/settings-page.php' );

/*
** Init the __construct
*/	
add_action( "init", "First_Picture_as_FirstImage", 1 );

function First_Picture_as_FirstImage() {
	global $First_Picture_as_FirstImage;
	$First_Picture_as_FirstImage = new First_Picture_as_FirstImage();
}
	