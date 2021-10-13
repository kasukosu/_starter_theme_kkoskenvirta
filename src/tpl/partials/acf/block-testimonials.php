<?php defined('ABSPATH') || exit();?>
    <?php if( have_rows('asiakaskertomukset') ): ?>
        <section id="asiakastarinat" class="content testimonials swiper-container snap">
            <h2 class="compact-width text-align-center">Asiakkaamme kertovat</h2>
            <div class="swiper-wrapper">
                <?php while( have_rows("asiakaskertomukset") ) : the_row();

                $title = get_sub_field('asiakas');
                $content = get_sub_field('kertomus');
                $link = get_sub_field('linkki');
                ?>
                    <div class="swiper-slide">
                            <blockquote>
                                <?php echo $content; ?>
                                <p>
                                    <?php echo $title ?>
                                </p>
                                <p class="link">
                                    <a class="wp-block-button__link" href="<?php echo $link; ?>" title="Lue referenssi">Lue referenssi</a>
                                </p>
                            </blockquote>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>

            </div>
            <div class="swiper-pagination"></div>

        </section>
    <?php endif; ?>