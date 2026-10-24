<?php get_header(); while ( have_posts() ) : the_post(); $id=get_the_ID(); $m=function($k,$d=''){ $v=get_post_meta($id,'_vehicle_'.$k,true); return $v!==''?$v:$d; }; ?>
<div class="shams-container shams-single shams-vehicle-single">
	<?php if ( has_post_thumbnail() ) : ?><div class="sv-hero"><?php the_post_thumbnail('shams-hero'); ?></div><?php endif; ?>
	<h1 class="shams-sec-title"><?php the_title(); ?></h1>
	<div class="vc-specs" style="max-width:680px;margin:0 0 18px">
		<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('seat',18);?></span><b><?php echo esc_html($m('seats'));?></b><small data-i18n="spec_seats">Sjedišta</small></div>
		<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('bag',18);?></span><b><?php echo esc_html($m('bags'));?></b><small data-i18n="spec_bags">Torbi</small></div>
		<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('gear',18);?></span><small data-i18n="<?php echo $m('trans')==='manual'?'spec_manual':'spec_auto';?>"><?php echo esc_html(shams_dict_bs($m('trans')==='manual'?'spec_manual':'spec_auto'));?></small></div>
		<div class="vsp"><span class="vsp-ico"><?php echo shams_icon('fuel',18);?></span><small data-i18n="spec_dizel">Dizel</small></div>
	</div>
	<div class="shams-content"><?php the_content(); ?></div>
	<p class="sv-price">€<?php echo esc_html($m('price'));?> <small data-i18n="price_day">/ dan</small></p>
	<a class="shams-btn shams-btn-gold" href="<?php echo esc_url( shams_wa_link( sprintf('Zdravo, zanima me %s', get_the_title()) ) ); ?>" target="_blank" rel="noopener"><?php echo shams_icon('whatsapp',16);?><span data-i18n="btn_wa">WhatsApp</span></a>
</div>
<?php endwhile; get_footer(); ?>
