<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Each ml() = array( 'bs'=>.., 'en'=>.., 'ar'=>.. ). Templates print bs visibly + data-i18n-* attrs for live swap. */
function shams_ml( $bs, $en = '', $ar = '' ) {
	return array( 'bs' => $bs, 'en' => ( $en !== '' ? $en : $bs ), 'ar' => ( $ar !== '' ? $ar : $bs ) );
}

function shams_default_hero() {
	return array(
		'eyebrow'  => shams_ml( 'شمس البوسنة • SHAMS ALBOSNIA' ),
		'title'    => shams_ml(
			'Istražite Bosnu sa stilom, udobnošću i sigurnošću',
			'Explore Bosnia with style, comfort and safety',
			'استكشف البوسنة بأناقة وراحة وأمان'
		),
		'subtitle' => shams_ml(
			'Premium SUV-ovi, izvršne limuzine i porodični kombiji. Besplatna dostava na Aerodrom Sarajevo, 24/7 podrška i paketi neograničene kilometraže.',
			'Premium SUVs, executive limousines and family vans. Free delivery to Sarajevo Airport, 24/7 support and unlimited-mileage packages.',
			'سيارات SUV فاخرة، وليموزين تنفيذية، وفانات عائلية. توصيل مجاني إلى مطار سراييفو، دعم على مدار الساعة، وباقات كيلومترات غير محدودة.'
		),
		'btn1' => shams_ml( 'Pogledajte Ponudu Auta', 'View Our Fleet', 'عرض أسطول السيارات' ),
		'btn2' => shams_ml( 'Brzi WhatsApp Upit', 'Quick WhatsApp Enquiry', 'استفسار سريع عبر واتساب' ),
		'features' => array(
			array( 'icon'=>'plane',  'title'=>shams_ml('Besplatna dostava na Aerodrom SJ','Free Delivery to SJ Airport','توصيل مجاني إلى مطار SJ'), 'sub'=>shams_ml('Sarajevo SJ Terminal 24/7','Sarajevo SJ Terminal 24/7','مطار سراييفو SJ على مدار الساعة') ),
			array( 'icon'=>'shield', 'title'=>shams_ml('Kasko osiguranje dostupno','Casco Insurance Available','تأمين شامل متاح'), 'sub'=>shams_ml('Zero Excess Super CDW Option','Zero Excess Super CDW Option','خيار CDW فائق بدون استقطاع') ),
			array( 'icon'=>'gauge',  'title'=>shams_ml('Neograničena kilometraža','Unlimited Mileage','كيلومترات غير محدودة'), 'sub'=>shams_ml('Explore All of Bosnia','Explore All of Bosnia','استكشف كل البوسنة') ),
			array( 'icon'=>'users',  'title'=>shams_ml('Specijalizovano za porodične goste','Specialised for Family Guests','متخصصون للضيوف العائليين'), 'sub'=>shams_ml('Arabic & English Speaking Staff','Arabic & English Speaking Staff','طاقم يتحدث العربية والإنجليزية') ),
		),
	);
}

function shams_default_fleet() {
	return array(
		'eyebrow'  => shams_ml( 'SHAMS ALBOSNIA FLEET' ),
		'title'    => shams_ml( 'Naša Flota Automobila', 'Our Vehicle Fleet', 'أسطول سياراتنا' ),
		'subtitle' => shams_ml(
			'Izaberite između naših redovno servisirkanih i novih vozila spremnih za put.',
			'Choose from our regularly serviced and brand-new vehicles, ready for the road.',
			'اختر من بين مركباتنا التي تخضع لصيانة دورية والمركبات الجديدة الجاهزة للطريق.'
		),
	);
}

