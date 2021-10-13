<?php

defined('ABSPATH') || exit();

function add_editor_styles() {
	add_theme_support('editor-styles');
	add_editor_style();
}
add_action('after_setup_theme', 'add_editor_styles', 10, 0);

function remove_admin_menu_items() {
	$current_user = wp_get_current_user();
	if (strpos($current_user->user_email, '@betta.fi') === false) {
		#remove_menu_page('edit.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('tools.php');
		#remove_menu_page('themes.php');
		remove_menu_page('plugins.php');
		#remove_menu_page('sitepress-multilingual-cms/menu/languages.php');

	}

}
add_action('admin_menu', 'remove_admin_menu_items', 10, 0);

function modify_wp_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('comments');
	$wp_admin_bar->remove_node('customize');
}
add_action('wp_before_admin_bar_render', 'modify_wp_admin_bar', 10, 0);

/* Remove subterms from regular page posts for user clarity */
add_action('admin_enqueue_scripts', 'editor_styles_css');
function editor_styles_css() {
		wp_enqueue_style('editor_styles_css', get_template_directory_uri() .'/editor-style.css' );

}
