<?php defined('ABSPATH') || exit();?>
    <?php if( have_rows('carousel-repeater') ): ?>
        <section id="references-carousel" class="content swiper-container snap references-carousel">
            <h2 class="text-align-center">Yhteistyössä</h2>
            <div class="swiper-wrapper">
                <?php
                    $counter = 0;
                    $rows = get_field('carousel-repeater');
                    while( $counter < count($rows) ) :

                ?>

                    <div class="swiper-slide">
                        <div class="grid">
                            <?php for ($i=0; $i < 8; $i++) :
                                $index = $i+$counter;
                                $row = $rows[$index];
                                $logo = $row['logo'];
                            ?>
                                <?php if($logo) : ?>
                                    <img src="<?php echo $logo['url'];?>" alt="logo">
                                <?php endif;?>
                            <?php endfor;?>
                        </div>
                    </div>
                    <?php $counter = $counter + 8; ?>

                <?php
                    endwhile;
                ?>

            </div>
            <div class="swiper-pagination"></div>

        </section>
    <?php endif; ?>
