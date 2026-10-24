<?php get_header(); ?>
<section class="shams-fleet-section"><div class="shams-container">
	<h1 class="shams-sec-title" data-i18n="tab_all">Sva Vozila</h1>
	<div class="shams-fleet-grid">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); locate_template('template-parts/content-vehicle.php',true,array()); endwhile; the_posts_pagination(); else : locate_template('template-parts/content-none.php',true,array()); endif; ?>
	</div>
</div></section>
<?php get_footer(); ?>
