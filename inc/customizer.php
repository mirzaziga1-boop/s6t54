<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function shams_customize_register( $wp ) {
	$wp->add_section( 'shams_brand', array( 'title'=>__( 'Brand & Logo','shams-albosnia' ), 'priority'=>20 ) );
	$wp->add_section( 'shams_topbar', array( 'title'=>__( 'Top Bar','shams-albosnia' ), 'priority'=>21 ) );
	$wp->add_section( 'shams_contact', array( 'title'=>__( 'Contact & WhatsApp','shams-albosnia' ), 'priority'=>22 ) );
	$wp->add_section( 'shams_social', array( 'title'=>__( 'Social Links','shams-albosnia' ), 'priority'=>23 ) );
	$wp->add_section( 'shams_copy', array( 'title'=>__( 'Trilingual Headlines (BS/EN/AR)','shams-albosnia' ), 'priority'=>24, 'description'=>__( 'These edit the hero / fleet / steps / why-us / footer headings. Card lists are edited with the Elementor section widgets.','shams-albosnia' ) ) );
	$wp->add_section( 'shams_footer', array( 'title'=>__( 'Footer Promo','shams-albosnia' ), 'priority'=>25 ) );

	// Brand
	$wp->add_setting( 'shams_brand_tagline', array( 'default'=>'Rent a Car & Tourism','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_brand_tagline', array( 'label'=>__('Tagline','shams-albosnia'),'section'=>'shams_brand' ) );

	// Top bar (hours is trilingual; address/phone universal)
	$wp->add_setting( 'shams_address', array( 'default'=>'Milana Preloga 12A, 71000 Sarajevo, Bosnia and Herzegovina','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_address', array( 'label'=>__('Address','shams-albosnia'),'section'=>'shams_topbar' ) );
	shams_ml_control( $wp, 'shams_topbar_hours', 'shams_topbar', __( 'Opening Hours','shams-albosnia' ),
		'Pon - Ned: 08:00 - 22:00 (Dostava na Aerodrom Sarajevo 24/7)',
		'Mon - Sun: 08:00 - 22:00 (Sarajevo Airport Delivery 24/7)',
		'الاثنين - الأحد: ٠٨:٠٠ - ٢٢:٠٠ (توصيل مطار سراييفو على مدار الساعة)', 'textarea' );
	$wp->add_setting( 'shams_currency', array( 'default'=>'$|KM|$','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_currency', array( 'label'=>__('Currency pills (pipe-separated)','shams-albosnia'),'section'=>'shams_topbar','description'=>__('e.g. $|KM|$','shams-albosnia') ) );

	// Contact
	$wp->add_setting( 'shams_phone', array( 'default'=>'+387 61 228 100','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_phone', array( 'label'=>__('Phone (display)','shams-albosnia'),'section'=>'shams_contact' ) );
	$wp->add_setting( 'shams_whatsapp', array( 'default'=>'38761228100','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_whatsapp', array( 'label'=>__('WhatsApp number (digits, intl)','shams-albosnia'),'section'=>'shams_contact','description'=>__('Used by all WhatsApp buttons & float.','shams-albosnia') ) );
	$wp->add_setting( 'shams_email', array( 'default'=>'info@shamsalbosnia.com','sanitize_callback'=>'sanitize_email' ) );
	$wp->add_control( 'shams_email', array( 'label'=>__('Email','shams-albosnia'),'section'=>'shams_contact' ) );

	// Social
	foreach ( array( 'facebook','instagram','youtube','tiktok' ) as $s ) {
		$wp->add_setting( 'shams_social_'.$s, array( 'default'=>'','sanitize_callback'=>'esc_url_raw' ) );
		$wp->add_control( 'shams_social_'.$s, array( 'label'=>ucfirst($s).' URL','section'=>'shams_social','type'=>'url' ) );
	}

	// Trilingual headlines (hero / fleet / steps / whyus / footer-about)
	shams_ml_control( $wp, 'shams_hero_title', 'shams_copy', __('Hero Title','shams-albosnia'),
		'Istražite Bosnu sa stilom, udobnošću i sigurnošću','Explore Bosnia with style, comfort and safety','استكشف البوسنة بأناقة وراحة وأمان','textarea' );
	shams_ml_control( $wp, 'shams_hero_subtitle', 'shams_copy', __('Hero Subtitle','shams-albosnia'),
		'Premium SUV-ovi, izvršne limuzine i porodični kombiji. Besplatna dostava na Aerodrom Sarajevo, 24/7 podrška i paketi neograničene kilometraže.',
		'Premium SUVs, executive limousines and family vans. Free delivery to Sarajevo Airport, 24/7 support and unlimited-mileage packages.',
		'سيارات SUV فاخرة، وليموزين تنفيذية، وفانات عائلية. توصيل مجاني إلى مطار سراييفو، دعم على مدار الساعة، وباقات كيلومترات غير محدودة.','textarea' );
	shams_ml_control( $wp, 'shams_hero_btn1', 'shams_copy', __('Hero Button 1','shams-albosnia'),'Pogledajte Ponudu Auta','View Our Fleet','عرض أسطول السيارات' );
	shams_ml_control( $wp, 'shams_hero_btn2', 'shams_copy', __('Hero Button 2','shams-albosnia'),'Brzi WhatsApp Upit','Quick WhatsApp Enquiry','استفسار سريع عبر واتساب' );
	shams_ml_control( $wp, 'shams_fleet_title', 'shams_copy', __('Fleet Title','shams-albosnia'),'Naša Flota Automobila','Our Vehicle Fleet','أسطول سياراتنا' );
	shams_ml_control( $wp, 'shams_fleet_subtitle', 'shams_copy', __('Fleet Subtitle','shams-albosnia'),
		'Izaberite između naših redovno servisirkanih i novih vozila spremnih za put.','Choose from our regularly serviced and brand-new vehicles, ready for the road.','اختر من بين مركباتنا التي تخضع لصيانة دورية والمركبات الجديدة الجاهزة للطريق.','textarea' );
	shams_ml_control( $wp, 'shams_steps_title', 'shams_copy', __('Steps Title','shams-albosnia'),'Jednostavan proces u 3 koraka','Simple 3-Step Process','عملية بسيطة من 3 خطوات' );
	shams_ml_control( $wp, 'shams_whyus_title', 'shams_copy', __('Why-Us Title','shams-albosnia'),'Zašto zahtjevni putnici biraju nas','Why Discerning Travelers Choose Us','لماذا يختارنا المسافرون المتميزون' );
	shams_ml_control( $wp, 'shams_footer_about', 'shams_copy', __('Footer About Text','shams-albosnia'),
		'Shams Al Bosnia pruža usluge iznajmljivanja vozila i prilagođenih turističkih aranžmana u Sarajevu i BiH.',
		'Shams Al Bosnia provides vehicle rental and tailored tourism arrangements in Sarajevo and BiH.',
		'توفر شمس البوسنة خدمات تأجير المركبات وبرامج سياحية مخصصة في سراييفو والبوسنة والهرسك.','textarea' );

	// Footer promo
	$wp->add_setting( 'shams_pkg_url', array( 'default'=>'','sanitize_callback'=>'esc_url_raw' ) );
	$wp->add_control( 'shams_pkg_url', array( 'label'=>__('Theme .ZIP download URL','shams-albosnia'),'section'=>'shams_footer','type'=>'url','description'=>__('Leave empty to hide the download button.','shams-albosnia') ) );
	$wp->add_setting( 'shams_copy_line', array( 'default'=>'© 2026 Shams Al Bosnia. Sva prava zadržana.','sanitize_callback'=>'sanitize_text_field' ) );
	$wp->add_control( 'shams_copy_line', array( 'label'=>__('Copyright line','shams-albosnia'),'section'=>'shams_footer' ) );
}
add_action( 'customize_register', 'shams_customize_register' );

/* Register a BS + _en + _ar control trio. */
function shams_ml_control( $wp, $key, $section, $label, $bs, $en, $ar, $type = 'text' ) {
	$wp->add_setting( $key, array( 'default'=>$bs,'sanitize_callback'=> $type==='textarea'?'sanitize_textarea_field':'sanitize_text_field' ) );
	$wp->add_control( $key, array( 'label'=>$label.' (BS)','section'=>$section,'type'=>$type ) );
	$wp->add_setting( $key.'_en', array( 'default'=>$en,'sanitize_callback'=> $type==='textarea'?'sanitize_textarea_field':'sanitize_text_field' ) );
	$wp->add_control( $key.'_en', array( 'label'=>$label.' (EN)','section'=>$section,'type'=>$type ) );
	$wp->add_setting( $key.'_ar', array( 'default'=>$ar,'sanitize_callback'=> $type==='textarea'?'sanitize_textarea_field':'sanitize_text_field' ) );
	$wp->add_control( $key.'_ar', array( 'label'=>$label.' (AR)','section'=>$section,'type'=>$type ) );
}
