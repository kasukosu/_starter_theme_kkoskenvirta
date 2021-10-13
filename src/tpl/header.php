<!DOCTYPE html>
<html lang="<?php print get_locale(); ?>">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/favicon-16x16.png">
		<link rel="manifest" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/manifest.json">
		<link rel="mask-icon" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/safari-pinned-tab.svg" color="#0A9EED">
		<link rel="shortcut icon" href="<?php print get_template_directory_uri(); ?>/assets/img/favicons/favicon.ico">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-config" content="<?php print get_template_directory_uri(); ?>/assets/img/favicons/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
		<?php wp_head() ?>
        <link rel="shortcut icon" href="#">
		<script src="https://kit.fontawesome.com/25a65fb647.js" crossorigin="anonymous"></script>
		<!-- <link rel="preload" href="<?php print get_stylesheet_directory_uri(); ?>/assets/fonts/Poppins-SemiBold.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="<?php print get_stylesheet_directory_uri(); ?>/assets/fonts/Poppins-Medium.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="<?php print get_stylesheet_directory_uri(); ?>/assets/fonts/Poppins-ExtraBold.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="<?php print get_stylesheet_directory_uri(); ?>/assets/fonts/Poppins-Regular.woff2" as="font" type="font/woff2" crossorigin> -->
		<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-84716129-1"></script> -->
		<!-- <script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('consent', 'default', {
                'ad_storage': 'denied',
                'analytics_storage': 'denied'

            });
			gtag('js', new Date());
			gtag('config', 'GTAG HERE');
		</script> -->

	</head>
	<body <?php body_class(); ?>>
		<div class="wrapper">
		<header>
			<div class="container">
				<div class="brand">
					<a href="/">
						<img class="large" src="<?php print get_stylesheet_directory_uri(); ?>/assets/img/logo.svg" alt="Betta Logo">
					</a>
				</div>
				<nav>
					<?php
						print get_the_menu("header-menu-short");
					?>
					<?php
						$shortcut = get_field("shortcut");
						if(!$shortcut){
							$shortcut_url = get_the_permalink(19);
							$shortcut_title = __("Referenssit");
							if(in_category("referenssit")){
								$shortcut_url = get_the_permalink(203);
								$shortcut_title = __("Ota yhteyttä");
							}
						}else{
							$shortcut_url = $shortcut['url'];
							$shortcut_title = $shortcut['title'];
						}
					?>
					<div class="shortcut">
						<a href="<?php echo $shortcut_url;?>" class="wp-block-button__link"><?php echo $shortcut_title?></a>
					</div>

					<button class="hamburger" aria-label="Open menu">
						<div id="nav-icon">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</button>
				</nav>
			</div>

		</header>
		<nav id="menu-primary" class="menu side-menu">
			<div class="content">
				<?php print get_the_menu("header-menu-primary");?>
			</div>
		</nav>


		<nav id="menu-secondary" class="menu secondary">
			<div class="content">
				<button class="btn-close icon close" id="close-secondary" onclick="closeMenus();"><span >Sulje</span></button>
				<div class="column left">
					<?php print get_the_menu('header-menu-secondary'); ?>
				</div>
				<div class="column right">
					<?php print get_the_menu('header-menu-tertiary'); ?>
				</div>
			</div>
		</nav>

		<div id="menu-bg" class="background" onclick="closeMenus();"></div>
		<div id="menu-bg-2" class="background" onclick="closeMenus();"></div>

		<button id="scrollToTop" class="scrollToTop" aria-label="scroll back to top">
			<svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
				<path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"></path>
			</svg>
		</button>
