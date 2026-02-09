<?php
/**
 * Custom Template Tags
 *
 * @package BrasilGEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output social network SVG icon
 */
function brasilgeo_social_icon( $network ) {
	$icons = array(
		'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16h-4.267z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>',
		'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
		'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>',
		'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>',
		'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
	);

	if ( isset( $icons[ $network ] ) ) {
		echo $icons[ $network ];
	}
}

/**
 * Breadcrumb styles
 */
function brasilgeo_breadcrumbs_styles() {
	?>
	<style>
		.breadcrumbs {
			padding: 1rem 0;
			font-size: 0.8rem;
			color: var(--text-dim);
		}
		.breadcrumbs a {
			color: var(--text-muted);
		}
		.breadcrumbs a:hover {
			color: var(--color-primary);
		}
		.breadcrumb-sep {
			margin: 0 0.5rem;
			color: var(--text-dim);
		}
		.breadcrumbs .current {
			color: var(--text-secondary);
		}
	</style>
	<?php
}
add_action( 'wp_head', 'brasilgeo_breadcrumbs_styles' );

/**
 * Placeholder image if no thumbnail
 */
function brasilgeo_placeholder_image( $size = 'brasilgeo-card' ) {
	$sizes = array(
		'brasilgeo-featured' => '1200x675',
		'brasilgeo-card'     => '600x375',
		'brasilgeo-thumb'    => '200x200',
	);
	$dim = isset( $sizes[ $size ] ) ? $sizes[ $size ] : '600x375';
	return "https://placehold.co/{$dim}/0b1122/00d4ff?text=Brasil+GEO&font=inter";
}
