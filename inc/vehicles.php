<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function shams_register_vehicle_cpt() {
	register_taxonomy( 'vehicle_category', 'vehicle', array(
		'label' => __( 'Vehicle Categories', 'shams-albosnia' ),
		'hierarchical' => true, 'show_admin_column' => true, 'rewrite' => array( 'slug' => 'vehicle-category' ),
		'show_in_rest' => true,
	) );
	register_post_type( 'vehicle', array(
		'labels' => array(
			'name' => __( 'Vehicles', 'shams-albosnia' ), 'singular_name' => __( 'Vehicle', 'shams-albosnia' ),
			'add_new' => __( 'Add Vehicle', 'shams-albosnia' ), 'add_new_item' => __( 'Add New Vehicle', 'shams-albosnia' ),
			'edit_item' => __( 'Edit Vehicle', 'shams-albosnia' ), 'new_item' => __( 'New Vehicle', 'shams-albosnia' ),
			'view_item' => __( 'View Vehicle', 'shams-albosnia' ), 'search_items' => __( 'Search Vehicles', 'shams-albosnia' ),
			'not_found' => __( 'No vehicles found', 'shams-albosnia' ), 'menu_name' => __( 'Vozni Park', 'shams-albosnia' ),
		),
		'public' => true, 'has_archive' => true, 'menu_icon' => 'dashicons-car', 'menu_position' => 20,
		'supports' => array( 'title','editor','thumbnail','excerpt' ),
		'rewrite' => array( 'slug' => 'vozila' ), 'show_in_rest' => true,
		'taxonomies' => array( 'vehicle_category' ),
	) );
}
add_action( 'init', 'shams_register_vehicle_cpt' );

/* Seed categories on activation. */
function shams_seed_cats() {
	if ( ! term_exists( 'Džipovi i SUV', 'vehicle_category' ) ) wp_insert_term( 'Džipovi i SUV', 'vehicle_category', array( 'slug'=>'dzipovi-i-suv' ) );
	if ( ! term_exists( 'Limuzine', 'vehicle_category' ) ) wp_insert_term( 'Limuzine', 'vehicle_category', array( 'slug'=>'limuzine' ) );
	if ( ! term_exists( 'Luksuzna Vozila', 'vehicle_category' ) ) wp_insert_term( 'Luksuzna Vozila', 'vehicle_category', array( 'slug'=>'luksuzna-vozila' ) );
	if ( ! term_exists( 'Porodični Kombi (7-8)', 'vehicle_category' ) ) wp_insert_term( 'Porodični Kombi (7-8)', 'vehicle_category', array( 'slug'=>'porodicni-kombi' ) );
	if ( ! term_exists( 'Ekonomična', 'vehicle_category' ) ) wp_insert_term( 'Ekonomična', 'vehicle_category', array( 'slug'=>'ekonomichna' ) );
}
add_action( 'after_switch_theme', 'shams_seed_cats' );

