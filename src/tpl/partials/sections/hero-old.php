<?php defined('ABSPATH') || exit(); ?>
	<section class="hero">
		<div class="container grid">
			<div class="media">
				<figure>
					<?php the_post_thumbnail('Hero')?>
				</figure>
			</div>
			<div class="content">
				<?php print apply_filters('the_content', $before_more); ?>
			</div>
		</div>
	</section>
	<?php include(locate_template('partials/components/breadcrumb.php', false, false)); ?>









