<?php
/**
 * Single Post Template
 *
 * @package BrasilGEO
 */

get_header();
brasilgeo_breadcrumbs();

while ( have_posts() ) : the_post();
?>

<!-- Single Header -->
<div class="single-header">
	<?php echo brasilgeo_category_badge(); ?>
	<h1><?php the_title(); ?></h1>
	<?php echo brasilgeo_post_meta(); ?>

	<div class="author-block">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
		<div class="author-info">
			<div class="author-name"><?php the_author(); ?></div>
			<div class="author-role"><?php echo esc_html( get_the_author_meta( 'description' ) ? substr( get_the_author_meta( 'description' ), 0, 50 ) : 'Autor' ); ?></div>
		</div>
	</div>
</div>

<!-- Featured Image -->
<?php if ( has_post_thumbnail() ) : ?>
	<div class="single-featured-image">
		<?php the_post_thumbnail( 'brasilgeo-featured' ); ?>
	</div>
<?php endif; ?>

<!-- Article Content -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-content' ); ?>>
	<?php the_content(); ?>

	<?php
	wp_link_pages( array(
		'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Paginas:', 'brasilgeo' ) . '</span>',
		'after'  => '</div>',
	) );
	?>
</article>

<!-- Tags -->
<?php
$tags = get_the_tags();
if ( $tags ) :
?>
	<div class="post-tags">
		<?php foreach ( $tags as $tag ) : ?>
			<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<!-- Share -->
<?php
$share = brasilgeo_share_urls();
?>
<div class="share-bar">
	<span class="share-label">Compartilhar:</span>
	<div class="share-buttons">
		<a href="<?php echo esc_url( $share['twitter'] ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Twitter">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16h-4.267z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>
		</a>
		<a href="<?php echo esc_url( $share['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="LinkedIn">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
		</a>
		<a href="<?php echo esc_url( $share['facebook'] ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Facebook">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
		</a>
		<a href="<?php echo esc_url( $share['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="WhatsApp">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
		</a>
	</div>
</div>

<!-- Author Box -->
<div class="author-box">
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'author-avatar' ) ); ?>
	<div class="author-bio">
		<h4><?php the_author(); ?></h4>
		<?php if ( get_the_author_meta( 'description' ) ) : ?>
			<p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
		<?php endif; ?>
	</div>
</div>

<!-- Related Posts -->
<?php
$related_cats = wp_get_post_categories( get_the_ID() );
$related_query = new WP_Query( array(
	'category__in'   => $related_cats,
	'post__not_in'   => array( get_the_ID() ),
	'posts_per_page' => 3,
	'no_found_rows'  => true,
) );

if ( $related_query->have_posts() ) :
?>
<section class="related-posts">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">
				<span class="title-accent"></span>
				Artigos Relacionados
			</h2>
		</div>
		<div class="posts-grid">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'card' ); ?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Comments -->
<?php
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
?>

<?php endwhile; ?>

<?php
get_footer();
