<?php /* Template Name: Template Name */ ?>


<?php get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
        $content = get_post_field('post_content', get_the_ID());
        $content_parts = get_extended($content);
        $before_more = $content_parts['main'];
        $after_more = $content_parts['extended'];
	?>


<main>
    <?php include(locate_template('partials/hero.php', false, false)); ?>
    <section class="articles">
        <div class="container">
            <article class="content" id="contact">
                <?php the_content(null, true); ?>
            </article>
        </div>
    </section>
</main>

<?php endwhile; endif; ?>


<?php get_footer(); ?>
