<?php
/**
 * Template Part: Featured Post (Horizontal)
 *
 * @package BrasilGEO
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card-horizontal fade-in-up' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="card-image">
			<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
		</a>
	<?php endif; ?>

	<div class="card-body">
		<div class="post-meta" style="margin-bottom:0.5rem;">
			<?php echo brasilgeo_category_badge(); ?>
		</div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="excerpt" style="color:var(--text-muted); font-size:0.875rem; margin-bottom:0.75rem;">
			<?php echo brasilgeo_custom_excerpt( 150 ); ?>
		</p>
		<div class="post-meta">
			<span class="meta-author"><?php the_author(); ?></span>
			<span class="meta-sep"></span>
			<span class="meta-date"><?php echo get_the_date(); ?></span>
			<span class="meta-sep"></span>
			<span class="meta-reading-time"><?php echo brasilgeo_reading_time(); ?></span>
		</div>
	</div>
</article>
