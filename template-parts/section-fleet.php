<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$d = shams_default_fleet();
$eyebrow = shams_val( $args, 'eyebrow',  $d['eyebrow'] );
$title   = shams_val( $args, 'title',    $d['title'] );
$sub     = shams_val( $args, 'subtitle', $d['subtitle'] );
$per     = isset($args['per_page']) ? (int)$args['per_page'] : -1;

$terms = get_terms( array( 'taxonomy'=>'vehicle_category','hide_empty'=>false ) );
$tab_map = array( 'dzipovi-i-suv'=>'tab_dzipovi','limuzine'=>'tab_limuzine','luksuzna-vozila'=>'tab_luksuzna','porodicni-kombi'=>'tab_porodicni','ekonomichna'=>'tab_ekonomichna' );

$q = new WP_Query( array( 'post_type'=>'vehicle','posts_per_page'=>$per,'orderby'=>array('meta_value_num'=>'ASC','title'=>'ASC'),'meta_key'=>'_vehicle_order' ) );
?>
<section class="shams-fleet-section" id="fleet">
	<div class="shams-container">
		<p class="shams-eyebrow shams-eyebrow-center"><span class="ln"></span><span <?= shams_ml_attrs($eyebrow) ?> ><?php echo shams_ml_text($eyebrow); ?></span><span class="ln"></span></p>
		<h2 class="shams-sec-title" <?= shams_ml_attrs($title) ?> ><?php echo shams_ml_text($title); ?></h2>
		<p class="shams-sec-sub" <?= shams_ml_attrs($sub) ?> ><?php echo shams_ml_text($sub); ?></p>

		<div class="shams-fleet-bar">
			<div class="shams-tabs" role="tablist">
				<button class="shams-tab is-active" data-filter="all"><span data-i18n="tab_all">Sva Vozila</span></button>
				<?php foreach ( $terms as $t ) : $key = $tab_map[$t->slug] ?? ''; if(!$key) continue; ?>
				<button class="shams-tab" data-filter="<?php echo esc_attr($t->slug); ?>"><span data-i18n="<?php echo esc_attr($key); ?>"><?php echo esc_html(shams_dict_bs($key)); ?></span></button>
				<?php endforeach; ?>
			</div>
			<label class="shams-search"><?php echo shams_icon('search',16); ?><input type="search" data-i18n-placeholder="search_ph" placeholder="Pretraži model, SUV, brend…" aria-label="Search"></label>
		</div>

		<div class="shams-fleet-grid">
			<?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); locate_template('template-parts/content-vehicle.php', true, array() ); endwhile; wp_reset_postdata();
			else : ?><p class="shams-empty" data-i18n="no_vehicles">No vehicles yet. Add them under “Vozni Park” in wp-admin.</p><?php endif; ?>
		</div>
	</div>
</section>
