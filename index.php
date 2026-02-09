<?php
/**
 * Main Index Template
 *
 * @package BrasilGEO
 */

get_header();
brasilgeo_breadcrumbs();
?>

<div class="container">
	<div class="content-layout">
		<div class="main-content">
			<?php if ( have_posts() ) : ?>
				<div class="section-header">
					<h1 class="section-title">
						<span class="title-accent"></span>
						Todos os Artigos
					</h1>
				</div>

				<div class="posts-grid posts-grid-2">
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
