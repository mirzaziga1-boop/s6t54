<?php if ( post_password_required() ) return; ?>
<div id="comments" class="shams-comments">
<?php if ( have_comments() ) : ?>
	<h2 class="comments-title"><?php printf( esc_html(_n('%s comment','%s comments', get_comments_number(),'shams-albosnia')), number_format_i18n(get_comments_number()) ); ?></h2>
	<ol class="comment-list"><?php wp_list_comments( array( 'style'=>'ol','avatar_size'=>44 ) ); ?></ol>
	<?php the_comments_navigation();
	if ( ! comments_open() ) : ?><p class="no-comments" data-i18n="comments_closed">Comments are closed.</p><?php endif;
endif;
comment_form( array( 'title_reply_before'=>'<h3 id="reply-title" class="comment-reply-title">','title_reply_after'=>'</h3>' ) );
?>
</div>
