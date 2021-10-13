<?php

defined('ABSPATH') || exit();

function modify_gutenberg_supported_features() {
	add_theme_support('editor-color-palette', []);
	add_theme_support('disable-custom-font-sizes');
	add_theme_support('disable-custom-colors');
}
add_action('after_setup_theme', 'modify_gutenberg_supported_features', 11, 0);

function modify_gutenberg_allowed_blocks($allowed_blocks, $post) {
	$allowed_blocks = [
	];
	return $allowed_blocks;
}
#add_filter('allowed_block_types', 'modify_gutenberg_allowed_blocks', 10, 2);

function modify_gutenberg_core_blocks() {
	// wp_register_script(
	// 	'blocks',
	// 	get_template_directory_uri() . '/assets/js/gutenberg.blocks.js',
	// 	['wp-blocks'],
	// 	filemtime(get_theme_file_path('/assets/js/gutenberg.blocks.js')),
	// 	true
	// );
	// wp_enqueue_script('blocks');

	wp_register_script(
		'sidebar',
		get_template_directory_uri() . '/assets/js/gutenberg.sidebar.js',
		['wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components'],
		filemtime(get_theme_file_path('/assets/js/gutenberg.sidebar.js')),
		true
	);
	#wp_enqueue_script('sidebar');
}
add_action('enqueue_block_editor_assets', 'modify_gutenberg_core_blocks', 10, 0);

function add_gutenberg_block_styles() {
	wp_register_style(
		'blocks',
		get_template_directory_uri() . '/assets/css/gutenberg/gutenberg.blocks.css',
		['wp-edit-blocks'],
		filemtime(get_theme_file_path('/assets/css/gutenberg/gutenberg.blocks.css')),
		'all'
	);
	wp_enqueue_style('blocks');

	wp_register_style(
		'sidebar',
		get_template_directory_uri() . '/assets/css/gutenberg/gutenberg.sidebar.css',
		['wp-edit-blocks'],
		filemtime(get_theme_file_path('/assets/css/gutenberg/gutenberg.sidebar.css')),
		'all'
	);
	#wp_enqueue_style('sidebar');
}
add_action('enqueue_block_assets', 'add_gutenberg_block_styles', 10, 0);

function add_gutenberg_custom_blocks() {
	if (!function_exists('register_block_type')) {
		return;
	}

	$blocks = [
		'dynamic.promo',

	];

	foreach ($blocks as $block_name) {
		wp_register_script(
			$block_name,
			get_template_directory_uri() . '/assets/js/gutenberg.block.' . $block_name . '.js',
			['wp-blocks', 'wp-components', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api-fetch'],
			filemtime(get_theme_file_path('/assets/js/gutenberg.block.' . $block_name . '.js')),
			false
		);

		wp_register_style(
			$block_name,
			get_template_directory_uri() . '/assets/css/gutenberg/gutenberg.block.' . $block_name . '.css',
			['wp-edit-blocks', 'blocks'],
			filemtime(get_theme_file_path('/assets/css/gutenberg/gutenberg.block.' . $block_name . '.css')),
			'all'
		);

		$args = [
			'editor_script' => $block_name,
			'editor_style' => $block_name,
		];

		if (strpos($block_name, 'dynamic.') !== false) {
			// remove dynamic. from here on
			$block_name = str_replace('dynamic.', '', $block_name);
			$args['render_callback'] = function($attributes, $content) use ($block_name) {
				return gutenberg_dynamic_block_renderer($block_name, $attributes, $content);
			};
		}

		register_block_type(
			'kkoskenvirta_starter/' . $block_name,
			$args
		);

	}
}
add_action('init', 'add_gutenberg_custom_blocks', 10, 0);

// fetch template partial for dynamic blocks

function gutenberg_dynamic_block_renderer($name, $attributes, $content) {

	foreach ($attributes as $attribute_name => $attribute_value) {
		set_query_var($name . '/' . $attribute_name, $attribute_value);
	}
	set_query_var($name . '/content', $content);
	ob_start();
	get_template_part('partials/blocks/block-' . $name);
	$output = ob_get_clean();

	if ($output === '') {
		$output = (string) $content;
	}

	foreach ($attributes as $attribute_name => $attribute_value) {
		set_query_var($name . '/' . $attribute_name, null);
	}
	set_query_var($name . '/content', null);

	$minified_html = preg_replace('/>\s+</', '><', $output);


	return $minified_html;
}

// create a 'template' for pages

function add_gutenberg_default_blocks_to_post_types() {
	$post_type_object = get_post_type_object('post');
	$post_type_object->template = [
		['core/heading', [
			'level' =>  (int) 4,
			'placeholder' => 'Heron apuotsikko tähän',
		]],
		['core/heading', [
			'level' => (int) 1,
			'placeholder' => 'Heron otsikko tähän',
		]],
		['core/paragraph', [
			'placeholder' => 'Ingressiteksti tähän. Muista käyttää "Lisää"-lohkoa alla. Voluptate eu sed in ad eiusmod reprehenderit ut nisi sit.',
		]],
		['core/more'],
	];
	//$post_type_object->template_lock = 'insert';

	$page_type_object = get_post_type_object('page');
	$page_type_object->template = [
		['core/heading', [
			'level' =>  (int) 4,
			'placeholder' => 'Heron apuotsikko tähän',
		]],
		['core/heading', [
			'level' =>  (int) 1,
			'placeholder' => 'Heron otsikko tähän',
		]],
		['core/paragraph', [
			'placeholder' => 'Ingressiteksti tähän. Muista käyttää "Lisää"-lohkoa alla. Voluptate eu sed in ad eiusmod reprehenderit ut nisi sit.',
		]],
		['core/more'],
	];
	//$page_type_object->template_lock = 'insert';
}
add_action('init', 'add_gutenberg_default_blocks_to_post_types', 10, 0);


/* register new blocks for acf field groups */

function register_custom_acf_blocks() {

	acf_register_block_type([
		'name' => 'staff',
		'title' => 'Staff',
		'description' =>'',
		'render_template' => 'partials/block-staff.php',
		'category' => 'common',
		'icon' => 'id-alt',
		'keywords' => [
			'staff',
			'personnels',
		],
		'post_types' => [
			'page',
		],
		'supports' => [
			'align' => false,
			'mode' => 'preview',
			'multiple' => false,
		],
	]);

}
add_action('acf/init', 'register_custom_acf_blocks', 10, 0);
