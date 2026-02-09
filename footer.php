</main><!-- #main-content -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<!-- Brand Column -->
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php
						$logo_id  = get_theme_mod( 'custom_logo' );
						$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
						?>
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="brand-logo" style="height:36px;width:auto;">
					<?php else : ?>
						<div class="brand-icon">G</div>
						<div class="brand-text">Brasil<span>GEO</span></div>
					<?php endif; ?>
				</a>
				<p><?php echo esc_html( get_theme_mod( 'brasilgeo_footer_desc', 'O portal brasileiro de referencia em Generative Engine Optimization. Conteudo, analises e tendencias sobre IA e visibilidade digital.' ) ); ?></p>
				<div class="footer-social">
					<?php
					$social_links = array(
						'twitter'  => get_theme_mod( 'brasilgeo_twitter', '' ),
						'linkedin' => get_theme_mod( 'brasilgeo_linkedin', '' ),
						'youtube'  => get_theme_mod( 'brasilgeo_youtube', '' ),
						'instagram'=> get_theme_mod( 'brasilgeo_instagram', '' ),
					);
					foreach ( $social_links as $network => $url ) :
						if ( ! empty( $url ) ) :
					?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>">
							<?php brasilgeo_social_icon( $network ); ?>
						</a>
					<?php
						endif;
					endforeach;
					?>
				</div>
			</div>

			<!-- Footer Nav Columns -->
			<div class="footer-col">
				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<h4><?php esc_html_e( 'Navegacao', 'brasilgeo' ); ?></h4>
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) ); ?>
				<?php else : ?>
					<h4>Categorias</h4>
					<ul>
						<?php wp_list_categories( array(
							'title_li' => '',
							'number'   => 6,
							'orderby'  => 'count',
							'order'    => 'DESC',
						) ); ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="footer-col">
				<?php if ( has_nav_menu( 'footer-col2' ) ) : ?>
					<h4><?php esc_html_e( 'Recursos', 'brasilgeo' ); ?></h4>
					<?php wp_nav_menu( array(
						'theme_location' => 'footer-col2',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) ); ?>
				<?php else : ?>
					<h4>Tags Populares</h4>
					<ul>
						<?php
						$tags = get_tags( array( 'number' => 6, 'orderby' => 'count', 'order' => 'DESC' ) );
						foreach ( $tags as $tag ) :
						?>
							<li><a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="footer-col">
				<?php if ( has_nav_menu( 'footer-col3' ) ) : ?>
					<h4><?php esc_html_e( 'Empresa', 'brasilgeo' ); ?></h4>
					<?php wp_nav_menu( array(
						'theme_location' => 'footer-col3',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) ); ?>
				<?php else : ?>
					<h4>Contato</h4>
					<ul>
						<li><a href="mailto:<?php echo esc_attr( get_theme_mod( 'brasilgeo_email', 'contato@brasilgeo.ai' ) ); ?>"><?php echo esc_html( get_theme_mod( 'brasilgeo_email', 'contato@brasilgeo.ai' ) ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.</span>
			<span>
				<a href="https://brasilgeo.ai" target="_blank" rel="noopener noreferrer">brasilgeo.ai</a>
			</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
