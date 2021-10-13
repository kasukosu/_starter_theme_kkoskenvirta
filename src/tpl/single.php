<?php get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
        $content = get_post_field('post_content', get_the_ID());
        $content_parts = get_extended($content);
        $before_more = $content_parts['main'];
        $after_more = $content_parts['extended'];
	?>


<main>
    <?php include(locate_template('partials/sections/hero.php', false, false)); ?>

    <section class="articles ">
        <div class="container">
            <article class="content grid columns">
                <?php if(in_category("blogi")) : ?>
                    <span class="date"><?php the_date("d.m.Y"); ?></span>
                <?php endif; ?>
                <?php the_content(null, true); ?>
            </article>
        </div>
    </section>

    <?php include(locate_template('partials/acf/block-service-form.php', false, false)); ?>

    <?php include(locate_template('partials/acf/block-testimonials.php', false, false)); ?>

    <?php include(locate_template('partials/acf/block-references.php', false, false)); ?>


</main>

<?php endwhile; endif; ?>


<?php get_footer(); ?>
