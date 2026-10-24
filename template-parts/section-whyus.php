<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$d = shams_default_whyus();
$eyebrow = shams_val( $args, 'eyebrow',  $d['eyebrow'] );
$title   = shams_val( $args, 'title',    $d['title'] );
$sub     = shams_val( $args, 'subtitle', $d['subtitle'] );
$items   = shams_list( $args, 'items',    $d['items'] );
?>
<section class="shams-whyus" id="about">
	<div class="shams-container">
		<p class="shams-eyebrow shams-eyebrow-center"><span class="ln"></span><span <?= shams_ml_attrs($eyebrow) ?> ><?php echo shams_ml_text($eyebrow); ?></span><span class="ln"></span></p>
		<h2 class="shams-sec-title" <?= shams_ml_attrs($title) ?> ><?php echo shams_ml_text($title); ?></h2>
		<p class="shams-sec-sub" <?= shams_ml_attrs($sub) ?> ><?php echo shams_ml_text($sub); ?></p>
		<div class="shams-why-grid">
			<?php foreach ( $items as $it ) : $t=is_array($it['title'])?$it['title']:shams_ml($it['title']); $x=is_array($it['text'])?$it['text']:shams_ml($it['text']); ?>
			<div class="wcard">
				<span class="wico"><?php echo shams_icon($it['icon']??'users',22); ?></span>
				<h3 <?= shams_ml_attrs($t) ?> ><?php echo shams_ml_text($t); ?></h3>
				<p <?= shams_ml_attrs($x) ?> ><?php echo shams_ml_text($x); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
