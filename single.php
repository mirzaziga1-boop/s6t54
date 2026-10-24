<?php get_header(); while ( have_posts() ) : the_post(); ?>
<div class="shams-container shams-single"><h1 class="shams-sec-title"><?php the_title(); ?></h1><div class="shams-content"><?php the_content(); ?></div><?php if ( comments_open() || get_comments_number() ) comments_template(); ?></div>
<?php endwhile; get_footer(); ?>
