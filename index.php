<?php get_header(); ?>
<div class="shams-container shams-archive">
	<?php if ( have_posts() ) : if ( is_home() && ! is_front_page() ) : ?><h1 class="shams-sec-title"><?php single_post_title(); ?></h1><?php endif; ?>
	<div class="shams-posts-grid">
	<?php while ( have_posts() ) : the_post(); locate_template('template-parts/content.php',true,array()); endwhile; ?>
	</div>
	<?php the_posts_pagination(); else : locate_template('template-parts/content-none.php',true,array()); endif; ?>
</div>
<?php get_footer(); ?>
