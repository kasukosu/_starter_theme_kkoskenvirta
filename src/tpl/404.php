<?php get_header(); ?>

<main>
<?php defined('ABSPATH') || exit(); ?>

<section class="hero">
		<div class="container grid double-heading">
                        <h3>Voihan pahus...  😔 </h3>
                        <h1>
                        <?php
                                $page_missing = __('Etsimääsi sivua ei löytynyt.', 'betta');
                                _e($page_missing); ?>
                        </h1>
                        <div>
                                <a class="wp-block-button__link" href="/">Takaisin</a>
                        </div>
		</div>
	</section>

</main>


<?php get_footer(); ?>