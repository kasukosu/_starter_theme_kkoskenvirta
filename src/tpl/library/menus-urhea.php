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
			'walker' => new Custom_Walker_Nav_Menu(),
			'theme_location' => $location,
			'items_wrap' => '<ul>%3$s</ul>',
			'item_spacing' => 'preserve', // 'discard',
		]);
	}
}

// default markup

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $prev_depth = 0;
	private $counter = 0;
	private $parent_title;
	private $parent_url;
	private $parent_description;
	private $parent_extra_description;
	private $breadcrumbs_parents;
	private $breadcrumbs_current;
	private $breadcrumbs_save;

    function start_lvl(&$output, $depth = 0, $args = null ){ //ul
		if ($depth === (int) 0) {
			$home = __('Etusivu', 'urhea');
			$home_url = get_home_url();
			$this->breadcrumbs_parents = '<a href="'.$home_url.'" aria-hidden="true" aria-label="breadcrumb-item"><span class="breadcrumb-root">'.$home.'</span></a>';
			$btn_text = __('Sulje', 'urhea');
			$title = $this->parent_title;
			$url = $this->parent_url;
			$description = $this->parent_description;
			$extra_description = $this->parent_extra_description;

			$submenu =  'sub-menu inactive' ;
			$output .= '<div onclick="closeAllMenus()" id="overlay" class="overlay" aria-disabled="true"></div>';

			$output .= '<div class="megamenu-grid inactive">';
			$output .=
				'<div class="megamenu-heading">
					<div class="header-container">
						<span id="megamenu-header-span" class="title-desc">'.$description.'</span>
						<a href="'.$url.'"><h2 id=megamenu-header>'.$title.'</h2><i aria-hidden="true" class="fas fa-chevron-right"></i></a>
						<p id="megamenu-excerpt">'.$extra_description.'</p>
					</div>
					<button tabindex="0" aria-label="previous-menu" class="close-menu-btn" onClick="closeAllMenus()"><i class="fas fa-times"></i><label>'.$btn_text.'</label></button>
				</div>';

		}
		else{
			$submenu =  'sub-menu inactive' ;

		}


		$back_btn_text = __('Takaisin', 'urhea');
		$output .= "<div class=\"$submenu  depth_$depth\">\n";
		if($depth>=0){
			$breadcrumbs = $this->breadcrumbs_parents;
			$current = $this->breadcrumbs_current;
			$output .= '<div aria-hidden="true" class="megamenu-breadcrumbs">'.$breadcrumbs.$current.'</div>';
		}

		$output .= "<button aria-label='close-sub-menu' class='close-submenu-btn' onClick='closeSubMenu(this)'>";
		$output .= "<i class='fas fa-arrow-left'></i>";
		$output .= '<span class="textbox" aria-hidden="true"><i class="fas fa-minus" aria-hidden="true"></i><i class="fas fa-arrow-left" aria-hidden="true"></i><span>'.$back_btn_text.'</span></span>';
		$output .= "</button>";

		$output .= "<ul class=\"menu-items\">\n";

	}

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) { //li

		if($depth===0){
			$this->parent_title=$item->title;
			$this->parent_url=$item->url;
			$this->parent_description= !empty($item->description) ? $item->description : '';

			$extra_description = get_post_meta( $item->ID, '_urhea_extra_description', true );
			$this->parent_extra_description = !empty($extra_description) ? $extra_description : '';

		}


		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        $classes[] = 'menu-item-' . $item->ID;
        if($depth && $args->walker->has_children){
            $classes[] = 'dropdown-submenu';
        }

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'. esc_attr($class_names) . '"';

		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';

		$aria_attributes = "role='menu-item'";
		$aria_attributes .= ($args->walker->has_children) ? "aria-haspopup='true'" : "";
		$aria_attributes .= ($args->walker->has_children) ? "aria-expanded='false'" : "";
		$rootClass = $depth===0 ? "root" : "";
		$submenu_classes = ($args->walker->has_children) ? "class='dropdown-icon depth_$depth $rootClass'" : "";

		$item_output = $args->before;
		$item_output .= $args->link_before . '<a' . $attributes . $aria_attributes . $submenu_classes . '>';
		$item_output .= $args->link_before .  apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';

		$btn_text = __('Laajenna', 'urhea');

		//create megamenu breadcrumbs

		if($args->walker->has_children){

			if($this->prev_depth<$depth){
				$this->breadcrumbs_parents .= $this->breadcrumbs_current;
			}
			else{
				if($this->breadcrumbs_save){
					$this->breadcrumbs_parents = $this->breadcrumbs_save;
				}
				if($depth==1){
					$this->breadcrumbs_parents = $this->breadcrumbs_root;

				}
			}
			$this->breadcrumbs_save = $this->breadcrumbs_parents;
			if($depth==1){
				$this->breadcrumbs_root = $this->breadcrumbs_parents;

			}
			$this->prev_depth = $depth;
			$title = $item->title;
			$this->breadcrumbs_current = '<a' . $attributes . $aria_attributes .' aria-hidden="true" aria-label="breadcrumb-item"><span class="breadcrumb-item">'.$title.'</span></a>';

		}



		if($args->walker->has_children){
			$item_output .= $args->link_before .  '<button type="button" class="menuitem_icon root depth_'.$depth.'" aria-label="open-submenu">';
			$item_output .= '<i class="fas fa-chevron-right" aria-hidden="true"></i>';
			$item_output .= '<i class="fas fa-angle-down" aria-hidden="true"></i>';
			$item_output .= '<span aria-label="open-submenu" class="visually-hidden" >'.$btn_text.'</span>';
			$item_output .= '</button>';
		}

		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

	}

	function end_el(&$output, $item, $depth = 0, $args = array()) {

		// $link = '';

		// ob_start();
		// include(locate_template('partials/navigation-services.php', false, false));
		// $dropdown = ob_get_clean();



		// $output .= $link;
	}

	function end_lvl( &$output, $depth = 0, $args = null ) {

		if ($depth === (int) 0) {
			$output .= "</ul>";
			$output .= "</div>";

			$output .=
						'<div class="newsletter">
							<form action="https://betta.us1.list-manage.com/subscribe/post-json?u=05f0a8cf712254a4c744c19b7&amp;id=4473f1f666&c=?" method="post" id="newsletter-form">
								<div class="form-fields">
									<h3>'.__("Pysy ajantasalla Urhean toiminnasta, tilaa uutiskirje","urhea").'</h3>
									<div>
										<input required="required" aria-label="email inputfield" type="text" name="EMAIL" class="form-input" class="form-email"  placeholder="Sähköpostiosoitteesi" value="">
									</div>
									<div style="position: absolute; left: -5000px;" aria-hidden="true">
										<input aria-label="hidden field" type="text" name="b_05f0a8cf712254a4c744c19b7_4473f1f666" tabindex="-1" value="">
									</div>
									<button type="submit" name="subscribe" id="form-submit" value="Subscribe" class="button" aria-label="Tilaa uutiskirje">
										<span>'.__("Tilaa","urhea").'</span>
									</button>

								</div>
							</form>
						</div>';

			$output .= "</div>";

		}
		else{
			$output .= "</ul>";
			$output .= "</div>";

		}
	}

}



