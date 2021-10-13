<?php defined('ABSPATH') || exit(); ?>



<?php
    $cta = get_field('cta_lomake');
    $img_url = get_field('henkilokuva');
    $name = get_field('nimi');
    $info = get_field('yhteystiedot');
?>


<?php if (has_blocks(get_the_content())) {
    $blocks = parse_blocks(get_the_content());
    foreach ($blocks as $key => $block) {
        if ($block['blockName'] === 'contact-form-7/contact-form-selector') {
            $block_form = $block;
            unset($blocks[$key]);
            break;
        }
    }
}?>

<?php  if (isset($block_form)) : ?>
    <section id="contact-form-anchor" class="contact-form">
        <div class="container grid">
            <div>
                <h4 class="text">
                    <?php echo $cta; ?>
                </h4>
                <div class="person">
                    <figure>
                        <img src="<?php echo $img_url; ?>" alt="<?php echo $name?>">
                    </figure>
                    <div>
                        <h4><?php echo $name?></h4>
                        <span>
                            <?php echo $info?>
                        </span>
                    </div>
                </div>
            </div>
            <?php
                if (isset($block_form)) : ?>
                <?php print apply_filters('the_content', render_block($block_form)); ?>
            <?php endif;?>
        </div>
    </section>
<?php endif;?>
