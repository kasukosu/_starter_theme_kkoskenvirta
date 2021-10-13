<?php

if (!defined('ABSPATH')) {
	die();
}

function custom_pagination($echo = true) {
	global $wp_query;

	$big = 999999999; // need an unlikely integer
	$pages = paginate_links([
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages,
		'type'  => 'array',
		'prev_next' => true,
		'prev_text'    => sprintf( '<i></i> %1$s', __( 'Seuraava sivu', 'urhea' ) ),
		'next_text'    => sprintf( '%1$s <i></i>', __( 'Edellinen sivu', 'urhea' ) ),
		'mid_size' => 1,
	]);

	if (is_array($pages)) {
		$paged = (get_query_var('paged') === (int) 0) ? (int) 1 : get_query_var('paged');

		$pagination = '<ul>';

		foreach ($pages as $page) {
			$pagination .= "<li>$page</li>";
		}

		$pagination .= '</ul>';

		if ($echo) {
			print $pagination;
		} else {
			return $pagination;
		}
	}
}
