<?php
/**
 * Shams Al Bosnia - theme bootstrap.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'SHAMS_VERSION', '1.0.0' );
define( 'SHAMS_DIR', get_template_directory() );
define( 'SHAMS_URI', get_template_directory_uri() );

require SHAMS_DIR . '/inc/defaults.php';
require SHAMS_DIR . '/inc/template-functions.php';
require SHAMS_DIR . '/inc/vehicles.php';
require SHAMS_DIR . '/inc/customizer.php';

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
	add_theme_support( 'editor-styles' );

	register_nav_menus( array(
		'primary' => __( 'Header Menu', 'shams-albosnia' ),
		'footer'  => __( 'Footer Quick Links', 'shams-albosnia' ),
	) );

	add_image_size( 'shams-card', 760, 480, true );
	add_image_size( 'shams-hero', 1600, 900, true );
}
add_action( 'after_setup_theme', 'shams_setup' );

/* ---------- Assets ---------- */
function shams_assets() {
	// Fonts: Playfair Display (serif headings) + Inter (sans body) + Cairo/Amiri for Arabic.
	wp_enqueue_style( 'shams-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800;900&family=Inter:wght@400;500;600;700&family=Cairo:wght@400;600;700&family=Amiri:wght@700&display=swap', array(), null ); // phpcs:ignore

	$css = SHAMS_DIR . '/assets/css/theme.css';
	wp_enqueue_style( 'shams-theme', SHAMS_URI . '/assets/css/theme.css', array( 'shams-fonts' ), filemtime( $css ) );

	$js = SHAMS_DIR . '/assets/js/theme.js';
	wp_enqueue_script( 'shams-theme', SHAMS_URI . '/assets/js/theme.js', array(), filemtime( $js ), true );

	// Pass runtime config to JS (whatsapp number for click-to-chat, default lang).
	wp_localize_script( 'shams-theme', 'SHAMS_CFG', array(
		'wa'      => shams_wa_number(),
		'default' => 'bs',
	) );
}
add_action( 'wp_enqueue_scripts', 'shams_assets' );

function shams_editor_assets() {
	wp_enqueue_style( 'shams-editor', SHAMS_URI . '/assets/css/theme.css', array(), SHAMS_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'shams_editor_assets' );

/* ---------- Widget areas (footer columns can be replaced by widgets if you prefer) ---------- */
function shams_widgets() {
	register_sidebar( array( 'name'=>'Footer Col 1','id'=>'footer-1','before_widget'=>'<div class="fw-widget %1$s">%2$s</div>','after_widget'=>'</div>','before_title'=>'<h4 class="fw-title">','after_title'=>'</h4>' ) );
	register_sidebar( array( 'name'=>'Footer Col 2','id'=>'footer-2','before_widget'=>'<div class="fw-widget %1$s">%2$s</div>','after_widget'=>'</div>','before_title'=>'<h4 class="fw-title">','after_title'=>'</h4>' ) );
	register_sidebar( array( 'name'=>'Footer Col 3','id'=>'footer-3','before_widget'=>'<div class="fw-widget %1$s">%2$s</div>','after_widget'=>'</div>','before_title'=>'<h4 class="fw-title">','after_title'=>'</h4>' ) );
	register_sidebar( array( 'name'=>'Footer Col 4','id'=>'footer-4','before_widget'=>'<div class="fw-widget %1$s">%2$s</div>','after_widget'=>'</div>','before_title'=>'<h4 class="fw-title">','after_title'=>'</h4>' ) );
}
add_action( 'widgets_init', 'shams_widgets' );

/* ---------- Elementor integration ---------- */
function shams_elementor_support() {
	add_theme_support( 'elementor' );
	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::instance()->files_manager->clear_cache();
	}
}
add_action( 'after_setup_theme', 'shams_elementor_support', 20 );
add_action( 'init', function(){ if ( class_exists('\Elementor\Plugin') ) { \Elementor\Plugin::instance(); } }, 11 );
require_once SHAMS_DIR . '/inc/elementor-widgets.php';

/* ---------- Flush rewrites once on activation ---------- */
function shams_flush() { shams_register_vehicle_cpt(); flush_rewrite_rules(); }
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
