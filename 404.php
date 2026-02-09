<?php
/**
 * 404 Error Page
 *
 * @package BrasilGEO
 */

get_header();
?>

<div class="container">
	<div class="error-404">
		<div class="error-code">404</div>
		<h1>Pagina nao encontrada</h1>
		<p>A pagina que voce esta procurando pode ter sido removida, renomeada ou esta temporariamente indisponivel.</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">
			Voltar ao inicio
		</a>
	</div>
</div>

<?php
get_footer();
