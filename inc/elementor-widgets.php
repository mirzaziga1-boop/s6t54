<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'elementor/elements/categories_registered', function( $m ){ $m->add_category( 'shams', array( 'title'=>__('Shams Al Bosnia','shams-albosnia'),'icon'=>'fa fa-car' ) ); } );

add_action( 'elementor/widgets/register', function( $manager ) {
	if ( ! class_exists( '\Elementor\Widget_Base' ) ) return;
	require_once SHAMS_DIR . '/inc/elementor-widgets.php'; // self-guard below
	foreach ( array( 'Hero','Fleet','Steps','WhyUs' ) as $w ) {
		$cls = 'Shams_El_'. $w;
		if ( class_exists( $cls ) ) $manager->register( new $cls() );
	}
} );
/* Guard against double-include when the action fires after this file already loaded. */
if ( ! defined( 'SHAMS_EL_LOADED' ) ) :
define( 'SHAMS_EL_LOADED', true );

if ( class_exists( '\Elementor\Widget_Base' ) ) :

abstract class Shams_El_Base extends \Elementor\Widget_Base {
	public function get_categories(){ return array( 'shams' ); }
	protected function ml_fields( $prefix, $label, $type='text' ) {
		return array(
			array( 'name'=>$prefix.'_bs','label'=>$label.' (BS)','type'=>$type ),
			array( 'name'=>$prefix.'_en','label'=>$label.' (EN)','type'=>$type ),
			array( 'name'=>$prefix.'_ar','label'=>$label.' (AR)','type'=>$type ),
		);
	}
	protected function ml( $s, $p ) { return shams_ml( $s[$p.'_bs']??'', $s[$p.'_en']??'', $s[$p.'_ar']??'' ); }
	protected function render_part( $slug, $args ) { locate_template( 'template-parts/section-'.$slug.'.php', true, $args ); }
}

