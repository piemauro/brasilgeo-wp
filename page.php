<?php
/**
 * Page Template
 *
 * @package BrasilGEO
 */

get_header();
brasilgeo_breadcrumbs();

while ( have_posts() ) : the_post();
?>

<div class="single-header">
	<h1><?php the_title(); ?></h1>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-content' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="single-featured-image">
			<?php the_post_thumbnail( 'brasilgeo-featured' ); ?>
		</div>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php
	wp_link_pages( array(
		'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Paginas:', 'brasilgeo' ) . '</span>',
		'after'  => '</div>',
	) );
	?>
</article>

<?php
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
?>

<?php endwhile; ?>

<?php
get_footer();
