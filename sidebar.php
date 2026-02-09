<?php
/**
 * Sidebar Template
 *
 * @package BrasilGEO
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	// Default sidebar content when no widgets configured
	?>
	<aside class="sidebar" role="complementary">
		<!-- Newsletter Widget -->
		<div class="widget widget-newsletter">
			<h3 class="widget-title"><span class="title-dot"></span>Newsletter</h3>
			<p>Receba as noticias mais importantes sobre GEO e IA diretamente no seu email.</p>
			<form class="newsletter-form">
				<input type="email" name="email" placeholder="Seu email" required>
				<button type="submit" class="btn btn-primary" style="width:100%;">Inscrever-se</button>
			</form>
		</div>

		<!-- Popular Posts Widget -->
		<div class="widget widget-popular">
			<h3 class="widget-title"><span class="title-dot"></span>Mais Lidos</h3>
			<?php
			$popular = new WP_Query( array(
				'posts_per_page' => 5,
				'orderby'        => 'comment_count',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			) );
			$num = 0;
			if ( $popular->have_posts() ) :
				while ( $popular->have_posts() ) : $popular->the_post();
					$num++;
			?>
				<div class="popular-item">
					<span class="popular-number"><?php echo esc_html( str_pad( $num, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div class="popular-content">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span class="popular-meta"><?php echo get_the_date(); ?></span>
					</div>
				</div>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<!-- Categories Widget -->
		<div class="widget widget-categories">
			<h3 class="widget-title"><span class="title-dot"></span>Categorias</h3>
			<ul>
				<?php
				$cats = get_categories( array(
					'orderby' => 'count',
					'order'   => 'DESC',
					'number'  => 8,
				) );
				foreach ( $cats as $cat ) :
				?>
					<li>
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
							<?php echo esc_html( $cat->name ); ?>
							<span class="count"><?php echo esc_html( $cat->count ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- Tags Widget -->
		<div class="widget widget-tags">
			<h3 class="widget-title"><span class="title-dot"></span>Tags</h3>
			<div class="tag-cloud">
				<?php
				$tags = get_tags( array( 'number' => 15, 'orderby' => 'count', 'order' => 'DESC' ) );
				foreach ( $tags as $tag ) :
				?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</aside>
	<?php
	return;
}
?>

<aside class="sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</aside>
