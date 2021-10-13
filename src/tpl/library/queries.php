<?php

defined('ABSPATH') || exit();

function add_offset_for_blog_posts($query) {
	if (!is_admin() && $query->is_main_query() && $query->is_home()) {
		$posts_per_page = get_option('posts_per_page');
		$offset_start = 1;
		$current_page = get_query_var('paged');
		$current_page = max(1, $current_page);
		$offset = ($current_page - 1) * $posts_per_page + $offset_start;
		$query->set('offset', $offset);
	}

	return;
}
#add_action('pre_get_posts', 'add_offset_for_blog_posts', 10, 1);

function add_offset_for_blog_posts_pagination($found_posts, $query) {
	if (!is_admin() && $query->is_main_query() && $query->is_home()) {
		$offset_start = 1;
		return $found_posts - $offset_start;
	}
	return $found_posts;
}
#add_filter('found_posts', 'add_offset_for_blog_posts_pagination', 10, 2);

function get_latest_posts($limit = -1) {
	global $post;

	$args = [
		'post_type' => ['post'],
		'posts_per_page' => $limit,
		'orderby' => 'date',
		'order' => 'DESC',
		'ignore_sticky_posts' => true,
		'post__not_in' => [$post->ID],
	];
	$query = new WP_Query($args);

	return $query->posts;
}

function get_random_posts($limit = -1) {
	global $post;

	$args = [
		'post_type' => ['post'],
		'posts_per_page' => $limit,
		'orderby' => 'rand',
		'ignore_sticky_posts' => true,
		'post__not_in' => [$post->ID],
	];
	$query = new WP_Query($args);

	return $query->posts;
}

function get_category_posts($category_slug = '', $limit = -1) {
	global $post;

	$args = [
		'post_type' => ['post'],
		'posts_per_page' => $limit,
		'orderby' => 'date',
		'category_name' => $category_slug,
		'ignore_sticky_posts' => false,
	];
	$query = new WP_Query($args);

	return $query->posts;
}

// temporary!

add_action('pre_get_posts', function($query) {
	if (is_admin()) {
		return;
	}

	if (!current_user_can('manage_options')) {
		#return;
	}

	if (!isset($query->query_vars['post_type']) || 'post' !== $query->query_vars['post_type']) {
		#return;
	}

	#$query->query_vars['post_status'] = 'any';
}, 10, 1);