/* Meta box. */
function shams_vehicle_metabox() {
	add_meta_box( 'shams_vehicle_details', __( 'Vehicle Details', 'shams-albosnia' ), 'shams_vehicle_metabox_cb', 'vehicle', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'shams_vehicle_metabox' );

function shams_vehicle_metabox_cb( $post ) {
	wp_nonce_field( 'shams_vehicle_save', 'shams_vehicle_nonce' );
	$get = function( $k, $d = '' ) use ( $post ) { $v = get_post_meta( $post->ID, '_vehicle_'.$k, true ); return $v !== '' ? $v : $d; };
	$trans = array( 'automatik'=>'Automatik','manual'=>'Manual' );
	$fuel  = array( 'dizel'=>'Dizel','benzin'=>'Benzin','hibrid'=>'Hibrid','elektricni'=>'Električni' );
	?>
	<style>.shams-mb{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}.shams-mb .full{grid-column:1/-1}.shams-mb label{display:block;font-weight:600;margin-bottom:4px;font-size:13px}.shams-mb input,.shams-mb select,.shams-mb textarea{width:100%;padding:8px;border:1px solid #ccd0d4;border-radius:6px}.shams-mb textarea{min-height:80px}</style>
	<div class="shams-mb">
		<div><label>Year / Godina</label><input type="number" name="v_year" value="<?php echo esc_attr( $get('year') ); ?>" placeholder="2024"></div>
		<div><label>Seats / Sjedišta</label><input type="text" name="v_seats" value="<?php echo esc_attr( $get('seats') ); ?>" placeholder="5"></div>
		<div><label>Bags / Torbe</label><input type="text" name="v_bags" value="<?php echo esc_attr( $get('bags') ); ?>" placeholder="3"></div>
		<div><label>Price € / day</label><input type="number" step="0.01" name="v_price" value="<?php echo esc_attr( $get('price') ); ?>" placeholder="65"></div>

		<div><label>Transmission</label><select name="v_trans"><?php foreach($trans as $k=>$l){ printf('<option value="%s" %s>%s</option>',$k,selected($get('trans'),$k,false),$l);} ?></select></div>
		<div><label>Fuel / Gorivo</label><select name="v_fuel"><?php foreach($fuel as $k=>$l){ printf('<option value="%s" %s>%s</option>',$k,selected($get('fuel'),$k,false),$l);} ?></select></div>
		<div><label>Sort order</label><input type="number" name="v_order" value="<?php echo esc_attr( $get('order','0') ); ?>"></div>
		<div style="display:flex;gap:18px;align-items:flex-end;padding-bottom:8px">
			<label style="display:flex;gap:6px;align-items:center;font-weight:600"><input type="checkbox" name="v_cdw" value="1" <?php checked( $get('cdw'), '1' ); ?>> CDW Included</label>
			<label style="display:flex;gap:6px;align-items:center;font-weight:600"><input type="checkbox" name="v_airport" value="1" <?php checked( $get('airport'), '1' ); ?>> Airport 24/7 badge</label>
		</div>

		<div class="full"><label>Features (Bosnian, one per line)</label><textarea name="v_feat_bs"><?php echo esc_textarea( $get('feat_bs') ); ?></textarea></div>
		<div class="full"><label>Features (English, one per line)</label><textarea name="v_feat_en"><?php echo esc_textarea( $get('feat_en') ); ?></textarea></div>
		<div class="full"><label>Features (Arabic, one per line)</label><textarea name="v_feat_ar"><?php echo esc_textarea( $get('feat_ar') ); ?></textarea></div>
	</div>
	<?php
}

function shams_vehicle_save( $post_id ) {
	if ( ! isset( $_POST['shams_vehicle_nonce'] ) || ! wp_verify_nonce( $_POST['shams_vehicle_nonce'], 'shams_vehicle_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	$txt = array( 'year'=>'v_year','seats'=>'v_seats','bags'=>'v_bags','trans'=>'v_trans','fuel'=>'v_fuel','feat_bs'=>'v_feat_bs','feat_en'=>'v_feat_en','feat_ar'=>'v_feat_ar' );
	foreach ( $txt as $mk => $fk ) {
		if ( isset( $_POST[ $fk ] ) ) update_post_meta( $post_id, '_vehicle_'.$mk, sanitize_textarea_field( wp_unslash( $_POST[ $fk ] ) ) );
	}
	if ( isset( $_POST['v_price'] ) ) update_post_meta( $post_id, '_vehicle_price', floatval( $_POST['v_price'] ) );
	if ( isset( $_POST['v_order'] ) ) update_post_meta( $post_id, '_vehicle_order', intval( $_POST['v_order'] ) );
	update_post_meta( $post_id, '_vehicle_cdw', isset( $_POST['v_cdw'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_vehicle_airport', isset( $_POST['v_airport'] ) ? '1' : '0' );
}
add_action( 'save_post_vehicle', 'shams_vehicle_save' );

/* Column helpers in admin list. */
function shams_vehicle_columns( $cols ) { $cols['v_img']='Img'; $cols['v_cat']='Category'; $cols['v_price']='€/day'; $cols['v_specs']='Specs'; return $cols; }
add_filter( 'manage_vehicle_posts_columns', 'shams_vehicle_columns' );
function shams_vehicle_column( $col, $id ) {
	if ( $col === 'v_img' ) { echo get_the_post_thumbnail( $id, 'thumbnail' ); }
	elseif ( $col === 'v_cat' ) { $t = get_the_terms( $id, 'vehicle_category' ); echo $t ? esc_html( $t[0]->name ) : '—'; }
	elseif ( $col === 'v_price' ) { echo '€'.esc_html( get_post_meta( $id, '_vehicle_price', true ) ); }
	elseif ( $col === 'v_specs' ) { printf( '%s seats · %s bags · %s · %s', esc_html(get_post_meta($id,'_vehicle_seats',true)), esc_html(get_post_meta($id,'_vehicle_bags',true)), esc_html(get_post_meta($id,'_vehicle_trans',true)), esc_html(get_post_meta($id,'_vehicle_fuel',true)) ); }
}
add_action( 'manage_vehicle_posts_custom_column', 'shams_vehicle_column', 10, 2 );
