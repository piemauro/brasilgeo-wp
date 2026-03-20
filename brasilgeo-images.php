<?php
/**
 * Brasil GEO - Image Seeder
 * Downloads featured images for posts
 * DELETE AFTER RUNNING!
 */
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
set_time_limit( 300 );

require_once dirname( __FILE__ ) . '/../../../wp-load.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';

header( 'Content-Type: text/plain; charset=utf-8' );
if ( ob_get_level() ) ob_end_clean();

echo "=== Brasil GEO Image Seeder ===\n\n";

// Map post IDs to Unsplash photo IDs (smaller size for faster download)
$post_images = array(
	6  => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80',
	7  => 'https://images.unsplash.com/photo-1573804633927-bfcbcd909acd?w=800&q=80',
	8  => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=800&q=80',
	9  => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80',
	10 => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&q=80',
	11 => 'https://images.unsplash.com/photo-1483058712412-4245e9b90334?w=800&q=80',
	12 => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
	13 => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800&q=80',
	14 => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=800&q=80',
	15 => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80',
	16 => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&q=80',
	17 => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80',
);

foreach ( $post_images as $post_id => $url ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		echo "Post {$post_id} not found, skipping.\n";
		flush();
		continue;
	}

	// Skip if already has thumbnail
	if ( has_post_thumbnail( $post_id ) ) {
		echo "Post {$post_id} already has thumbnail, skipping.\n";
		flush();
		continue;
	}

	echo "Downloading image for post {$post_id}: {$post->post_title}... ";
	flush();

	// Download image using WP HTTP API
	$response = wp_remote_get( $url, array(
		'timeout'    => 30,
		'user-agent' => 'Mozilla/5.0 (compatible; WordPress)',
		'redirection' => 5,
	) );

	if ( is_wp_error( $response ) ) {
		echo "DOWNLOAD ERROR: {$response->get_error_message()}\n";
		flush();
		continue;
	}

	$http_code = wp_remote_retrieve_response_code( $response );
	if ( 200 !== $http_code ) {
		echo "HTTP {$http_code}\n";
		flush();
		continue;
	}

	$body = wp_remote_retrieve_body( $response );
	if ( empty( $body ) ) {
		echo "Empty response.\n";
		flush();
		continue;
	}

	// Determine file type
	$content_type = wp_remote_retrieve_header( $response, 'content-type' );
	$ext = 'jpg';
	if ( strpos( $content_type, 'png' ) !== false ) {
		$ext = 'png';
	} elseif ( strpos( $content_type, 'webp' ) !== false ) {
		$ext = 'webp';
	}

	$filename = sanitize_file_name( 'brasilgeo-' . $post_id . '-' . time() . '.' . $ext );

	// Save to temp file
	$tmp_file = wp_tempnam( $filename );
	file_put_contents( $tmp_file, $body );

	// Create attachment
	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $tmp_file,
		'type'     => $content_type,
		'error'    => 0,
		'size'     => strlen( $body ),
	);

	$attach_id = media_handle_sideload( $file_array, $post_id, $post->post_title );

	if ( is_wp_error( $attach_id ) ) {
		@unlink( $tmp_file );
		echo "ATTACH ERROR: {$attach_id->get_error_message()}\n";
		flush();
		continue;
	}

	set_post_thumbnail( $post_id, $attach_id );
	echo "OK (attachment ID: {$attach_id})\n";
	flush();
}

echo "\n=== IMAGES COMPLETE ===\n";
echo "\n!!! DELETE THIS FILE NOW !!!\n";
