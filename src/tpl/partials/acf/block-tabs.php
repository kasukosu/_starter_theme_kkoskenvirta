<?php defined('ABSPATH') || exit();
        if( have_rows('tabs-repeater') ):

?>

<section id="tabs" class="tabs">
	<div class="container grid">

        <h2 class="compact-width">Palvelut</h2>

        <?php
            $i = 0;


            while( have_rows("tabs-repeater") ) : the_row();

            $title = get_sub_field('title');
            $content = get_sub_field('content');

        ?>
		<div class="tab <?php if ($i==0){echo 'active-tab';} ?>">
            <input type="checkbox" name="tabs" id="option-<?php echo $i;?>" <?php if ($i==0){echo 'checked';} ?>>
            <label for="option-<?php echo $i;?>">
                <h3>
                    <span><?php echo $title ?> </span>
                    <span>  </span>
                </h3>
            </label>
            <div>
                <?php echo $content ?>
            </div>

        </div>

        <?php $i++; endwhile; ?>


	</div>

</section>

<?php endif; ?>