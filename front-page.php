<?php
/**
 * Front Page Template - News Portal Home
 *
 * @package BrasilGEO
 */

get_header();

$exclude_ids = array();
?>

<!-- Hero / Featured Section -->
<section class="hero-section">
	<div class="container">
		<div class="hero-grid">
			<?php
			// Main featured post (most recent sticky or latest)
			$sticky = get_option( 'sticky_posts' );
			$main_args = array(
				'posts_per_page' => 1,
				'no_found_rows'  => true,
			);
			if ( ! empty( $sticky ) ) {
				$main_args['post__in']            = $sticky;
				$main_args['ignore_sticky_posts'] = 1;
			}
			$main_query = new WP_Query( $main_args );

			if ( $main_query->have_posts() ) :
				$main_query->the_post();
				$exclude_ids[] = get_the_ID();
			?>
				<article class="featured-main fade-in-up">
					<a href="<?php the_permalink(); ?>" class="featured-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'brasilgeo-featured' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-featured' ) ); ?>" alt="<?php the_title_attribute(); ?>">
						<?php endif; ?>
						<div class="image-overlay"></div>
					</a>
					<div class="featured-content">
						<div class="post-meta">
							<?php echo brasilgeo_category_badge(); // phpcs:ignore -- safe HTML ?>
							<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
							<span class="meta-sep"></span>
							<span class="meta-reading-time"><?php echo esc_html( brasilgeo_reading_time() ); ?></span>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="excerpt"><?php echo esc_html( brasilgeo_custom_excerpt( 200 ) ); ?></p>
						<div class="post-meta" style="margin-top:0.5rem;">
							<span class="meta-author">Por <?php echo esc_html( get_the_author() ); ?></span>
						</div>
					</div>
				</article>
			<?php
				wp_reset_postdata();
			endif;
			?>

			<!-- Sidebar Featured -->
			<div class="featured-sidebar">
				<?php
				$side_query = new WP_Query( array(
					'posts_per_page' => 4,
					'post__not_in'   => $exclude_ids,
					'no_found_rows'  => true,
				) );

				if ( $side_query->have_posts() ) :
					while ( $side_query->have_posts() ) : $side_query->the_post();
						$exclude_ids[] = get_the_ID();
				?>
					<article class="featured-sidebar-item fade-in-up">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="thumb">
								<?php the_post_thumbnail( 'brasilgeo-thumb' ); ?>
							</a>
						<?php endif; ?>
						<div class="item-content">
							<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="post-meta">
								<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="meta-sep"></span>
								<span class="meta-reading-time"><?php echo esc_html( brasilgeo_reading_time() ); ?></span>
							</div>
						</div>
					</article>
				<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</div>
</section>

<!-- Latest Articles Section -->
<section class="posts-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
				<span class="title-accent"></span>
				Ultimas Noticias
			</h2>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="section-link">
				Ver todas
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
			</a>
		</div>

		<div class="posts-grid">
			<?php
			$latest_query = new WP_Query( array(
				'posts_per_page' => 6,
				'post__not_in'   => $exclude_ids,
				'no_found_rows'  => true,
			) );

			if ( $latest_query->have_posts() ) :
				$count = 0;
				while ( $latest_query->have_posts() ) : $latest_query->the_post();
					$exclude_ids[] = get_the_ID();
					$count++;
			?>
				<article class="post-card fade-in-up stagger-<?php echo esc_attr( min( $count, 4 ) ); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="card-image">
							<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
							<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="card-image">
							<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-card' ) ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
					<div class="card-body">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="excerpt"><?php echo esc_html( brasilgeo_custom_excerpt( 100 ) ); ?></p>
						<div class="card-footer">
							<div class="post-meta">
								<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="meta-sep"></span>
								<span class="meta-reading-time"><?php echo esc_html( brasilgeo_reading_time() ); ?></span>
							</div>
						</div>
					</div>
				</article>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<?php
// Category-based sections
$home_cats = get_categories( array(
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 3,
	'hide_empty' => true,
) );

foreach ( $home_cats as $hcat ) :
	$cat_query = new WP_Query( array(
		'cat'            => $hcat->term_id,
		'posts_per_page' => 4,
		'post__not_in'   => $exclude_ids,
		'no_found_rows'  => true,
	) );

	if ( $cat_query->have_posts() ) :
?>
<section class="posts-section" style="padding-top:0;">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
				<span class="title-accent"></span>
				<?php echo esc_html( $hcat->name ); ?>
			</h2>
			<a href="<?php echo esc_url( get_category_link( $hcat->term_id ) ); ?>" class="section-link">
				Ver mais
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
			</a>
		</div>

		<div class="posts-grid posts-grid-4">
			<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
				<article class="post-card fade-in-up">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="card-image">
							<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="card-image">
							<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-card' ) ); ?>" alt="<?php the_title_attribute(); ?>">
						</a>
					<?php endif; ?>
					<div class="card-body">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="card-footer">
							<div class="post-meta">
								<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php
	endif;
endforeach;
?>

<!-- Newsletter Section -->
<section class="posts-section newsletter-section">
	<div class="container container-narrow" style="text-align:center;">
		<div class="glass-card-elevated newsletter-cta">
			<h2 class="gradient-text">Fique por dentro do mundo GEO</h2>
			<p>
				Receba as ultimas noticias, analises e tendencias sobre Generative Engine Optimization direto no seu email.
			</p>
			<form class="newsletter-form-inline">
				<input type="email" name="email" placeholder="Seu melhor email" required>
				<button type="submit" class="btn btn-primary">Inscrever-se</button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();
