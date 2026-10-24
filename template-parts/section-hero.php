<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$d = shams_default_hero();
$eyebrow = shams_val( $args, 'eyebrow',  $d['eyebrow'] );
$title   = shams_val( $args, 'title',    $d['title'] );
$sub     = shams_val( $args, 'subtitle', $d['subtitle'] );
$b1      = shams_val( $args, 'btn1',     $d['btn1'] );
$b2      = shams_val( $args, 'btn2',     $d['btn2'] );
$b1url   = $args['btn1_url'] ?? '#fleet';
$b2url   = ( isset($args['btn2_url']) && $args['btn2_url'] && $args['btn2_url'] !== 'whatsapp' ) ? $args['btn2_url'] : shams_wa_link();
$feats   = shams_list( $args, 'features', $d['features'] );
?>
<section class="shams-hero" id="home">
	<div class="shams-hero-bg" aria-hidden="true"></div>
	<div class="shams-container shams-hero-in">
		<p class="shams-eyebrow shams-eyebrow-center"><span class="ln"></span><span <?= shams_ml_attrs($eyebrow) ?> ><?php echo shams_ml_text($eyebrow); ?></span><span class="ln"></span></p>
		<h1 class="shams-hero-title" <?= shams_ml_attrs($title) ?> ><?php echo shams_ml_text($title); ?></h1>
		<p class="shams-hero-sub" <?= shams_ml_attrs($sub) ?> ><?php echo shams_ml_text($sub); ?></p>
		<div class="shams-hero-cta">
			<a class="shams-btn shams-btn-gold" href="<?php echo esc_url($b1url); ?>"><?php echo shams_icon('car',18); ?><span <?= shams_ml_attrs($b1) ?> ><?php echo shams_ml_text($b1); ?></span></a>
			<a class="shams-btn shams-btn-outline" href="<?php echo esc_url($b2url); ?>" target="_blank" rel="noopener"><?php echo shams_icon('whatsapp',18); ?><span <?= shams_ml_attrs($b2) ?> ><?php echo shams_ml_text($b2); ?></span></a>
		</div>
		<div class="shams-hero-feats">
			<?php foreach ( $feats as $f ) : $ft = is_array($f['title'])?$f['title']:shams_ml($f['title']); $fs = is_array($f['sub'])?$f['sub']:shams_ml($f['sub']); ?>
			<div class="hfcard">
				<span class="hfico"><?php echo shams_icon($f['icon']??'check',20); ?></span>
				<h3 <?= shams_ml_attrs($ft) ?> ><?php echo shams_ml_text($ft); ?></h3>
				<p <?= shams_ml_attrs($fs) ?> ><?php echo shams_ml_text($fs); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
