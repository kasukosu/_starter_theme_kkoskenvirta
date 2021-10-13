<?php

defined('ABSPATH') || exit();

function get_the_breadcrumbs() {
	if (is_admin()) {
		return;
	}
	if (is_front_page()) {
		return;
	}

	global $post;

	$breadcrumbs = array();
	$count = 0;
	$parent_arrive = 0;

	$page = get_queried_object();
	if (isset($page->ID)) {
		$breadcrumbs[$count]['id'] = $page->ID;
		$breadcrumbs[$count]['name'] = $page->post_title;
		$breadcrumbs[$count]['link'] = get_permalink($page->ID);
		$count++;
	}

	if (is_page()) {
		$ancestors = get_post_ancestors($post);

		foreach ($ancestors as $key => $postID) {
			$ancestor_post = get_post($postID);
			$breadcrumbs[$count]['id'] = $ancestor_post->ID;
			$breadcrumbs[$count]['name'] = $ancestor_post->post_title;
			$breadcrumbs[$count]['link'] = get_permalink($ancestor_post->ID);
			$count++;
		}
	}

	if (is_singular(['post'])) {
		$current_category = get_the_category();
		if (is_array($current_category) && !empty($current_category)) {
			$current_category_id = $current_category[0]->term_id;
			$category = get_category($current_category_id);

			$breadcrumbs[$count]['id'] = $category->term_id;
			$breadcrumbs[$count]['name'] = $category->name;
			$breadcrumbs[$count]['link'] = get_category_link($category->term_id);
			// remove /category/ url prefix
			$breadcrumbs[$count]['link'] = str_replace('/category/', '/', $breadcrumbs[$count]['link']);
			$count++;

			while ($parent_arrive == 0) {
				if ($category->category_parent == 0) {
					$parent_arrive = 1;
				} else {
					$breadcrumbs[$count]['id'] = $category->category_parent;
					$category = get_category($category->category_parent);
					$breadcrumbs[$count]['name'] = $category->name;
					$breadcrumbs[$count]['link'] = get_category_link($category->id);
					// remove /category/ url prefix
					$breadcrumbs[$count]['link'] = str_replace('/category/', '/', $breadcrumbs[$count]['link']);
				}
				$count++;
			}
		}

		$page_for_posts_id = get_option('page_for_posts');
		// $breadcrumbs[$count]['id'] = $page_for_posts_id;
		// $breadcrumbs[$count]['name'] = get_the_title($page_for_posts_id);
		// $breadcrumbs[$count]['link'] = get_permalink($page_for_posts_id);
		// $count++;
	}



	// if (is_category()) {
	// 	$category = get_queried_object();

	// 	$breadcrumbs[$count]['id'] = $category->term_id;
	// 	$breadcrumbs[$count]['name'] = $category->name;
	// 	$breadcrumbs[$count]['link'] = get_category_link($category->term_id);
	// 	$count++;

	// 	$home_url = get_permalink( get_option( 'page_for_posts' ) );
	// 	$home_name = sprintf( '%1$s', __( 'Artikkelit', 'betta' ) );

	// 	$breadcrumbs[$count]['name'] = $home_name;
	// 	$breadcrumbs[$count]['link'] = $home_url;
	// 	$count++;
	// }

	if (is_tag()) {
		$tag = get_queried_object();

		$breadcrumbs[$count]['id'] = $tag->term_id;
		$breadcrumbs[$count]['name'] = $tag->name;
		$breadcrumbs[$count]['link'] = get_tag_link($tag->term_id);
		$count++;

		$references = get_post(19);
		$breadcrumbs[$count]['id'] = $references->id;
		$breadcrumbs[$count]['name'] = $references->post_title;
		$breadcrumbs[$count]['link'] = $references->guid;
		$count++;
	}

	$breadcrumbs = array_reverse($breadcrumbs);

	$home_link = sprintf(
		'<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a itemprop="item" href="%s">
				<span itemprop="name">%s</span>
			</a>
			<meta itemprop="position" content="1" />
		</li>',
		site_url(),
		__('Home')
	);

	$links = '';
	foreach ($breadcrumbs as $index => $breadcrumb) {
		$links .= sprintf(
			'<li class="child" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="%s">
					<span itemprop="name">%s</span>
				</a>
				<meta itemprop="position" content="%u" />
			</li>',
			$breadcrumb['link'],
			$breadcrumb['name'],
			($index + 1)
		);
	}

	$output = '';
	$output = sprintf(
		'<ol itemscope itemtype="http://schema.org/BreadcrumbList">
			%s
			%s
		</ol>',
		$home_link,
		$links
	);

	return $output;
}
