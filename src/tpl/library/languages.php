<?php

if (!defined('ABSPATH')) {
	die();
}

/* load language files */

function activate_theme_textdomain() {
	load_theme_textdomain(get_template(), get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'activate_theme_textdomain', 10, 0);
