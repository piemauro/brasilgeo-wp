<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( get_theme_mod( 'brasilgeo_ticker_enable', true ) ) : ?>
<!-- Breaking News Ticker -->
<div class="ticker-bar">
	<div class="container">
		<div class="ticker-inner">
			<div class="ticker-label">
				<span class="pulse-dot"></span>
				<?php echo esc_html( get_theme_mod( 'brasilgeo_ticker_label', 'Destaques' ) ); ?>
			</div>
			<div class="ticker-track">
				<div class="ticker-items">
					<?php
					$ticker_query = new WP_Query( array(
						'posts_per_page' => 6,
						'orderby'        => 'date',
						'order'          => 'DESC',
						'no_found_rows'  => true,
					) );
					if ( $ticker_query->have_posts() ) :
						while ( $ticker_query->have_posts() ) : $ticker_query->the_post();
					?>
						<span class="ticker-item">
							<span class="ticker-time"><?php echo esc_html( get_the_date( 'H:i' ) ); ?></span>
							<span class="ticker-sep">&bull;</span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</span>
					<?php
						endwhile;
						wp_reset_postdata();
					endif;
					// Duplicate for seamless scroll
					if ( $ticker_query->have_posts() ) :
						$ticker_query->rewind_posts();
						while ( $ticker_query->have_posts() ) : $ticker_query->the_post();
					?>
						<span class="ticker-item">
							<span class="ticker-time"><?php echo esc_html( get_the_date( 'H:i' ) ); ?></span>
							<span class="ticker-sep">&bull;</span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</span>
					<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Site Header -->
<header class="site-header" id="site-header">
	<div class="container">
		<div class="header-inner">
			<!-- Brand -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" aria-label="<?php bloginfo( 'name' ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php
					$logo_id  = get_theme_mod( 'custom_logo' );
					$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
					?>
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="brand-logo" style="height:40px;width:auto;">
				<?php else : ?>
					<div class="brand-icon">G</div>
					<div class="brand-text">Brasil<span>GEO</span></div>
				<?php endif; ?>
			</a>

			<!-- Primary Navigation -->
			<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Menu Principal', 'brasilgeo' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 2,
					'fallback_cb'    => false,
				) );
				?>
			</nav>

			<!-- Header Actions -->
			<div class="header-actions">
				<button class="header-search-toggle" id="search-toggle" aria-label="<?php esc_attr_e( 'Buscar', 'brasilgeo' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				</button>

				<button class="mobile-toggle" id="mobile-toggle" aria-label="<?php esc_attr_e( 'Menu', 'brasilgeo' ); ?>">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>
	</div>
</header>

<!-- Search Overlay -->
<div class="search-overlay" id="search-overlay">
	<button class="search-close" id="search-close" aria-label="<?php esc_attr_e( 'Fechar busca', 'brasilgeo' ); ?>">&times;</button>
	<div class="search-overlay-inner">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Buscar artigos...', 'brasilgeo' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autofocus>
		</form>
	</div>
</div>

<!-- Mobile Navigation -->
<div class="mobile-nav-overlay" id="mobile-overlay"></div>
<nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e( 'Menu Mobile', 'brasilgeo' ); ?>">
	<button class="mobile-nav-close" id="mobile-close" aria-label="<?php esc_attr_e( 'Fechar menu', 'brasilgeo' ); ?>">&times;</button>
	<?php
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => 'menu',
		'depth'          => 2,
		'fallback_cb'    => false,
	) );
	?>
</nav>

<main id="main-content">
