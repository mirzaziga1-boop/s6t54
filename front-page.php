<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$fid = get_queried_object_id();
$built_with_el = ( class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->documents->is_built_with_elementor( $fid ) );

if ( $built_with_el && have_posts() ) {
	while ( have_posts() ) { the_post(); the_content(); }
} else {
	shams_render_default_home();
}

get_footer();

function shams_render_default_home() {
	echo '<div class="shams-default-home">';
	locate_template( 'template-parts/section-hero.php',  true, array() );
	locate_template( 'template-parts/section-fleet.php', true, array() );
	locate_template( 'template-parts/section-steps.php', true, array() );
	locate_template( 'template-parts/section-whyus.php', true, array() );
	echo '</div>';
}