function shams_default_steps() {
	return array(
		'eyebrow'  => shams_ml( 'KAKO FUNKCIONIŠE NAJAM', 'HOW RENTAL WORKS', 'كيف يعمل التأجير' ),
		'title'    => shams_ml( 'Jednostavan proces u 3 koraka', 'Simple 3-Step Process', 'عملية بسيطة من 3 خطوات' ),
		'subtitle' => shams_ml( 'Jednostavno, transparentno, bez komplikacija sa papirima.', 'Simple, transparent, no paperwork complications.', 'بسيط وشفاف وبدون تعقيدات ورقية.' ),
		'items' => array(
			array( 'num'=>'1', 'title'=>shams_ml('1. Izaberite Vozilo','1. Choose Your Vehicle','١. اختر مركبتك'), 'text'=>shams_ml('Izaberite između kompaktnih auta, 4x4 džipova za planine ili prostranih kombija za porodice.','Pick from compact cars, 4x4 SUVs for the mountains or spacious family vans.','اختر بين السيارات المدمجة، أو سيارات الدفع الرباعي للجبال، أو الفانات الواسعة للعائلات.') ),
			array( 'num'=>'2', 'title'=>shams_ml('2. Brza WhatsApp Potvrda','2. Quick WhatsApp Confirmation','٢. تأكيد سريع عبر واتساب'), 'text'=>shams_ml('Pošaljite termine i broj leta direktno našem agentu na bosanskom, engleskom ili arapskom.','Send your dates and flight number straight to our agent in Bosnian, English or Arabic.','أرسل التواريخ ورقم الرحلة مباشرة إلى وكيلنا بالبوسنية أو الإنجليزية أو العربية.') ),
			array( 'num'=>'3', 'title'=>shams_ml('3. Preuzimanje na Aerodromu','3. Pickup at the Airport','٣. الاستلام في المطار'), 'text'=>shams_ml('Naš agent vas čeka s čistim i natankanim autom čim izađete iz dolaznog terminala u Sarajevu.','Our agent waits with a clean, full-tank car as soon as you exit the arrivals terminal in Sarajevo.','ينتظرك وكيلنا بسيارة نظيفة وخزان ممتلئ فور خروجك من صالة الوصول في سراييفو.') ),
		),
	);
}

function shams_default_whyus() {
	return array(
		'eyebrow'  => shams_ml( 'ZAŠTO IZABRATI SHAMS AL BOSNIA?', 'WHY CHOOSE SHAMS AL BOSNIA?', 'لماذا تختار شمس البوسنة؟' ),
		'title'    => shams_ml( 'Zašto zahtjevni putnici biraju nas', 'Why Discerning Travelers Choose Us', 'لماذا يختارنا المسافرون المتميزون' ),
		'subtitle' => shams_ml( 'Kombinujemo lokalno bosansko znanje sa najvišim standardima gostoprimstva.', 'We combine local Bosnian knowledge with the highest standards of hospitality.', 'نجمع بين المعرفة البوسنية المحلية وأعلى معايير ضيافة النزلاء.' ),
		'items' => array(
			array( 'icon'=>'users',  'title'=>shams_ml('Gostoprimstvo za goste iz Zaliva','Hospitality for Gulf Guests','ضيافة لضيوف الخليج'), 'text'=>shams_ml('Naše osoblje tečno govori arapski i engleski, uvažavajući sve kulturne i porodične potrebe gostiju.','Our staff speaks fluent Arabic and English, respecting all cultural and family needs of our guests.','يتحدث فريقنا العربية والإنجليزية بطلاقة، محترمين جميع الاحتياجات الثقافية والعائلية للضيوف.') ),
			array( 'icon'=>'shield', 'title'=>shams_ml('Transparentne Cijene Bez Skrivenih Troškova','Transparent Prices, No Hidden Costs','أسعار شفافة بدون تكاليف خفية'), 'text'=>shams_ml('Cijena koju dogovorimo je konačna. Osiguranje, takse i dječije sjedalce uključene po dogovoru.','The price we agree on is final. Insurance, taxes and child seats included by agreement.','السعر الذي نتفق عليه هو النهائي. التأمين والضرائب ومقاعد الأطفال مشمولة بالاتفاق.') ),
			array( 'icon'=>'phone',  'title'=>shams_ml('24/7 Pomoć na Cesti','24/7 Roadside Assistance','مساعدة على الطريق على مدار الساعة'), 'text'=>shams_ml('Putujte opušteno od Sarajeva do Mostara, Bihaća ili Trebinja uz našu stalnu tehničku podršku.','Travel relaxed from Sarajevo to Mostar, Bihać or Trebinje with our constant technical support.','سافر براحة من سراييفو إلى موستار أو بيهاتش أو تربيني مع دعمنا الفني الدائم.') ),
		),
	);
}

function shams_default_footer_about() {
	return shams_ml(
		'Shams Al Bosnia pruža usluge iznajmljivanja vozila i prilagođenih turističkih aranžmana u Sarajevu i BiH.',
		'Shams Al Bosnia provides vehicle rental and tailored tourism arrangements in Sarajevo and BiH.',
		'توفر شمس البوسنة خدمات تأجير المركبات وبرامج سياحية مخصصة في سراييفو والبوسنة والهرسك.'
	);
}
