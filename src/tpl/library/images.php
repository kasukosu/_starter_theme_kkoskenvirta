<?php

defined('ABSPATH') || exit();

function theme_image_sizes() {
	add_image_size(
		'1500x800',
		1500,
		800,
		['center', 'center']
	);
	add_image_size(
		'1000x500',
		1000,
		500,
		['center', 'center']
	);
	add_image_size(
		'300x300',
		300,
		300,
		['center', 'center']
	);
	add_image_size(
		'200x200',
		200,
		200,
		['center', 'center']
	);
	add_image_size(
		'90x120',
		90,
		120,
		['center', 'center']
	);
}
add_action('after_setup_theme', 'theme_image_sizes', 10, 0);

function add_theme_image_sizes_as_media_choices($default_image_sizes) {
	$theme_image_sizes = [
		'1500x800' => __('Hero'),
		'1000x500' => __('Banner'),
		'300x300' => __('Article'),
		'200x200' => __('Promo'),
		'90x120' => __('Person'),
	];
	return array_merge($default_image_sizes, $theme_image_sizes);
}
add_filter('image_size_names_choose', 'add_theme_image_sizes_as_media_choices', 10, 1);

// add_filter('wp_calculate_image_srcset', '__return_false');

function skip_default_image_sizes($sizes) {
	$default_image_sizes = [
		'thumbnail',
		'medium',
		'medium_large',
		'large',
	];
	foreach ($default_image_sizes as $size) {
		unset($sizes[$size]);
	}
	return $sizes;
}
#add_filter('intermediate_image_sizes_advanced', 'skip_default_image_sizes', 10, 1);

function remove_image_sizes() {
	foreach (get_intermediate_image_sizes() as $size) {
		$image_sizes = [
			'thumbnail',
			'medium',
			'medium_large',
			'large',
		];
		if (in_array($size, $image_sizes)) {
			remove_image_size($size);
		}
	}
}
#add_action('init', 'remove_image_sizes', 10, 0);

// helper

function image_resize_or_rescale_or_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
	if (!$crop) {
		return null;
	}

	$aspect_ratio = $orig_w / $orig_h;
	$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

	$crop_w = round($new_w / $size_ratio);
	$crop_h = round($new_h / $size_ratio);

	$s_x = floor(($orig_w - $crop_w) / 2);
	$s_y = floor(($orig_h - $crop_h) / 2);

	if (is_array($crop)) {
		if ($crop[0] === 'left') {
			$s_x = 0;
		} else if ($crop[0] === 'right') {
			$s_x = $orig_w - $crop_w;
		}
		if ($crop[1] === 'top') {
			$s_y = 0;
		} else if ($crop[1] === 'bottom') {
			$s_y = $orig_h - $crop_h;
		}
	}

	return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
}
add_filter('image_resize_dimensions', 'image_resize_or_rescale_or_crop_dimensions', 10, 6);

// helper

function sanitize_filename($filename) {
	$sanitized_filename = remove_accents($filename);

	// remove invalid characters
	$invalid_characters = array(
		' ' => '-',
		'%20' => '-',
		'_' => '-'
	);
	$sanitized_filename = str_replace(
		array_keys($invalid_characters),
		array_values($invalid_characters),
		$sanitized_filename
	);

	// remove all non-alphanumeric except . (dot)
	$sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename);

	// remove all but last . (dot)
	$sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename);

	// replace any more than one - (dash) in a row
	$sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename);

	// remove last - (dash) if at the end */
	$sanitized_filename = str_replace('-.', '.', $sanitized_filename);

	// lowercase
	$sanitized_filename = strtolower($sanitized_filename);

	return $sanitized_filename;
}
add_filter('sanitize_file_name', 'sanitize_filename', 10, 1);

// allow new file types for media uploads

function add_new_file_types($file_types) {
	$file_types['svg'] = 'image/svg+xml';
	return $file_types;
}
add_filter('upload_mimes', 'add_new_file_types');


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function betta_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_single() ) {
		$attr['sizes'] = '(max-width: 1000px) 89vw, (max-width: 1200px) 54vw, (max-width: 1600px) 800px, 800px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'betta_post_thumbnail_sizes_attr', 10, 3 );