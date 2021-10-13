<?php defined('ABSPATH') || exit(); ?>

<?php
$block_id = 'staff-' . $block['id'];
$block_class = '';

$heading = get_field('heading');
$personnel = get_field('personnel');
?>
<section id="personnel" class="personnel">
	<div class="heading">
		<h2><?php print $heading; ?></h2>
	</div>
	<?php if ($personnel) : ?>
		<div  class="grid">
			<?php foreach ($personnel as $person) : ?>
				<?php
				if (empty($person['name'])) {
					continue;
				}
				?>
				<article>
					<figure>
						<?php if (isset($person['image']['sizes']['medium_large'])) : ?>
							<img src="<?php print $person['image']['sizes']['medium_large']; ?>" <?php if($person['story']){echo 'class="has-story"';}?>>
						<?php else : ?>
							<img src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/placeholder-avatar.png">
						<?php endif; ?>
							<button class="btn-close"><span></span></button>
							<div class="text">
								<div>
									<span class="name"><?php print $person['name']; ?></span>
									<span class="role"><?php print $person['role']; ?></span>
									<span class="email"><a href="mailto:<?php print $person['email']; ?>"><?php print $person['email']; ?></a></span>
									<span class="phone"><a href="tel:<?php print $person['phone']; ?>"><?php print $person['phone']; ?></a></span>
								</div>
								<div class="story-box">
									<?php if($person['story']) : ?>
										<span class="story"><?php print $person['story']; ?></span>
									<?php endif;?>
								</div>
							</div>
					</figure>


				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>

<?php if (is_admin()) : ?>
	<style type="text/css">
	.wp-block[data-type="acf/staff"] {
		max-width: 960px;
	}

	.personnel {
		background-color: #ff6699;
		color: #000000;
		max-width: 100%;
		padding: 20px;
		font-size: 14px;
		line-height: 1.5;

		display: grid;
		grid-row-gap: 40px;
	}

	.personnel .heading {
		justify-self: center;
	}

	.personnel .grid {
		display: grid;
		grid-template-columns: 1fr;
		grid-template-rows: 1fr;
		grid-column-gap: 20px;
		grid-row-gap: 20px;
	}

	@media only screen and (min-width: 576px) {
		.personnel .grid {
			grid-column-gap: 40px;
			grid-row-gap: 40px;
		}
	}

	@media only screen and (min-width: 768px) {
		.personnel .grid {
			grid-template-columns: repeat(2, 1fr);
			grid-template-rows: repeat(2, minmax(auto, 400px));
		}
	}

	.personnel .grid article {
		display: flex;
	}

	.personnel .grid article > * {
		margin: 0;
	}

	.personnel .grid article figure {
		display: flex;
		position: relative;
		overflow: hidden;
	}

	.personnel .grid article figure::before {
		content: "";
		position: absolute;
		z-index: 1;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		background-image: linear-gradient(
			to top,
			rgba(6, 42, 76, 0.9),
			rgba(50, 55, 59, 0.1) 90%
		);
	}

	.personnel .grid article figure img {
		position: relative;
		z-index: 0;
		width: auto;
		height: auto;
		object-fit: cover;
	}

	.personnel .grid article figure figcaption {
		position: absolute;
		z-index: 1;
		top: auto;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		height: auto;
		padding: 20px;
		display: grid;
		align-items: end;
	}

	.personnel .grid article figure figcaption div {
		display: grid;
		grid-row-gap: 5px;
	}

	.personnel .grid article figure figcaption div span {
		color: white;
	}

	.personnel .grid article figure figcaption div span.name {
		font-size: 16px;
		font-weight: 700;
	}

	.personnel .grid article figure figcaption div span a {
		color: white;
	}
	</style>
<?php endif;
