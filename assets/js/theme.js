/* Shams Al Bosnia - native i18n + UI. No external translation plugin. */
(function () {
	'use strict';

	/* ---- Dictionary for chrome labels (data-i18n="key") ---- */
	var DICT = {
		bs: {
			brand_tag:'Rent a Car & Tourism', nav_fleet:'Vozni Park', nav_about:'O Nama', nav_tourism:'Turizam BiH',
			nav_terms:'Uslovi Najma', nav_privacy:'Politika Privatnosti', nav_faq:'Česta Pitanja', nav_contact:'Kontakt',
			btn_book:'Book Now', btn_zip:'Theme .ZIP', foot_links:'Brzi Linkovi', foot_office:'Lokacija Kancelarije',
			foot_pkg:'WordPress Tema i Elementor Paket',
			foot_pkg_desc:'Standalone WordPress theme ready for upload to your hosting. Includes mandatory index.php, Elementor template kit, and 3-language support.',
			foot_pkg_btn:'PREUZMI CIJELU TEMU (.ZIP)', foot_pkg_note:'Compatible with WordPress 6.x+, Elementor & Polylang.',
			foot_pkg_link:'WordPress Theme Package (.ZIP)', airport_box:'Sarajevo Airport (SJJ) Delivery 24/7',
			spec_seats:'Sjedišta', spec_bags:'Torbi', spec_auto:'Automatik', spec_manual:'Manual',
			spec_dizel:'Dizel', spec_benzin:'Benzin', spec_hibrid:'Hibrid', spec_elec:'Električni',
			price_day:'/ dan', cdw:'CDW Included', btn_details:'Više Detalja', btn_wa:'WhatsApp',
			airport_badge:'Sarajevo SJ Airport 24/7', search_ph:'Pretraži model, SUV, brend…',
			tab_all:'Sva Vozila', tab_dzipovi:'Džipovi i SUV', tab_limuzine:'Limuzine', tab_luksuzna:'Luksuzna Vozila',
			tab_porodicni:'Porodični Kombi (7-8)', tab_ekonomichna:'Ekonomična',
			no_vehicles:'No vehicles yet. Add them under “Vozni Park” in wp-admin.',
			read_more:'Read more', nothing_found:'Nothing found.', search_results:'Search Results',
			err_404:'Page not found.', back_home:'Back to home', comments_closed:'Comments are closed.'
		},
		en: {
			brand_tag:'Rent a Car & Tourism', nav_fleet:'Fleet', nav_about:'About Us', nav_tourism:'Tourism in BiH',
			nav_terms:'Rental Terms', nav_privacy:'Privacy Policy', nav_faq:'FAQ', nav_contact:'Contact',
			btn_book:'Book Now', btn_zip:'Theme .ZIP', foot_links:'Quick Links', foot_office:'Office Location',
			foot_pkg:'WordPress Theme & Elementor Pack',
			foot_pkg_desc:'Standalone WordPress theme ready for upload to your hosting. Includes mandatory index.php, Elementor template kit, and 3-language support.',
			foot_pkg_btn:'DOWNLOAD FULL THEME (.ZIP)', foot_pkg_note:'Compatible with WordPress 6.x+, Elementor & Polylang.',
			foot_pkg_link:'WordPress Theme Package (.ZIP)', airport_box:'Sarajevo Airport (SJJ) Delivery 24/7',
			spec_seats:'Seats', spec_bags:'Bags', spec_auto:'Automatic', spec_manual:'Manual',
			spec_dizel:'Diesel', spec_benzin:'Petrol', spec_hibrid:'Hybrid', spec_elec:'Electric',
			price_day:'/ day', cdw:'CDW Included', btn_details:'More Details', btn_wa:'WhatsApp',
			airport_badge:'Sarajevo SJ Airport 24/7', search_ph:'Search model, SUV, brand…',
			tab_all:'All Vehicles', tab_dzipovi:'Jeeps & SUVs', tab_limuzine:'Limousines', tab_luksuzna:'Luxury Vehicles',
			tab_porodicni:'Family Vans (7-8)', tab_ekonomichna:'Economy',
			no_vehicles:'No vehicles yet. Add them under “Vozni Park” in wp-admin.',
			read_more:'Read more', nothing_found:'Nothing found.', search_results:'Search Results',
			err_404:'Page not found.', back_home:'Back to home', comments_closed:'Comments are closed.'
		},
		ar: {
			brand_tag:'تأجير سيارات وسياحة', nav_fleet:'الأسطول', nav_about:'من نحن', nav_tourism:'السياحة في البوسنة',
			nav_terms:'شروط التأجير', nav_privacy:'سياسة الخصوصية', nav_faq:'الأسئلة الشائعة', nav_contact:'اتصل بنا',
			btn_book:'احجز الآن', btn_zip:'الثيم .ZIP', foot_links:'روابط سريعة', foot_office:'موقع المكتب',
			foot_pkg:'حزمة ووردبريس وإليمنتور',
			foot_pkg_desc:'ثيم ووردبريس مستقل جاهز للرفع إلى الاستضافة. يتضمن index.php إلزامي، وحزمة قوالب إليمنتور، ودعم ثلاث لغات.',
			foot_pkg_btn:'تنزيل الثيم الكامل (.ZIP)', foot_pkg_note:'متوافق مع ووردبريس 6.x+ وإليمنتور وبوليلانغ.',
			foot_pkg_link:'حزمة ثيم ووردبريس (.ZIP)', airport_box:'توصيل مطار سراييفو (SJJ) على مدار الساعة',
			spec_seats:'مقاعد', spec_bags:'حقائب', spec_auto:'أوتوماتيك', spec_manual:'مانيوال',
			spec_dizel:'ديزل', spec_benzin:'بنزين', spec_hibrid:'هجين', spec_elec:'كهربائي',
			price_day:'/ يوم', cdw:'شامل CDW', btn_details:'المزيد من التفاصيل', btn_wa:'واتساب',
			airport_badge:'مطار سراييفو SJ 24/7', search_ph:'ابحث عن موديل، SUV، علامة…',
			tab_all:'جميع المركبات', tab_dzipovi:'دفع رباعي وSUV', tab_limuzine:'ليموزين', tab_luksuzna:'مركبات فاخرة',
			tab_porodicni:'فانات عائلية (7-8)', tab_ekonomichna:'اقتصادية',
			no_vehicles:'لا توجد مركبات بعد. أضفها من “Vozni Park” في لوحة التحكم.',
			read_more:'اقرأ المزيد', nothing_found:'لا توجد نتائج.', search_results:'نتائج البحث',
			err_404:'الصفحة غير موجودة.', back_home:'العودة للرئيسية', comments_closed:'التعليقات مغلقة.'
		}
	};

	function applyLang(lang) {
		var dict = DICT[lang] || DICT.bs;
		document.querySelectorAll('[data-i18n]').forEach(function (el) {
			var k = el.getAttribute('data-i18n');
			if (dict[k] !== undefined) el.textContent = dict[k];
		});
		document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
			var k = el.getAttribute('data-i18n-placeholder');
			if (dict[k] !== undefined) el.setAttribute('placeholder', dict[k]);
		});
		// inline multilang (vehicle features, customizer/Elementor headlines, card lists)
		document.querySelectorAll('[data-i18n-bs]').forEach(function (el) {
			var v = el.getAttribute('data-i18n-' + lang);
			if (v === null || v === '') v = el.getAttribute('data-i18n-bs');
			if (v !== null) el.textContent = v;
		});
		var html = document.documentElement;
		html.setAttribute('lang', lang);
		html.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
		document.body.classList.toggle('is-rtl', lang === 'ar');
		document.querySelectorAll('.lang-btn').forEach(function (b) {
			b.classList.toggle('is-active', b.getAttribute('data-lang') === lang);
		});
		try { localStorage.setItem('shams_lang', lang); } catch (e) {}
	}
	window.shamsSetLang = applyLang;

	/* ---- Fleet filter + search (scoped per section) ---- */
	function initFleet(section) {
		var tabs = section.querySelectorAll('.shams-tab');
		var search = section.querySelector('.shams-search input');
		var cards = section.querySelectorAll('.shams-vcard');
		var current = 'all', q = '';
		function refresh() {
			cards.forEach(function (c) {
				var okCat = current === 'all' || c.getAttribute('data-category') === current;
				var okQ = !q || (c.getAttribute('data-search') || '').indexOf(q) !== -1;
				c.classList.toggle('is-hidden', !(okCat && okQ));
			});
		}
		tabs.forEach(function (t) { t.addEventListener('click', function () {
			tabs.forEach(function (x) { x.classList.remove('is-active'); });
			t.classList.add('is-active'); current = t.getAttribute('data-filter'); refresh();
		}); });
		if (search) search.addEventListener('input', function () { q = search.value.trim().toLowerCase(); refresh(); });
	}

	document.addEventListener('DOMContentLoaded', function () {
		var saved = 'bs';
		try { saved = localStorage.getItem('shams_lang') || 'bs'; } catch (e) {}
		applyLang(saved);

		document.querySelectorAll('.lang-btn').forEach(function (b) {
			b.addEventListener('click', function () { applyLang(b.getAttribute('data-lang')); });
		});

		document.querySelectorAll('.shams-fleet-section').forEach(initFleet);

		var burger = document.querySelector('.shams-burger');
		if (burger) burger.addEventListener('click', function () {
			var open = document.body.classList.toggle('nav-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		var top = document.querySelector('.shams-float-top');
		if (top) {
			window.addEventListener('scroll', function () { top.classList.toggle('show', window.scrollY > 500); }, { passive: true });
			top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
		}
	});
})();
