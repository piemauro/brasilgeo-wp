<?php
/**
 * Front Page Template - News Portal Home
 *
 * @package BrasilGEO
 */

get_header();

$exclude_ids = array();
?>

<!-- Hero Section: Big featured + 2 secondary -->
<section class="hero-section">
	<div class="container">
		<?php
		// Main featured post — try sticky first, fallback to latest.
		$sticky    = get_option( 'sticky_posts' );
		$main_args = array(
			'posts_per_page'      => 1,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => 1,
		);
		if ( ! empty( $sticky ) ) {
			$main_args['post__in'] = $sticky;
		}
		$main_query = new WP_Query( $main_args );

		// Fallback: if sticky not found, get the latest post.
		if ( ! $main_query->have_posts() ) {
			$main_query = new WP_Query( array(
				'posts_per_page'      => 1,
				'post_status'         => 'publish',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => 1,
			) );
		}

		if ( $main_query->have_posts() ) :
			$main_query->the_post();
			$exclude_ids[] = get_the_ID();
			$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'brasilgeo-featured' ) : brasilgeo_placeholder_image( 'brasilgeo-featured' );
		?>
		<div class="hero-grid">
			<!-- Main Hero -->
			<div class="hero-main" style="background-image:url('<?php echo esc_url( $hero_img ); ?>');">
				<a href="<?php the_permalink(); ?>" class="hero-main__link" aria-label="<?php the_title_attribute(); ?>"></a>
				<div class="hero-main__overlay"></div>
				<div class="hero-main__content">
					<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<p class="hero-main__excerpt"><?php echo esc_html( brasilgeo_custom_excerpt( 180 ) ); ?></p>
					<div class="post-meta post-meta--light">
						<span class="meta-author">Por <?php echo esc_html( get_the_author() ); ?></span>
						<span class="meta-sep"></span>
						<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
						<span class="meta-sep"></span>
						<span class="meta-reading-time"><?php echo esc_html( brasilgeo_reading_time() ); ?></span>
					</div>
				</div>
			</div>

			<!-- Secondary Highlights -->
			<div class="hero-secondary">
				<?php
				wp_reset_postdata();

				$sec_query = new WP_Query( array(
					'posts_per_page'      => 2,
					'post__not_in'        => $exclude_ids,
					'post_status'         => 'publish',
					'no_found_rows'       => true,
					'ignore_sticky_posts' => 1,
				) );

				if ( $sec_query->have_posts() ) :
					while ( $sec_query->have_posts() ) : $sec_query->the_post();
						$exclude_ids[] = get_the_ID();
						$sec_img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'brasilgeo-card' ) : brasilgeo_placeholder_image( 'brasilgeo-card' );
				?>
					<div class="hero-card" style="background-image:url('<?php echo esc_url( $sec_img ); ?>');">
						<a href="<?php the_permalink(); ?>" class="hero-card__link" aria-label="<?php the_title_attribute(); ?>"></a>
						<div class="hero-card__overlay"></div>
						<div class="hero-card__content">
							<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="post-meta post-meta--light">
								<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="meta-sep"></span>
								<span class="meta-reading-time"><?php echo esc_html( brasilgeo_reading_time() ); ?></span>
							</div>
						</div>
					</div>
				<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
		<?php
		else :
			wp_reset_postdata();
		endif;
		?>
	</div>
</section>

<!-- Quick Links Row: 4 small highlight cards -->
<section class="quick-links-section">
	<div class="container">
		<div class="quick-links-grid">
			<?php
			$quick_query = new WP_Query( array(
				'posts_per_page'      => 4,
				'post__not_in'        => $exclude_ids,
				'post_status'         => 'publish',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => 1,
			) );

			if ( $quick_query->have_posts() ) :
				while ( $quick_query->have_posts() ) : $quick_query->the_post();
					$exclude_ids[] = get_the_ID();
			?>
				<article class="quick-card fade-in-up">
					<a href="<?php the_permalink(); ?>" class="quick-card__link">
						<div class="quick-card__thumb">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'brasilgeo-thumb' ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-thumb' ) ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php endif; ?>
						</div>
						<div class="quick-card__body">
							<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
							<h4><?php the_title(); ?></h4>
							<span class="post-meta">
								<span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
							</span>
						</div>
					</a>
				</article>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<!-- Latest Articles — 3-column grid -->
<section class="posts-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
				<span class="title-accent"></span>
				Ultimas Noticias
			</h2>
		</div>

		<div class="posts-grid">
			<?php
			$latest_query = new WP_Query( array(
				'posts_per_page'      => 6,
				'post__not_in'        => $exclude_ids,
				'post_status'         => 'publish',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => 1,
			) );

			if ( $latest_query->have_posts() ) :
				$count = 0;
				while ( $latest_query->have_posts() ) : $latest_query->the_post();
					$exclude_ids[] = get_the_ID();
					$count++;
			?>
				<article class="post-card fade-in-up">
					<a href="<?php the_permalink(); ?>" class="card-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-card' ) ); ?>" alt="<?php the_title_attribute(); ?>">
						<?php endif; ?>
						<?php echo brasilgeo_category_badge(); // phpcs:ignore ?>
					</a>
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
// ── Category Sections ──
$home_cats = get_categories( array(
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 3,
	'hide_empty' => true,
	'exclude'    => array( 1 ), // Exclude "Uncategorized"
) );

foreach ( $home_cats as $hcat ) :
	$cat_query = new WP_Query( array(
		'cat'                 => $hcat->term_id,
		'posts_per_page'      => 4,
		'post__not_in'        => $exclude_ids,
		'post_status'         => 'publish',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => 1,
	) );

	if ( ! $cat_query->have_posts() ) {
		// If no posts excluding used IDs, get any from category
		$cat_query = new WP_Query( array(
			'cat'                 => $hcat->term_id,
			'posts_per_page'      => 4,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => 1,
		) );
	}

	if ( $cat_query->have_posts() ) :
?>
<section class="posts-section cat-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
				<span class="title-accent"></span>
				<?php echo esc_html( $hcat->name ); ?>
			</h2>
			<a href="<?php echo esc_url( get_category_link( $hcat->term_id ) ); ?>" class="section-link">
				Ver mais
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
			</a>
		</div>

		<div class="posts-grid posts-grid-4">
			<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
				<article class="post-card post-card--compact fade-in-up">
					<a href="<?php the_permalink(); ?>" class="card-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'brasilgeo-card' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( brasilgeo_placeholder_image( 'brasilgeo-card' ) ); ?>" alt="<?php the_title_attribute(); ?>">
						<?php endif; ?>
					</a>
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
