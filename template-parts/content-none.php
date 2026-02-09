<?php
/**
 * Template Part: No Content Found
 *
 * @package BrasilGEO
 */
?>

<div class="no-results" style="text-align:center; padding:4rem 2rem;">
	<h2>Nenhum conteudo encontrado</h2>
	<p style="color:var(--text-muted); max-width:500px; margin:0 auto 2rem;">
		<?php if ( is_search() ) : ?>
			Nao encontramos resultados para sua busca. Tente termos diferentes.
		<?php else : ?>
			Parece que nao temos conteudo aqui ainda. Volte em breve!
		<?php endif; ?>
	</p>
	<?php if ( is_search() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Voltar ao inicio</a>
	<?php endif; ?>
</div>
