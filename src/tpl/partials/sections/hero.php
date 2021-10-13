<?php defined('ABSPATH') || exit(); ?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); ?>
<section class="hero"  style="background-image: url('<?php echo $backgroundImg[0]; ?>')">
	<div class="container grid">
        <div class="wrapper">
            <?php print apply_filters('the_content', $before_more); ?>
        </div>
	</div>
</section>