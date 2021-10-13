<?php

defined('ABSPATH') || exit();

function theme_assets() {
	wp_dequeue_script('wp-embed');
	wp_deregister_script('wp-embed');

	wp_dequeue_style('wp-block-library');
	wp_deregister_style('wp-block-library');

	wp_register_style(
		'style-css',
		get_template_directory_uri() . '/assets/css/style.css',
		[],
		filemtime(get_theme_file_path('/assets/css/style.css')),
		'all'
	);
	wp_enqueue_style('style-css');

	wp_register_script(
		'site-js',
		get_template_directory_uri() . '/assets/js/site.js',
		[],
		filemtime(get_theme_file_path('/assets/js/site.js')),
		true
	);
	wp_enqueue_script('site-js');

	wp_register_script(
		'livereload',
		'http://localhost:35745/livereload.js?snipver=1',
		[],
		null,
		true
	);
	$localhost = [
		'127.0.0.1',
		'::1',
	];
	if (in_array($_SERVER['REMOTE_ADDR'], $localhost) && empty($_SERVER['HTTPS'])) {
		wp_enqueue_script('livereload');
	}

	wp_localize_script(
		'site-js',
		'site',
		[
			'ajaxUrl' => admin_url('admin-ajax.php'),
		]
	);
}
add_action('wp_enqueue_scripts', 'theme_assets', 10, 0);

