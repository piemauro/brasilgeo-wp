<?php
/**
 * Search Results Template
 *
 * @package BrasilGEO
 */

get_header();
brasilgeo_breadcrumbs();
?>

<div class="search-header">
	<div class="search-label">Resultados para</div>
	<h1>&ldquo;<span><?php echo esc_html( get_search_query() ); ?></span>&rdquo;</h1>
	<?php
	global $wp_query;
	$results_count = absint( $wp_query->found_posts );
	?>
	<p style="color:var(--text-muted);"><?php printf( '%d %s encontrados', $results_count, 1 === $results_count ? 'resultado' : 'resultados' ); ?></p>
</div>

<div class="container">
	<div class="content-layout">
		<div class="main-content">
			<?php if ( have_posts() ) : ?>
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
