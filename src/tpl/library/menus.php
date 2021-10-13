<?php

defined('ABSPATH') || exit();

function theme_menus() {
	register_nav_menus([
		'header-menu-short' => 'Header Menu Short',
		'header-menu-primary' => 'Header Menu Primary',
		'header-menu-secondary' => 'Header Menu Secondary',
		'header-menu-tertiary' => 'Header Menu Tertiary',
		'footer-menu-primary' => 'Footer Menu Primary',
		'footer-menu-secondary' => 'Footer Menu Secondary',
		'footer-menu-tertiary' => 'Footer Menu Tertiary',
	]);
}
add_action('init', 'theme_menus', 10, 0);

function get_the_menu($location = '') {
	if (has_nav_menu($location)) {
		return wp_nav_menu([
			'menu' => '',
			'menu_class' => '',
			'menu_id' => '',
			'container' => false,
			'container_class' => '',
			'container_id' => '',
			'fallback_cb' => false,
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'echo' => false,
			'depth' => 0,
			'walker' => ($location === 'header-menu-short') ? new Custom_Walker_Nav_Menu() : new Alternative_Custom_Walker_Nav_Menu(),
			'theme_location' => $location,
			'items_wrap' => '<ul>%3$s</ul>',
			'item_spacing' => 'preserve', // 'discard',
		]);
	}
}

// default markup

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $counter ;
	private $countItems ;

	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$this->counter++;

		$link = '';

		ob_start();
		$dropdown = ob_get_clean();

		if ($this->counter === (int) 1) {
			$link = '<li class="has-children menu-item menu-item-type-post_type menu-item-object-page"><a href="?"><span>Palvelumme</span></a>' . $dropdown . '</li>';
		}

		$output .= $link;
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;

		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

		$title_class = sanitize_html_class(sanitize_title_with_dashes($item->title));
		$classes[] = 'menu-item-' . $title_class;

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));

		$class_names = ' class="'. esc_attr($class_names) . '"';

		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';

		$item_output = $args->before;
		$item_output .= $args->link_before . '<a' . $attributes . '>';
		$item_output .= '<span class="title">';
		$item_output .= apply_filters('the_title', $item->title, $item->ID);
		$item_output .= '</span>';
		$item_output .= '</a>' . $args->link_after;


		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

// alternative markup for mega dropdown navigation

class Alternative_Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $counter;

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;

		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'. esc_attr($class_names) . '"';

		$data_attributes = ' data-depth="' .$depth. '"';

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names . $data_attributes . '>';

		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';

		$description  = !empty($item->description) ? '<span class="description">' . esc_attr($item->description) . '</span>' : '';

		$item_output = $args->before;
		$item_output .= '<div>';

		$item_output .= '<span class="title">';
		$item_output .= $args->link_before . '<a' . $attributes . '>';
		$item_output .= apply_filters('the_title', $item->title, $item->ID);
		$item_output .= '</a>' . $args->link_after;
		$item_output .= '</span>';
		$item_output .= $description;

		if($args->walker->has_children){
			$item_output .= $args->link_before .  '<button type="button" class="menuitem_icon" aria-label="open-submenu">';
			$item_output .= '<i class="fas fa-angle-down" aria-hidden="true"></i>';
			$item_output .= '</button>';
		}

		$item_output .= '</div>';

		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

function modify_wp_nav_menu_objects($sorted_menu_items, $args) {
	// check if the current page is really a blog post.
	global $wp_query;

	if (!empty($wp_query->queried_object_id)) {
		$current_page = get_post($wp_query->queried_object_id);
		if ($current_page && $current_page->post_type == 'post') {
			//yes!
		} else {
			$current_page = false;
		}
	} else {
		$current_page = false;
	}

	$home_page_id = (int) get_option('page_for_posts');

	foreach ($sorted_menu_items as $id => $menu_item) {
		if (!empty($home_page_id) && ('post_type' == $menu_item->type) && empty($wp_query->is_page) && ($home_page_id == $menu_item->object_id)) {
			if (!$current_page) {
				foreach ($sorted_menu_items[$id]->classes as $class_id => $class_name) {
					if ($class_name == 'current_page_parent') {
						unset($sorted_menu_items[$id]->classes[$class_id]);
					}
				}
			}
		}
	}

	return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'modify_wp_nav_menu_objects', 10, 2);