/**
* Add custom fields to menu item
*
* This will allow us to play nicely with any other plugin that is adding the same hook
*
* @param  int $item_id
* @params obj $item - the menu item
* @params array $args
*/
function urhea_custom_fields( $item_id, $item ) {

	wp_nonce_field( 'urhea_extra_description_nonce', '_urhea_extra_description_nonce_name' );
	$urhea_extra_description = get_post_meta( $item_id, '_urhea_extra_description', true );
	?>
	<div class="field-urhea_extra_description description-wide" style="margin: 5px 0;">
	    <span class="description"><?php _e( "Pitempi kuvaus", 'urhea' ); ?></span>
	    <br />

	    <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
	    <div class="logged-input-holder">
	        <input type="text" name="urhea_extra_description[<?php echo $item_id ;?>]" class="widefat" id="custom-menu-meta-for-<?php echo $item_id ;?>" value="<?php echo esc_attr( $urhea_extra_description ); ?>" />
	    </div>

	</div>

	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'urhea_custom_fields', 10, 2 );

/**
* Save the menu item meta
*
* @param int $menu_id
* @param int $menu_item_db_id
*/
function urhea_nav_update( $menu_id, $menu_item_db_id ) {

	// Verify this came from our screen and with proper authorization.
	if ( ! isset( $_POST['_urhea_extra_description_nonce_name'] ) || ! wp_verify_nonce( $_POST['_urhea_extra_description_nonce_name'], 'urhea_extra_description_nonce' ) ) {
		return $menu_id;
	}

	if ( isset( $_POST['urhea_extra_description'][$menu_item_db_id]  ) ) {
		$sanitized_data = sanitize_text_field( $_POST['urhea_extra_description'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_urhea_extra_description', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_urhea_extra_description' );
	}
}

add_action( 'wp_update_nav_menu_item', 'urhea_nav_update', 10, 2 );
