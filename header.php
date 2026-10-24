<?php
/** Header: top bar + main nav + language switcher + CTAs. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?> dir="ltr" lang="bs">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'shams-body' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'shams-albosnia' ); ?></a>

<div class="shams-site">

	<!-- TOP BAR -->
	<div class="shams-topbar">
		<div class="shams-container shams-topbar-in">
			<div class="shams-topbar-left">
				<span class="tb-item"><?php echo shams_icon('pin',15); ?><span><?php echo esc_html( get_theme_mod('shams_address','Milana Preloga 12A, 71000 Sarajevo, Bosnia and Herzegovina') ); ?></span></span>
				<span class="tb-item"><?php echo shams_icon('clock',15); ?><span <?= shams_ml_attrs( shams_val(array(),'topbar_hours', shams_ml('Pon - Ned: 08:00 - 22:00 (Dostava na Aerodrom Sarajevo 24/7)','Mon - Sun: 08:00 - 22:00 (Sarajevo Airport Delivery 24/7)','الاثنين - الأحد: ٠٨:٠٠ - ٢٢:٠٠ (توصيل مطار سراييفو على مدار الساعة'))) ?> ><?php echo shams_ml_text( shams_val(array(),'topbar_hours', shams_ml('Pon - Ned: 08:00 - 22:00 (Dostava na Aerodrom Sarajevo 24/7)')) ); ?></span></span>
			</div>
			<div class="shams-topbar-right">
				<a class="tb-item tb-phone" href="tel:<?php echo esc_attr( preg_replace('/\s+/','',get_theme_mod('shams_phone','+387 61 228 100')) ); ?>"><?php echo shams_icon('phone',15); ?><span><?php echo esc_html( get_theme_mod('shams_phone','+387 61 228 100') ); ?></span></a>
				<span class="tb-cur">
					<?php $cur = explode('|', get_theme_mod('shams_currency','$|KM|$')); foreach ( $cur as $c ) : if ( trim($c)==='' ) continue; ?><button type="button" class="cur-pill"><?php echo esc_html( trim($c) ); ?></button><?php endforeach; ?>
				</span>
			</div>
		</div>
	</div>

	<!-- MAIN HEADER -->
	<header class="shams-header">
		<div class="shams-container shams-header-in">
			<?php shams_brand( true ); ?>

			<button class="shams-burger" aria-label="Menu" aria-expanded="false"><?php echo shams_icon('menu',24); ?></button>

			<nav class="shams-nav" aria-label="Primary">
				<?php wp_nav_menu( array( 'theme_location'=>'primary','container'=>false,'items_wrap'=>'%3$s','fallback_cb'=>'shams_primary_fallback','link_before'=>'<span data-i18n="','link_after'=>'">'.'</span>','depth'=>1 ) ); ?>
			</nav>

			<div class="shams-header-actions">
				<div class="shams-lang" role="group" aria-label="Language">
					<button type="button" data-lang="bs" class="lang-btn is-active">BS</button>
					<button type="button" data-lang="en" class="lang-btn">EN</button>
					<button type="button" data-lang="ar" class="lang-btn">AR</button>
				</div>
				<?php $pkg = get_theme_mod('shams_pkg_url',''); if ( $pkg ) : ?>
				<a class="shams-btn shams-btn-ghost shams-btn-sm" href="<?php echo esc_url( $pkg ); ?>" download><?php echo shams_icon('download',15); ?><span data-i18n="btn_zip">Theme .ZIP</span></a>
				<?php endif; ?>
				<a class="shams-btn shams-btn-gold shams-btn-sm" href="<?php echo esc_url( shams_wa_link() ); ?>" target="_blank" rel="noopener"><span data-i18n="btn_book">Book Now</span></a>
			</div>
		</div>
	</header>

	<main id="main" class="shams-main">
