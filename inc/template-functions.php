<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Read a setting with priority: $args override -> Customizer -> default ml array. */
function shams_val( $args, $key, $default_ml ) {
	if ( isset( $args[ $key ] ) && $args[ $key ] !== '' && $args[ $key ] !== array() ) {
		$v = $args[ $key ];
		return is_array( $v ) ? $v : shams_ml( $v );
	}
	$mod = get_theme_mod( 'shams_' . $key, '' );
	if ( $mod !== '' ) {
		return shams_ml( $mod, get_theme_mod( 'shams_' . $key . '_en', '' ), get_theme_mod( 'shams_' . $key . '_ar', '' ) );
	}
	return $default_ml;
}
function shams_list( $args, $key, $default_arr ) {
	return ( isset( $args[ $key ] ) && is_array( $args[ $key ] ) && $args[ $key ] ) ? $args[ $key ] : $default_arr;
}

/* Print data-i18n-* attributes for an ml array (visible text = bs). */
function shams_ml_attrs( $ml ) {
	if ( ! is_array( $ml ) ) { $ml = shams_ml( (string) $ml ); }
	$bs = isset( $ml['bs'] ) ? $ml['bs'] : '';
	$en = isset( $ml['en'] ) ? $ml['en'] : $bs;
	$ar = isset( $ml['ar'] ) ? $ml['ar'] : $bs;
	return sprintf( ' data-i18n-bs="%s" data-i18n-en="%s" data-i18n-ar="%s"',
		esc_attr( $bs ), esc_attr( $en ), esc_attr( $ar ) );
}
function shams_ml_text( $ml ) {
	if ( ! is_array( $ml ) ) { return esc_html( $ml ); }
	return esc_html( isset( $ml['bs'] ) ? $ml['bs'] : '' );
}

/* Inline SVG icon set (Feather-style, stroke = currentColor). */
function shams_icon( $name, $size = 20 ) {
	$s = (int) $size;
	$paths = array(
		'plane'   => '<path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/>',
		'shield'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
		'gauge'   => '<path d="M12 14 8 10"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/>',
		'users'   => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'seat'    => '<path d="M5 12V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v7"/><path d="M5 12h11a3 3 0 0 1 3 3v4"/><path d="M5 12v6a2 2 0 0 0 2 2h1"/>',
		'bag'     => '<rect x="4" y="7" width="16" height="14" rx="2"/><path d="M9 7V5a3 3 0 0 1 6 0v2"/>',
		'gear'    => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
		'fuel'    => '<line x1="3" y1="22" x2="15" y2="22"/><line x1="4" y1="9" x2="14" y2="9"/><path d="M14 22V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18"/><path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2 2 2 0 0 0 2-2V9.83a2 2 0 0 0-.59-1.42L18 5"/>',
		'check'   => '<polyline points="20 6 9 17 4 12"/>',
		'whatsapp'=> '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
		'phone'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'mail'    => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
		'clock'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'pin'     => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
		'search'  => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
		'info'    => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
		'arrowup' => '<line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>',
		'download'=> '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
		'menu'    => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>',
		'close'   => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
		'car'     => '<path d="M5 17H3v-5l2-5h12l2 5v5h-2"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/><path d="M5 12h14"/>',
		'sun'     => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
	);
	$p = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['info'];
	return '<svg class="shams-ico" width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p.'</svg>';
}

/* Default menus (so the theme looks right before you assign menus / build pages). */
function shams_primary_fallback() {
	$items = array(
		array('#fleet','nav_fleet'), array('#about','nav_about'), array('#tourism','nav_tourism'),
		array('#terms','nav_terms'), array('#privacy','nav_privacy'), array('#faq','nav_faq'), array('#contact','nav_contact'),
	);
	echo '<ul class="shams-nav-list">';
	foreach ( $items as $it ) {
		printf( '<li><a href="%s"><span data-i18n="%s">%s</span></a></li>',
			esc_url( $it[0] ), esc_attr( $it[1] ), esc_html( shams_dict_bs( $it[1] ) ) );
	}
	echo '</ul>';
}
function shams_footer_fallback() {
	$items = array(
		array('#fleet','nav_fleet'), array('#about','nav_about'), array('#tourism','nav_tourism'),
		array('#terms','nav_terms'), array('#faq','nav_faq'), array('#privacy','nav_privacy'), array('#contact','nav_contact'),
	);
	echo '<ul class="shams-flist">';
	foreach ( $items as $it ) {
		printf( '<li><a href="%s"><span data-i18n="%s">%s</span></a></li>',
			esc_url( $it[0] ), esc_attr( $it[1] ), esc_html( shams_dict_bs( $it[1] ) ) );
	}
	echo '</ul>';
}
/* BS mirror of the JS dictionary for server-side fallback labels. */
function shams_dict_bs( $k ) {
	$m = array(
		'nav_fleet'=>'Vozni Park','nav_about'=>'O Nama','nav_tourism'=>'Turizam BiH','nav_terms'=>'Uslovi Najma',
		'nav_privacy'=>'Politika Privatnosti','nav_faq'=>'Česta Pitanja','nav_contact'=>'Kontakt',
		'btn_book'=>'Book Now','btn_zip'=>'Theme .ZIP',
		'foot_links'=>'Brzi Linkovi','foot_office'=>'Lokacija Kancelarije','foot_pkg'=>'WordPress Tema i Elementor Paket',
		'spec_seats'=>'Sjedišta','spec_bags'=>'Torbi','spec_auto'=>'Automatik','spec_manual'=>'Manual',
		'spec_dizel'=>'Dizel','spec_benzin'=>'Benzin','spec_hibrid'=>'Hibrid','spec_elec'=>'Električni',
		'price_day'=>'/ dan','cdw'=>'CDW Included','btn_details'=>'Više Detalja','btn_wa'=>'WhatsApp',
		'airport_badge'=>'Sarajevo SJ Airport 24/7','search_ph'=>'Pretraži model, SUV, brend…',
		'tab_all'=>'Sva Vozila','tab_dzipovi'=>'Džipovi i SUV','tab_limuzine'=>'Limuzine','tab_luksuzna'=>'Luksuzna Vozila','tab_porodicni'=>'Porodični Kombi (7-8)','tab_ekonomichna'=>'Ekonomična',
	);
	return isset( $m[ $k ] ) ? $m[ $k ] : $k;
}

/* Brand block (custom logo if set, else sun SVG + wordmark). */
function shams_brand( $tagline = true ) {
	echo '<a class="shams-brand" href="'.esc_url( home_url( '/' ) ).'" rel="home">';
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo '<span class="shams-logo-mark">'.shams_icon('sun',34).'</span>';
	}
	echo '<span class="shams-brand-text"><span class="shams-brand-name">'.esc_html( get_bloginfo( 'name', 'display' ) ?: 'SHAMS ALBOSNIA' ).'</span>';
	if ( $tagline ) {
		echo '<span class="shams-brand-tag" data-i18n="brand_tag">'.esc_html( get_bloginfo( 'description', 'display' ) ?: 'Rent a Car & Tourism' ).'</span>';
	}
	echo '</span></a>';
}
