<?php if ( ! defined('ABSPATH') ) exit; ?>
<article <?php post_class('shams-pcard'); ?>>
	<?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>" class="pc-media"><?php the_post_thumbnail('shams-card'); ?></a><?php endif; ?>
	<div class="pc-body">
		<h2 class="pc-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="pc-meta"><time><?php echo get_the_date(); ?></time></div>
		<div class="pc-excerpt"><?php the_excerpt(); ?></div>
		<a class="shams-btn shams-btn-dark shams-btn-sm" href="<?php the_permalink(); ?>"><span data-i18n="read_more">Read more</span></a>
	</div>
</article>
