<?php defined('ABSPATH') || exit(); ?>
<?php
    $defaults = [
        'fields'                 => 'ids',
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'cache_results'          => false
    ];
    // Set query args for sticky post query
    $sticky = get_option( 'sticky_posts' );
    $args_sticky = [
        'post__in'  => $sticky,
        'category_name' => 'referenssit',
        'post_status' => 'publish',
        'post_type' => 'post',
        'posts_per_page' => 5,
        'order' => 'DESC',
        'ignore_sticky_posts' => -1
    ];
    // Set query args for normal query
    $args_normal = [
        'post__not_in'  => $sticky,
        'category_name' => 'referenssit',
        'post_status' => 'publish',
        'post_type' => 'post',
        'posts_per_page' => 5,
        'order' => 'DESC',
        'ignore_sticky_posts' => 1

    ];
    $sticky_query = get_posts( array_merge( $defaults, $args_sticky  ) );
    $normal_query = get_posts( array_merge( $defaults, $args_normal ) );

    //Merge both queries
    $merged_query = array_merge($sticky_query, $normal_query);

    if ( $merged_query ) {
        $final_args = [
            'post_type' => 'post',
            'post__in'  => $merged_query,
            'orderby'   => 'post__in',
            'order'     => 'DESC'
        ];
        $the_query = new WP_Query( $final_args );
    }

    $i = 0;
    $first = true;

?>


<?php
if($the_query->have_posts()) : ?>
<section class="references">
	<div class="container grid">

        <?php while(($the_query->have_posts()) && ($i<5)) : $the_query->the_post(); ?>
            <?php


                if ($first) {
                    $class = 'first';
                    $first = false;
                    $i++;
                } else {
                    $i++;
                    switch ($i % 2) {
                        case 0:
                            $class = 'even';
                            break;
                        default:
                            $class = 'odd';
                    }
                }
            ?>
            <article <?php echo "class='$class'";?>>
                <div class="text">
                    <span><?php the_title(); ?></span>
                    <h3><a href="<?php the_permalink()?>"><?php echo get_the_excerpt(); ?></a></h3>
                    <a class="wp-block-button__link alt" href="<?php the_permalink()?>">Lue lisää</a>
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


        <?php endwhile; wp_reset_postdata(); endif;?>
	</div>
</section>
