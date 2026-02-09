<?php
/**
 * Comments Template
 *
 * @package BrasilGEO
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title section-title">
			<span class="title-accent"></span>
			<?php
			$count = get_comments_number();
			printf(
				'%d %s',
				$count,
				$count === 1 ? 'Comentario' : 'Comentarios'
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments" style="color:var(--text-muted); text-align:center; padding:2rem 0;">
			<?php esc_html_e( 'Comentarios fechados.', 'brasilgeo' ); ?>
		</p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'          => '<span class="title-accent"></span> Deixe um comentario',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title section-title">',
		'title_reply_after'    => '</h3>',
		'class_submit'         => 'btn btn-primary',
		'label_submit'         => 'Publicar comentario',
		'comment_notes_before' => '',
	) );
	?>
</div>
