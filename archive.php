<?php
/**
 * Archive Template (categories, tags, date archives)
 *
 * @package BrasilGEO
 */

get_header();
brasilgeo_breadcrumbs();
?>

<div class="archive-header">
	<?php if ( is_category() ) : ?>
		<div class="archive-label">Categoria</div>
	<?php elseif ( is_tag() ) : ?>
		<div class="archive-label">Tag</div>
	<?php elseif ( is_author() ) : ?>
		<div class="archive-label">Autor</div>
	<?php elseif ( is_date() ) : ?>
		<div class="archive-label">Arquivo</div>
	<?php endif; ?>

	<h1><?php the_archive_title(); ?></h1>

	<?php if ( get_the_archive_description() ) : ?>
		<div class="archive-desc"><?php the_archive_description(); ?></div>
	<?php endif; ?>
</div>

<div class="container">
	<div class="content-layout">
		<div class="main-content">
			<?php if ( have_posts() ) : ?>
				<div class="posts-grid" style="grid-template-columns: repeat(2, 1fr);">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'card' ); ?>
					<?php endwhile; ?>
				</div>

				<?php the_posts_pagination( array(
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				) ); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
