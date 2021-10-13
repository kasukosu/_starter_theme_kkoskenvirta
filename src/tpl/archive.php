<?php get_header();?>

<?php if (have_posts()) : ?>

    <?php
        $content = get_post_field('post_content', get_the_ID());
        $content_parts = get_extended($content);
        $before_more = $content_parts['main'];
        $after_more = $content_parts['extended'];
	?>
    <main>

        <section class="archive">
            <div class="container">
                <h1>Archive Title</h2>
            </div>
            <?php include(locate_template('partials/breadcrumb.php', false, false)); ?>

            <div class="container grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>">
                        <div class="text">
                            <h3><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
                            <?php the_excerpt();?>
                            <a class="wp-block-button__link" href="<?php the_permalink()?>">Lue lisää</a>
                            <?php
                                bd_get_tags(3);
                            ?>
                        </div>
                        <div class="media">
                            <figure>
                                <?php the_post_thumbnail('Banner')?>
                            </figure>
                        </div>
                    </article>
                <?php endwhile;  ?>

            </div>
            <div class="pagination">
                <div>
                    <div class="prev">
                        <?php previous_posts_link( 'Edellinen sivu' ); ?>
                    </div>

                    <div class="next">
                        <?php next_posts_link( 'Seuraava sivu' ); ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php endif; ?>
<?php get_footer(); ?>
