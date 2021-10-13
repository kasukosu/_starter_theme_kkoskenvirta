<?php defined('ABSPATH') || exit(); ?>

<?php
    if( have_rows('referenssit-repeater') ): ?>
        <section class="references block">
            <div class="container grid">
                <?php
                    $i = 0;
                ?>
                <?php while( have_rows("referenssit-repeater") ) : the_row(); ?>
                    <?php
                    $referenssi = get_sub_field('referenssi');
                        switch ($i % 2) {
                            case 0:
                                $class = 'even';
                                break;
                            default:
                                $class = 'odd';
                        }
                        $i++;


                    ?>
                    <article <?php echo "class='$class'";?>>
                        <div class="text">
                            <span><?php echo get_the_title($referenssi[0]->ID);?></span>
                            <h3><a href="<?php the_permalink()?>"><?php echo get_the_excerpt($referenssi[0]->ID) ?></a></h3>
                            <a class="wp-block-button__link alt" href="<?php the_permalink($referenssi[0]->ID)?>">Lue lisää</a>
                            <?php
                                bd_get_tags(3);
                            ?>
                        </div>
                        <div class="media">
                            <figure>
                                <?php echo get_the_post_thumbnail( $referenssi[0]->ID, 'Banner'); ?>
                            </figure>
                        </div>
                    </article>


                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>