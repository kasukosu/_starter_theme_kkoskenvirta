<?php

defined('ABSPATH') || exit();

function theme_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	]);
	add_theme_support('custom-logo');
	add_post_type_support('page', 'excerpt');
	add_post_type_support('post', 'page-attributes');
}
add_action('after_setup_theme', 'theme_setup', 10, 0);

/*removing default submit tag*/
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
/*adding action with function which handles our button markup*/
add_action('wpcf7_init', 'twentysixteen_child_cf7_button');
/*adding out submit button tag*/
if (!function_exists('twentysixteen_child_cf7_button')) {
function twentysixteen_child_cf7_button() {
wpcf7_add_form_tag('submit', 'twentysixteen_child_cf7_button_handler');
}
}
/*out button markup inside handler*/
if (!function_exists('twentysixteen_child_cf7_button_handler')) {
function twentysixteen_child_cf7_button_handler($tag) {
$tag = new WPCF7_FormTag($tag);
$class = wpcf7_form_controls_class($tag->type);
$atts = array();
$atts['class'] = $tag->get_class_option($class);
$atts['id'] = $tag->get_id_option();
$atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
$value = isset($tag->values[0]) ? $tag->values[0] : '';
if (empty($value)) {
$value = esc_html__('Send', 'twentysixteen');
}
$atts['type'] = 'submit';
$atts = wpcf7_format_atts($atts);
$html = sprintf('<button class="wp-block-button__link" type="submit ">%2$s</button>', $atts, $value);
return $html;
}
}


function bd_get_tags ($amount) {
	$tags = get_the_tags();
	if($tags){
		$tags = array_slice($tags, 0, $amount);
		$html = '<ul class="post_tags">';
		foreach ( $tags as $tag ) {
			$tag_link = get_tag_link( $tag->term_id );

			$html .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
			$html .= "{$tag->name}</a></li>";
		}
		$html .= '</ul>';
		echo $html;
	}
}

function bd_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}

add_filter( 'get_the_archive_title', 'bd_theme_archive_title' );


//Exclude rekry category
// Rekry = ID 16
// Referenssit = ID 6
// function exclude_category( $query ) {
// 	if ( $query->is_home() && $query->is_main_query() ) {
// 		$query->set( 'cat', '-16, -6' );
// 	}
// }
// add_action( 'pre_get_posts', 'exclude_category' );


// function betta_excerpt_length( $length ) {
//     return 12;
// }
// add_filter( 'excerpt_length', 'betta_excerpt_length', 999 );