class Shams_El_Hero extends Shams_El_Base {
	public function get_name(){ return 'shams-hero'; }
	public function get_title(){ return 'Hero Section'; }
	public function get_icon(){ return 'eicon-slider-push'; }
	protected function _register_controls() {
		$this->start_controls_section( 'content', array( 'label'=>'Hero Content' ) );
		foreach ( $this->ml_fields('eyebrow','Eyebrow') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('title','Title','textarea') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('subtitle','Subtitle','textarea') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('btn1','Button 1 Text') as $f ) $this->add_control( $f['name'], $f );
		$this->add_control( 'btn1_url', array( 'label'=>'Button 1 URL','type'=>\Elementor\Controls_Manager::URL,'default'=>array('url'=>'#fleet') ) );
		foreach ( $this->ml_fields('btn2','Button 2 Text') as $f ) $this->add_control( $f['name'], $f );
		$this->add_control( 'btn2_url', array( 'label'=>'Button 2 URL (or whatsapp)','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'whatsapp' ) );
		$rep = new \Elementor\Repeater();
		foreach ( $this->ml_fields('f_title','Feature Title') as $f ) $rep->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('f_sub','Feature Sub') as $f ) $rep->add_control( $f['name'], $f );
		$rep->add_control( 'icon', array( 'label'=>'Icon','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'plane','options'=>array('plane'=>'Plane','shield'=>'Shield','gauge'=>'Gauge','users'=>'Users','car'=>'Car','phone'=>'Phone') ) );
		$this->add_control( 'features', array( 'label'=>'Feature Cards','type'=>\Elementor\Controls_Manager::REPEATER,'fields'=>$rep->_register_controls(),'default'=>array(
			array('f_title_bs'=>'Besplatna dostava na Aerodrom SJ','f_title_en'=>'Free Delivery to SJ Airport','f_title_ar'=>'توصيل مجاني إلى مطار SJ','f_sub_bs'=>'Sarajevo SJ Terminal 24/7','icon'=>'plane'),
			array('f_title_bs'=>'Kasko osiguranje dostupno','f_title_en'=>'Casco Insurance Available','f_title_ar'=>'تأمين شامل متاح','f_sub_bs'=>'Zero Excess Super CDW Option','icon'=>'shield'),
			array('f_title_bs'=>'Neograničena kilometraža','f_title_en'=>'Unlimited Mileage','f_title_ar'=>'كيلومترات غير محدودة','f_sub_bs'=>'Explore All of Bosnia','icon'=>'gauge'),
			array('f_title_bs'=>'Specijalizovano za porodične goste','f_title_en'=>'Specialised for Family Guests','f_title_ar'=>'متخصصون للضيوف العائليين','f_sub_bs'=>'Arabic & English Speaking Staff','icon'=>'users'),
		) ) );
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$feats = array();
		if ( ! empty( $s['features'] ) ) foreach ( $s['features'] as $f ) $feats[] = array( 'icon'=>$f['icon'],'title'=>$this->ml($f,'f_title'),'sub'=>$this->ml($f,'f_sub') );
		$this->render_part( 'hero', array(
			'eyebrow'=>$this->ml($s,'eyebrow'),'title'=>$this->ml($s,'title'),'subtitle'=>$this->ml($s,'subtitle'),
			'btn1'=>$this->ml($s,'btn1'),'btn1_url'=>$s['btn1_url']['url']?:'#fleet','btn2'=>$this->ml($s,'btn2'),'btn2_url'=>$s['btn2_url'],
			'features'=>$feats,
		) );
	}
}

class Shams_El_Fleet extends Shams_El_Base {
	public function get_name(){ return 'shams-fleet'; }
	public function get_title(){ return 'Fleet / Vehicles'; }
	public function get_icon(){ return 'eicon-posts-grid'; }
	protected function _register_controls() {
		$this->start_controls_section( 'content', array( 'label'=>'Fleet Heading' ) );
		foreach ( $this->ml_fields('eyebrow','Eyebrow') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('title','Title') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('subtitle','Subtitle','textarea') as $f ) $this->add_control( $f['name'], $f );
		$this->add_control( 'per_page', array( 'label'=>'Max vehicles (-1 = all)','type'=>\Elementor\Controls_Manager::NUMBER,'default'=>-1 ) );
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		$this->render_part( 'fleet', array(
			'eyebrow'=>$this->ml($s,'eyebrow'),'title'=>$this->ml($s,'title'),'subtitle'=>$this->ml($s,'subtitle'),
			'per_page'=>(int)$s['per_page'],
		) );
	}
}

class Shams_El_Steps extends Shams_El_Base {
	public function get_name(){ return 'shams-steps'; }
	public function get_title(){ return '3-Step Process'; }
	public function get_icon(){ return 'eicon-number-field'; }
	protected function _register_controls() {
		$this->start_controls_section( 'content', array( 'label'=>'Steps' ) );
		foreach ( $this->ml_fields('eyebrow','Eyebrow') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('title','Title') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('subtitle','Subtitle','textarea') as $f ) $this->add_control( $f['name'], $f );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'num', array( 'label'=>'Number','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'1' ) );
		foreach ( $this->ml_fields('title','Step Title') as $f ) $rep->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('text','Step Text','textarea') as $f ) $rep->add_control( $f['name'], $f );
		$this->add_control( 'items', array( 'label'=>'Steps','type'=>\Elementor\Controls_Manager::REPEATER,'fields'=>$rep->_register_controls(),'default'=>array(
			array('num'=>'1','title_bs'=>'1. Izaberite Vozilo','title_en'=>'1. Choose Your Vehicle','title_ar'=>'١. اختر مركبتك','text_bs'=>'Izaberite između kompaktnih auta, 4x4 džipova za planine ili prostranih kombija za porodice.'),
			array('num'=>'2','title_bs'=>'2. Brza WhatsApp Potvrda','title_en'=>'2. Quick WhatsApp Confirmation','title_ar'=>'٢. تأكيد سريع عبر واتساب','text_bs'=>'Pošaljite termine i broj leta direktno našem agentu na bosanskom, engleskom ili arapskom.'),
			array('num'=>'3','title_bs'=>'3. Preuzimanje na Aerodromu','title_en'=>'3. Pickup at the Airport','title_ar'=>'٣. الاستلام في المطار','text_bs'=>'Naš agent vas čeka s čistim i natankanim autom čim izađete iz dolaznog terminala u Sarajevu.'),
		) ) );
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display(); $items = array();
		if ( ! empty( $s['items'] ) ) foreach ( $s['items'] as $i ) $items[] = array( 'num'=>$i['num'],'title'=>$this->ml($i,'title'),'text'=>$this->ml($i,'text') );
		$this->render_part( 'steps', array( 'eyebrow'=>$this->ml($s,'eyebrow'),'title'=>$this->ml($s,'title'),'subtitle'=>$this->ml($s,'subtitle'),'items'=>$items ) );
	}
}

class Shams_El_WhyUs extends Shams_El_Base {
	public function get_name(){ return 'shams-whyus'; }
	public function get_title(){ return 'Why Choose Us'; }
	public function get_icon(){ return 'eicon-testimonial-carousel'; }
	protected function _register_controls() {
		$this->start_controls_section( 'content', array( 'label'=>'Why Us' ) );
		foreach ( $this->ml_fields('eyebrow','Eyebrow') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('title','Title') as $f ) $this->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('subtitle','Subtitle','textarea') as $f ) $this->add_control( $f['name'], $f );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'icon', array( 'label'=>'Icon','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'users','options'=>array('users'=>'Users','shield'=>'Shield','phone'=>'Phone','gauge'=>'Gauge','car'=>'Car','plane'=>'Plane') ) );
		foreach ( $this->ml_fields('title','Card Title') as $f ) $rep->add_control( $f['name'], $f );
		foreach ( $this->ml_fields('text','Card Text','textarea') as $f ) $rep->add_control( $f['name'], $f );
		$this->add_control( 'items', array( 'label'=>'Cards','type'=>\Elementor\Controls_Manager::REPEATER,'fields'=>$rep->_register_controls(),'default'=>array(
			array('icon'=>'users','title_bs'=>'Gostoprimstvo za goste iz Zaliva','title_en'=>'Hospitality for Gulf Guests','title_ar'=>'ضيافة لضيوف الخليج','text_bs'=>'Naše osoblje tečno govori arapski i engleski, uvažavajući sve kulturne i porodične potrebe gostiju.'),
			array('icon'=>'shield','title_bs'=>'Transparentne Cijene Bez Skrivenih Troškova','title_en'=>'Transparent Prices, No Hidden Costs','title_ar'=>'أسعار شفافة بدون تكاليف خفية','text_bs'=>'Cijena koju dogovorimo je konačna. Osiguranje, takse i dječije sjedalce uključene po dogovoru.'),
			array('icon'=>'phone','title_bs'=>'24/7 Pomoć na Cesti','title_en'=>'24/7 Roadside Assistance','title_ar'=>'مساعدة على الطريق على مدار الساعة','text_bs'=>'Putujte opušteno od Sarajeva do Mostara, Bihaća ili Trebinja uz našu stalnu tehničku podršku.'),
		) ) );
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display(); $items = array();
		if ( ! empty( $s['items'] ) ) foreach ( $s['items'] as $i ) $items[] = array( 'icon'=>$i['icon'],'title'=>$this->ml($i,'title'),'text'=>$this->ml($i,'text') );
		$this->render_part( 'whyus', array( 'eyebrow'=>$this->ml($s,'eyebrow'),'title'=>$this->ml($s,'title'),'subtitle'=>$this->ml($s,'subtitle'),'items'=>$items ) );
	}
}

endif; // class_exists Widget_Base
endif; // SHAMS_EL_LOADED guard
