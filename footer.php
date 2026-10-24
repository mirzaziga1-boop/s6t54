<?php
/** Footer: 4 columns + bottom bar + floating WhatsApp + scroll-top. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$about = shams_val( array(), 'footer_about', shams_default_footer_about() );
?>
	</main><!-- #main -->

	<footer class="shams-footer">
		<div class="shams-container shams-footer-grid">

			<div class="fcol fcol-brand">
				<?php shams_brand( false ); ?>
				<p class="fabout" <?= shams_ml_attrs( $about ) ?> ><?php echo shams_ml_text( $about ); ?></p>
				<div class="fsocial">
					<?php
					$soc = array(
						'facebook'=>array('shams_social_facebook','f'), 'instagram'=>array('shams_social_instagram','camera'),
						'whatsapp'=>array(null,'whatsapp'), 'mail'=>array('shams_email','mail'), 'phone'=>array('shams_phone','phone'),
					);
					foreach ( $soc as $name => $cfg ) {
						if ( $name === 'whatsapp' ) { $url = shams_wa_link(); }
						elseif ( $name === 'mail' ) { $em = get_theme_mod('shams_email','info@shamsalbosnia.com'); $url = 'mailto:'.$em; }
						elseif ( $name === 'phone' ) { $url = 'tel:'.preg_replace('/\s+/','',get_theme_mod('shams_phone','+38761228100')); }
						else { $url = get_theme_mod( $cfg[0], '' ); }
						if ( ! $url ) continue;
						$ico = $name === 'facebook' ? 'sun' : ( $name === 'instagram' ? 'camera' : $name ); // camera not in set; fallback below
						printf( '<a class="fsoc" href="%s" target="_blank" rel="noopener" aria-label="%s">%s</a>',
							esc_url( $url ), esc_attr( ucfirst($name) ), shams_icon( in_array($name,array('whatsapp','mail','phone'))?$name:'users', 18 ) );
					}
					?>
				</div>
			</div>

			<div class="fcol">
				<h4 class="ftitle" data-i18n="foot_links">Brzi Linkovi</h4>
				<?php wp_nav_menu( array( 'theme_location'=>'footer','container'=>false,'items_wrap'=>'%3$s','fallback_cb'=>'shams_footer_fallback','link_before'=>'<span data-i18n="','link_after'=>'"></span>','depth'=>1 ) ); ?>
			</div>

			<div class="fcol">
				<h4 class="ftitle" data-i18n="foot_office">Lokacija Kancelarije</h4>
				<ul class="fcontact">
					<li><?php echo shams_icon('pin',16); ?><span><?php echo esc_html( get_theme_mod('shams_address','Milana Preloga 12A, 71000 Sarajevo, Bosnia and Herzegovina') ); ?></span></li>
					<li><a href="tel:<?php echo esc_attr( preg_replace('/\s+/','',get_theme_mod('shams_phone','+38761228100')) ); ?>"><?php echo shams_icon('phone',16); ?><span><?php echo esc_html( get_theme_mod('shams_phone','+387 61 228 100') ); ?></span></a></li>
					<li><a href="mailto:<?php echo esc_attr( get_theme_mod('shams_email','info@shamsalbosnia.com') ); ?>"><?php echo shams_icon('mail',16); ?><span><?php echo esc_html( get_theme_mod('shams_email','info@shamsalbosnia.com') ); ?></span></a></li>
					<li><?php echo shams_icon('clock',16); ?><span <?= shams_ml_attrs( shams_val(array(),'topbar_hours', shams_ml('Pon - Ned: 08:00 - 22:00 (Dostava na Aerodrom Sarajevo 24/7)')) ) ?> ><?php echo shams_ml_text( shams_val(array(),'topbar_hours', shams_ml('Pon - Ned: 08:00 - 22:00')) ); ?></span></li>
				</ul>
				<div class="fairport"><?php echo shams_icon('plane',16); ?><span data-i18n="airport_box">Sarajevo Airport (SJJ) Delivery 24/7</span></div>
			</div>

			<div class="fcol fcol-pkg">
				<h4 class="ftitle" data-i18n="foot_pkg">WordPress Tema i Elementor Paket</h4>
				<p class="fpkg-desc" data-i18n="foot_pkg_desc">Standalone WordPress theme ready for upload to your hosting. Includes mandatory index.php, Elementor template kit, and 3-language support.</p>
				<?php $pkg = get_theme_mod('shams_pkg_url',''); if ( $pkg ) : ?>
				<a class="shams-btn shams-btn-gold shams-btn-block" href="<?php echo esc_url( $pkg ); ?>" download><?php echo shams_icon('download',16); ?><span data-i18n="foot_pkg_btn">PREUZMI CIJELU TEMU (.ZIP)</span></a>
				<?php endif; ?>
				<p class="fpkg-note" data-i18n="foot_pkg_note">Compatible with WordPress 6.x+, Elementor &amp; Polylang.</p>
			</div>

		</div>

		<div class="shams-footer-bottom">
			<div class="shams-container shams-fb-in">
				<span><?php echo esc_html( get_theme_mod('shams_copy_line','© 2026 Shams Al Bosnia. Sva prava zadržana.') ); ?></span>
				<span class="fb-right">
					<span><?php echo esc_html( get_theme_mod('shams_address','Milana Preloga 12A, 71000 Sarajevo, Bosnia and Herzegovina') ); ?></span>
					<?php if ( $pkg ) : ?><a href="<?php echo esc_url( $pkg ); ?>" download data-i18n="foot_pkg_link">WordPress Theme Package (.ZIP)</a><?php endif; ?>
				</span>
			</div>
		</div>
	</footer>

	<a class="shams-float-wa" href="<?php echo esc_url( shams_wa_link() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo shams_icon('whatsapp',26); ?></a>
	<button class="shams-float-top" aria-label="Top"><?php echo shams_icon('arrowup',20); ?></button>

</div><!-- .shams-site -->
<?php wp_footer(); ?>
</body>
</html>
