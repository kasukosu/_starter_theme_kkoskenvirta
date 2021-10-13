<?php

defined('ABSPATH') || exit();

?>

<section class="chat-container">
    <div class="wrapper grid">
        <button id="close-chat" class="btn-close icon close"><span >Sulje</span></button>
        <div class="form">
            <?php echo do_shortcode('[contact-form-7 id="638" title="Yhteydenottolomake pop-up"]')?>
        </div>
        <div class="inner-wrapper grid">
            <div class="contact grid">
                <a href="tel:+358503270702"><span>Soita +358 50 32707 02</span></a>
                <a href="mailto:palvelu@betta.fi"><span>palvelu@betta.fi</span></a>
            </div>
            <div class="social grid">
                <li><a href="https://www.facebook.com/bettadigital/"><img src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/logo-facebook.svg" alt="Facebook"></a></li>
                <li><a href="https://www.instagram.com/bettadigital/"><img src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/logo-instagram.svg" alt="Instagram"></a></li>
                <li><a href="https://www.linkedin.com/company/betta-digital-oy/"><img src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/logo-linkedin.svg" alt="Linkedin"></a></li>
            </div>
        </div>
    </div>
</section>

<button class="floating-button"><img src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/Contact-bubble.svg" alt="Ota yhteyttä"></button>