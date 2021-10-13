<?php

defined('ABSPATH') || exit();

$alignment = get_query_var('promo/alignment') ?: 'align-left';
$promo_id = get_query_var('promo/selectedPost');
?>

<div class="wp-block-promo <?php print esc_attr($alignment); ?>">
	<div class="article">
		<div>
			<p class="extra-title">
				<a href="<?php print get_the_permalink($promo_id); ?>">
					<span><?php print get_the_excerpt($promo_id) ?></span>
				</a>
			</p>
			<h3 class="title">
				<a href="<?php print get_the_permalink($promo_id); ?>">
					<span><?php print get_the_title($promo_id); ?></span>
				</a>
			</h3>
			<p class="read-more">
				<a href="<?php print get_the_permalink($promo_id); ?>">
					<span>Lue lisää »</span>
				</a>
			</p>
		</div>
	</div>
</div>
