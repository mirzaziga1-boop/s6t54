<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$id = get_the_ID();
$m  = function( $k, $d='' ){ $v=get_post_meta($id,'_vehicle_'.$k,true); return $v!==''?$v:$d; };
$terms = get_the_terms( $id, 'vehicle_category' );
$slug  = $terms ? $terms[0]->slug : '';
$cat_key = array( 'dzipovi-i-suv'=>'tab_dzipovi','limuzine'=>'tab_limuzine','luksuzna-vozila'=>'tab_luksuzna','porodicni-kombi'=>'tab_porodicni','ekonomichna'=>'tab_ekonomichna' )[$slug] ?? '';
$cat_label = $cat_key ? shams_dict_bs($cat_key) : ($terms?$terms[0]->name:'');
$trans_key = $m('trans','automatik')==='manual' ? 'spec_manual' : 'spec_auto';
$fuel_map  = array( 'dizel'=>'spec_dizel','benzin'=>'spec_benzin','hibrid'=>'spec_hibrid','elektricni'=>'spec_elec' );
$fuel_key  = $fuel_map[ $m('fuel','dizel') ] ?? 'spec_dizel';
$feats_bs  = array_values( array_filter( array_map('trim', preg_split('/\r\n|\r|\n/', $m('feat_bs')) ) ) );
$feats_en  = array_values( array_filter( array_map('trim', preg_split('/\r\n|\r|\n/', $m('feat_en')) ) ) );
$feats_ar  = array_values( array_filter( array_map('trim', preg_split('/\r\n|\r|\n/', $m('feat_ar')) ) ) );
$search    = strtolower( get_the_title() . ' ' . $cat_label . ' ' . implode(' ',$feats_bs) );
$badge_cls = $slug==='porodicni-kombi' ? 'is-green' : ( $slug==='limuzine' ? 'is-blue' : '' );
?>
<article class="shams-vcard" data-category="<?php echo esc_attr($slug); ?>" data-search="<?php echo esc_attr($search); ?>">
	<div class="vc-media">
		<?php if ( $m('') && has_post_thumbnail() ) the_post_thumbnail('shams-card'); elseif ( has_post_thumbnail() ) the_post_thumbnail('shams-card'); else echo '<div class="vc-ph">'.shams_icon('car',40).'</div>'; ?>
		<?php if ( $cat_label ) : ?><span class="vc-cat <?php echo esc_attr($badge_cls); ?>" <?php if($cat_key) echo 'data-i18n="'.esc_attr($cat_key).'"'; ?>><?php echo esc_html($cat_label); ?></span><?php endif; ?>
		<?php if ( $m('airport')==='1' ) : ?><span class="vc-air"><?php echo shams_icon('shield',14); ?><span data-i18n="airport_badge">Sarajevo SJ Airport 24/7</span></span><?php endif; ?>
	</div>
	<div class="vc-body">
		<div class="vc-head"><h3 class="vc-title"><?php the_title(); ?></h3><span class="vc-year"><?php echo esc_html($m('year')); ?></span></div>
		<div class="vc-specs">
			<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('seat',18); ?></span><b><?php echo esc_html($m('seats')); ?></b><small data-i18n="spec_seats">Sjedišta</small></div>
			<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('bag',18); ?></span><b><?php echo esc_html($m('bags')); ?></b><small data-i18n="spec_bags">Torbi</small></div>
			<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('gear',18); ?></span><small data-i18n="<?php echo esc_attr($trans_key); ?>"><?php echo esc_html(shams_dict_bs($trans_key)); ?></small></div>
			<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('fuel',18); ?></span><small data-i18n="<?php echo esc_attr($fuel_key); ?>"><?php echo esc_html(shams_dict_bs($fuel_key)); ?></small></div>
		</div>
		<?php if ( $feats_bs ) : ?><ul class="vc-feats"><?php foreach ( $feats_bs as $i => $fb ) : $en=$feats_en[$i]??$fb; $ar=$feats_ar[$i]??$fb; ?><li><?php echo shams_icon('check',14); ?><span data-i18n-bs="<?php echo esc_attr($fb); ?>" data-i18n-en="<?php echo esc_attr($en); ?>" data-i18n-ar="<?php echo esc_attr($ar); ?>"><?php echo esc_html($fb); ?></span></li><?php endforeach; ?></ul><?php endif; ?>
		<div class="vc-foot">
			<div class="vc-price"><span class="pr">€<?php echo esc_html($m('price')); ?></span><small data-i18n="price_day">/ dan</small><?php if($m('cdw')==='1'):?><span class="cdw" data-i18n="cdw">CDW Included</span><?php endif; ?></div>
		</div>
		<div class="vc-actions">
			<a class="shams-btn shams-btn-dark shams-btn-sm" href="<?php the_permalink(); ?>"><?php echo shams_icon('info',15); ?><span data-i18n="btn_details">Više Detalja</span></a>
			<a class="shams-btn shams-btn-gold shams-btn-sm" href="<?php echo esc_url( shams_wa_link( sprintf( 'Zdravo, zanima me %s (€%s/dan)', get_the_title(), $m('price') ) ) ); ?>" target="_blank" rel="noopener"><?php echo shams_icon('whatsapp',15); ?><span data-i18n="btn_wa">WhatsApp</span></a>
		</div>
	</div>
</article>
