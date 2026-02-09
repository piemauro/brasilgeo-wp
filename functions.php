<?php
/**
 * Brasil GEO Portal - Theme Functions
 *
 * @package BrasilGEO
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRASILGEO_VERSION', '1.0.0' );
define( 'BRASILGEO_DIR', get_template_directory() );
define( 'BRASILGEO_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function brasilgeo_setup() {
	load_theme_textdomain( 'brasilgeo', BRASILGEO_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );

	// Image sizes
	set_post_thumbnail_size( 1200, 675, true );
	add_image_size( 'brasilgeo-featured', 1200, 675, true );
	add_image_size( 'brasilgeo-card', 600, 375, true );
	add_image_size( 'brasilgeo-thumb', 200, 200, true );
	add_image_size( 'brasilgeo-wide', 1400, 600, true );

	// Nav menus
	register_nav_menus( array(
		'primary'     => __( 'Menu Principal', 'brasilgeo' ),
		'footer'      => __( 'Menu Footer', 'brasilgeo' ),
		'footer-col2' => __( 'Footer Coluna 2', 'brasilgeo' ),
		'footer-col3' => __( 'Footer Coluna 3', 'brasilgeo' ),
		'social'      => __( 'Redes Sociais', 'brasilgeo' ),
	) );
}
add_action( 'after_setup_theme', 'brasilgeo_setup' );

/**
 * Enqueue Scripts and Styles
 */
function brasilgeo_scripts() {
	// Google Fonts
	wp_enqueue_style(
		'brasilgeo-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Theme stylesheet
	wp_enqueue_style(
		'brasilgeo-style',
		get_stylesheet_uri(),
		array( 'brasilgeo-fonts' ),
		BRASILGEO_VERSION
	);

	// Theme JS
	wp_enqueue_script(
		'brasilgeo-script',
		BRASILGEO_URI . '/assets/js/theme.js',
		array(),
		BRASILGEO_VERSION,
		true
	);

	wp_localize_script( 'brasilgeo-script', 'brasilgeoData', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'brasilgeo_nonce' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'brasilgeo_scripts' );

/**
 * Widget Areas
 */
function brasilgeo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar Principal', 'brasilgeo' ),
		'id'            => 'sidebar-main',
		'description'   => __( 'Widgets da sidebar principal.', 'brasilgeo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span class="title-dot"></span>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'brasilgeo' ),
		'id'            => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'brasilgeo' ),
		'id'            => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'brasilgeo_widgets_init' );

/**
 * Estimated reading time
 */
function brasilgeo_reading_time( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( strip_tags( $content ) );
	$minutes = max( 1, ceil( $words / 200 ) );
	return sprintf( '%d min de leitura', $minutes );
}

/**
 * Excerpt length
 */
function brasilgeo_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'brasilgeo_excerpt_length' );

function brasilgeo_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'brasilgeo_excerpt_more' );

/**
 * Custom excerpt
 */
function brasilgeo_custom_excerpt( $limit = 120 ) {
	$excerpt = get_the_excerpt();
	if ( strlen( $excerpt ) > $limit ) {
		$excerpt = substr( $excerpt, 0, $limit ) . '&hellip;';
	}
	return $excerpt;
}

/**
 * Category badge with color class
 */
function brasilgeo_category_badge( $post_id = null ) {
	$post_id    = $post_id ?: get_the_ID();
	$categories = get_the_category( $post_id );
	if ( empty( $categories ) ) {
		return '';
	}

	$cat = $categories[0];
	$slug_map = array(
		'geo'     => 'cat-geo',
		'ia'      => 'cat-ia',
		'seo'     => 'cat-seo',
		'mercado' => 'cat-mercado',
	);

	$class = 'cat-geo'; // default
	foreach ( $slug_map as $key => $css ) {
		if ( stripos( $cat->slug, $key ) !== false ) {
			$class = $css;
			break;
		}
	}

	return sprintf(
		'<a href="%s" class="category-badge %s">%s</a>',
		esc_url( get_category_link( $cat->term_id ) ),
		esc_attr( $class ),
		esc_html( $cat->name )
	);
}

/**
 * Post meta output
 */
function brasilgeo_post_meta( $show_author = true ) {
	$output = '<div class="post-meta">';

	if ( $show_author ) {
		$output .= '<span class="meta-author">' . get_the_author() . '</span>';
		$output .= '<span class="meta-sep"></span>';
	}

	$output .= '<span class="meta-date">' . get_the_date() . '</span>';
	$output .= '<span class="meta-sep"></span>';
	$output .= '<span class="meta-reading-time">' . brasilgeo_reading_time() . '</span>';
	$output .= '</div>';

	return $output;
}

/**
 * Breadcrumbs
 */
function brasilgeo_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><div class="container">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
	echo '<span class="breadcrumb-sep">&rsaquo;</span>';

	if ( is_single() ) {
		$cats = get_the_category();
		if ( $cats ) {
			echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
			echo '<span class="breadcrumb-sep">&rsaquo;</span>';
		}
		echo '<span class="current">' . get_the_title() . '</span>';
	} elseif ( is_category() ) {
		echo '<span class="current">' . single_cat_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		echo '<span class="current">' . single_tag_title( '', false ) . '</span>';
	} elseif ( is_search() ) {
		echo '<span class="current">Busca</span>';
	} elseif ( is_404() ) {
		echo '<span class="current">404</span>';
	} elseif ( is_page() ) {
		echo '<span class="current">' . get_the_title() . '</span>';
	} else {
		echo '<span class="current">Arquivo</span>';
	}

	echo '</div></nav>';
}

/**
 * Social share URLs
 */
function brasilgeo_share_urls() {
	$url   = urlencode( get_permalink() );
	$title = urlencode( get_the_title() );

	return array(
		'twitter'  => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
		'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
		'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
		'whatsapp' => "https://api.whatsapp.com/send?text={$title}%20{$url}",
	);
}

/**
 * Customizer settings
 */
require_once BRASILGEO_DIR . '/inc/customizer.php';

/**
 * Custom template tags
 */
require_once BRASILGEO_DIR . '/inc/template-tags.php';

/**
 * Custom widgets
 */
require_once BRASILGEO_DIR . '/inc/widgets.php';

/**
 * Add preconnect for Google Fonts
 */
function brasilgeo_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
			'crossorigin' => '',
		);
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin' => '',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'brasilgeo_resource_hints', 10, 2 );

/**
 * Disable Gutenberg editor color palette (use theme colors)
 */
function brasilgeo_editor_settings() {
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => 'Primary',   'slug' => 'primary',   'color' => '#00d4ff' ),
		array( 'name' => 'Accent',    'slug' => 'accent',    'color' => '#33b3ff' ),
		array( 'name' => 'Success',   'slug' => 'success',   'color' => '#12b86e' ),
		array( 'name' => 'Warning',   'slug' => 'warning',   'color' => '#ffc11a' ),
		array( 'name' => 'Dark',      'slug' => 'dark',      'color' => '#070b14' ),
		array( 'name' => 'Card',      'slug' => 'card',      'color' => '#0d1528' ),
		array( 'name' => 'Text',      'slug' => 'text',      'color' => '#f5f7fa' ),
		array( 'name' => 'Muted',     'slug' => 'muted',     'color' => '#7a8799' ),
	) );
}
add_action( 'after_setup_theme', 'brasilgeo_editor_settings' );

/**
 * Modify body classes
 */
function brasilgeo_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}
	if ( is_front_page() ) {
		$classes[] = 'front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'brasilgeo_body_classes' );
