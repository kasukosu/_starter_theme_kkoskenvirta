<?php

/**
 * Plugin Name: Custom Post Type Kohde
 * Plugin URI: https://www.betta.fi/
 * Description: Custom post type for sepri kohteet .
 * Version: 1.0.0
 * Author: Kasper Koskenvirta @ Betta Digital
 * Author URI: https://www.betta.fi/
 * License: GPL-2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace BettaDigital;

if (!defined('ABSPATH')) {
	die('Error');
}

add_action('plugins_loaded', array('BettaDigital\Custom_Post_Type_Kohde', 'init'), 10, 0);

class Custom_Post_Type_Kohde {

	public function __construct() {
		add_action('init', array($this, 'register_custom_post_type'), 10, 0);
		add_action('admin_init', array($this, 'add_custom_post_type_capabilities'), 10, 0);
		add_filter('post_updated_messages', array($this, 'custom_post_type_notification_messages'), 10, 1);
		add_action('admin_head', array($this, 'custom_post_type_help_messages'), 10, 0);
	}

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	public function register_custom_post_type() {
		$labels = [
			'name' => 'Kohteet',
			'singular_name' => 'Kohteet',
			'menu_name' => 'Kohteet',
			'name_admin_bar' => 'Kohteet',
			'archives' => 'Kohteet',
			'parent_item_colon' => 'Kohteet:',
			'all_items' => 'Kaikki kohteet',
			'add_new_item' => 'Lisää uusi kohde',
			'add_new' => 'Lisää uusi',
			'new_item' => 'Uusi kohteet',
			'edit_item' => 'Muokkaa kohdetta',
			'update_item' => 'Päivitä kohteet',
			'view_item' => 'Näytä kohteet',
			'search_items' => 'Hae kohteetä',
			'not_found' => 'Verkkolehteä ei löytynyt',
			'not_found_in_trash' => 'Kohteetä ei löytynyt roskakorista',
			'featured_image' => 'Artikkelikuva',
			'set_featured_image' => 'Aseta artikkelikuva',
			'remove_featured_image' => 'Poista artikkelikuva',
			'use_featured_image' => 'Käytä artikkelikuvana',
			'insert_into_item' => 'Lisää kohteeseen',
			'uploaded_to_this_item' => 'Lataa tähän kohteeseen',
			'items_list' => 'Kohteet',
			'items_list_navigation' => 'Kohteen navigaatio',
			'filter_items_list' => 'Suodata kohteet',
			'enter_title_here' => 'Lisää kohteen nimi tähän',
		];

		$capabilities = [
			'publish_posts' => 'publish_kohde',
			'read_post' => 'read_kohde',
			'read_private_posts' => 'read_private_kohde',
			'edit_post' => 'edit_kohde',
			'edit_posts' => 'edit_kohde',
			'edit_others_posts' => 'edit_others_kohde',
			'delete_post' => 'delete_kohde',
			'delete_posts' => 'delete_kohde',
		];

		$args = array(
			'label' => 'Kohteet',
			'labels' => $labels,
			'description' => 'Kohteet.',
			'public' => true,
			'hierarchical' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => true,

			'show_in_rest' => true,
			'rest_base' => 'kohteet',
			#'rest_controller_class' => \WP_REST_Posts_Controller,

			'menu_position' => 20,
			'menu_icon' => 'dashicons-admin-page',

			'capability_type' => ['kohde', 'kohteet'],
			'capabilities' => $capabilities,
			'map_meta_cap' => false,

			'supports' => [
				'title',
				'editor',
				'comments',
				'revisions',
				'trackbacks',
				'author',
				'excerpt',
				'page-attributes',
				'thumbnail',
				'custom-fields',
				'post-formats',
			],

			'taxonomies' => array('post_tag'),
			'has_archive' => false,

			'rewrite' => array(
				'slug' => 'kohteet',
				'with_front' => true,
				#'feeds' => false,
				#'pages' => 'sivu',
				#'ep_mask' => EP_PERMALINK,
			),


			'can_export' => true,

			'delete_with_user' => false,
		);

		register_post_type('kohde', $args);
	}
	public function add_custom_post_type_capabilities() {
		$admins = get_role('administrator');
		$admins->add_cap('publish_kohde');
		$admins->add_cap('read_kohde');
		$admins->add_cap('read_private_kohde');
		$admins->add_cap('edit_kohde');
		$admins->add_cap('edit_kohde');
		$admins->add_cap('edit_others_kohde');
		$admins->add_cap('delete_kohde');
		$admins->add_cap('delete_kohde');
	}

	public function custom_post_type_notification_messages($messages) {
		$post = get_post();
		$messages['kohde'] = array(
			0 => '',
			1 => 'Kohde päivitetty.',
			2 => 'Tietokenttä päivitetty.',
			3 => 'Tietokenttä poistettu.',
			4 => 'Kohde päivitetty.',
			5 => (isset($_GET['revision'])) ? sprintf('Kohde palautettu versioon %s', wp_post_revision_title((int) $_GET['revision'], false)) : false,
			6 => 'Kohde julkaistu.',
			7 => 'Kohde tallennettu.',
			8 => 'Kohde lähetetty.',
			9 => sprintf(
				'Kohde ajastettu: <strong>%1$s</strong>.',
				date_i18n( 'M j, Y @ G:i', strtotime($post->post_date))
			),
			10 => 'Kohdeluonnos päivitetty.'
		);
		return $messages;
	}

	public function custom_post_type_help_messages() {
		$screen = get_current_screen();
		if ($screen->post_type !== 'kohde') {
			return;
		}
		$basics = array(
			'id' => 'kohde_basics',
			'title' => 'Avainhenkilöiden yleiskatsaus',
			'content' => ''
		);
		$formatting = array(
			'id' => 'kohde_formatting',
			'title' => 'Kohteiden muokkaus',
			'content' => ''
		);
		$screen->add_help_tab($basics);
		$screen->add_help_tab($formatting);
	}

}
