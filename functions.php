<?php
/**
 * Shams Al Bosnia - defensive bootstrap.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'SHAMS_VERSION', '1.0.0' );
define( 'SHAMS_DIR', get_template_directory() );
define( 'SHAMS_URI', get_template_directory_uri() );

/* ---- SAFE MODE: set define('SHAMS_SAFE_MODE', true); in wp-config.php to recover ---- */
if ( defined( 'SHAMS_SAFE_MODE' ) && SHAMS_SAFE_MODE ) {
	add_action( 'template_redirect', 'shams_safe_render' );
	return; // stop loading the rest; admin stays fully usable
}
function shams_safe_render() {
	header( 'Content-Type: text/html; charset=utf-8' );
	echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
	echo '<title>' . esc_html( get_bloginfo( 'name' ) ) . ' – recovery</title>';
	echo '<style>body{margin:0;background:#0a0a0b;color:#f4f4f5;font:16px/1.6 system-ui,sans-serif;display:grid;place-items:center;min-height:100vh}'
		. '.box{max-width:560px;text-align:center;padding:2rem}.g{color:#d4af37}a{color:#d4af37}</style></head><body>';
	echo '<div class="box"><h1 class="g">' . esc_html( get_bloginfo( 'name' ) ) . '</h1>'
		. '<p>Theme is in <strong>recovery mode</strong> (SHAMS_SAFE_MODE). The site is online and wp‑admin works.</p>'
		. '<p>Fix or re‑upload the broken theme file, then remove <code>SHAMS_SAFE_MODE</code> from wp‑config.php.</p>'
		. '<p><a href="' . esc_url( admin_url() ) . '">Open dashboard</a> · <a href="' . esc_url( home_url( '/' ) ) . '?shams_safe=off">Home</a></p></body></html>';
	exit;
}

/* ---- Safe require: never fatal on a missing file; record it for an admin notice ---- */
$GLOBALS['shams_missing'] = array();
function shams_need( $rel ) {
	$f = SHAMS_DIR . '/' . $rel;
	if ( is_readable( $f ) ) { require $f; return true; }
	$GLOBALS['shams_missing'][] = $rel;
	return false;
}
add_action( 'admin_notices', function () {
	if ( empty( $GLOBALS['shams_missing'] ) ) return;
	echo '<div class="notice notice-error"><p><strong>Shams Al Bosnia:</strong> missing theme file(s): <code>'
		. esc_html( implode( '</code>, <code>', $GLOBALS['shams_missing'] ) )
		. '</code>. Restore them in the correct sub‑folders (see theme readme) or enable SHAMS_SAFE_MODE in wp‑config.php.</p></div>';
} );

shams_need( 'inc/defaults.php' );
shams_need( 'inc/template-functions.php' );
shams_need( 'inc/vehicles.php' );
shams_need( 'inc/customizer.php' );

/* ---------- Setup ---------- */
function shams_setup() {
	load_theme_textdomain( 'shams-albosnia', SHAMS_DIR . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', array( 'search-form','comment-form','comment-list','gallery','caption','style','script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array( 'height'=>64,'width'=>200,'flex-height'=>true,'flex-width'=>true ) );
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus( array( 'primary'=>__( 'Header Menu','shams-albosnia' ), 'footer'=>__( 'Footer Quick Links','shams-albosnia' ) ) );
	}
	add_image_size( 'shams-card', 760, 480, true );
	add_image_size( 'shams-hero', 1600, 900, true );
}
add_action( 'after_setup_theme', 'shams_setup' );

/* ---------- Assets ---------- */
function shams_ver( $rel ) {
	$f = SHAMS_DIR . '/' . $rel;
	return is_readable( $f ) ? (string) filemtime( $f ) : SHAMS_VERSION;
}
function shams_assets() {
	wp_enqueue_style( 'shams-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800;900&family=Inter:wght@400;500;600;700&family=Cairo:wght@400;600;700&family=Amiri:wght@700&display=swap', array(), null ); // phpcs:ignore
	wp_enqueue_style( 'shams-theme', SHAMS_URI . '/assets/css/theme.css', array( 'shams-fonts' ), shams_ver( 'assets/css/theme.css' ) );
	wp_enqueue_script( 'shams-theme', SHAMS_URI . '/assets/js/theme.js', array(), shams_ver( 'assets/js/theme.js' ), true );
	wp_localize_script( 'shams-theme', 'SHAMS_CFG', array( 'wa' => shams_wa_number(), 'default' => 'bs' ) );
}
add_action( 'wp_enqueue_scripts', 'shams_assets' );
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_style( 'shams-editor', SHAMS_URI . '/assets/css/theme.css', array(), SHAMS_VERSION );
} );

/* ---------- Widgets ---------- */
add_action( 'widgets_init', function () {
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array( 'name'=>'Footer Col '.$i, 'id'=>'footer-'.$i,
			'before_widget'=>'<div class="fw-widget %1$s">%2$s</div>', 'after_widget'=>'</div>',
			'before_title'=>'<h4 class="fw-title">', 'after_title'=>'</h4>' ) );
	}
} );

/* ---------- Elementor (loaded only if present; never fatal without it) ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'elementor' );
	if ( class_exists( '\Elementor\Plugin' ) ) { \Elementor\Plugin::instance()->files_manager->clear_cache(); }
}, 20 );
shams_need( 'inc/elementor-widgets.php' ); // optional file; safe_require skips if absent

/* ---------- Activation: flush rewrites, guarded so a missing vehicles.php can't fatal ---------- */
function shams_flush() {
	if ( function_exists( 'shams_register_vehicle_cpt' ) ) { shams_register_vehicle_cpt(); }
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'shams_flush' );

/* ---------- Helpers used by templates ---------- */
function shams_wa_number() {
	$n = preg_replace( '/\D+/', '', (string) get_theme_mod( 'shams_whatsapp', '38761228100' ) );
	return $n !== '' ? $n : '38761228100';
}
function shams_wa_link( $text = '' ) {
	$base = 'https://wa.me/' . shams_wa_number();
	return $text !== '' ? $base . '?text=' . rawurlencode( $text ) : $base;
}
