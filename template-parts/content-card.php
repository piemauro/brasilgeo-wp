<?php
/**
 * Template Part: Post Card
 *
 * @package BrasilGEO
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card fade-in-up' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="card-image">
			<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
			<?php echo brasilgeo_category_badge(); ?>
		</a>
	<?php endif; ?>

	<div class="card-body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="excerpt"><?php echo brasilgeo_custom_excerpt( 100 ); ?></p>
		<div class="card-footer">
			<div class="post-meta">
				<span class="meta-author"><?php the_author(); ?></span>
				<span class="meta-sep"></span>
				<span class="meta-date"><?php echo get_the_date(); ?></span>
			</div>
		</div>
	</div>
</article>
