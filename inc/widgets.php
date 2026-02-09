<?php
/**
 * Custom Widgets
 *
 * @package BrasilGEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Popular Posts Widget
 */
class BrasilGEO_Popular_Posts_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'brasilgeo_popular_posts',
			__( 'Brasil GEO - Posts Populares', 'brasilgeo' ),
			array( 'description' => __( 'Mostra os posts mais populares.', 'brasilgeo' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : 'Mais Lidos';
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;

		echo $args['before_widget'];
		echo '<div class="widget-popular">';
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

		$popular = new WP_Query( array(
			'posts_per_page' => $number,
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

		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : 'Mais Lidos';
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Titulo:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">Quantidade:</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $number ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}

/**
 * Newsletter Widget
 */
class BrasilGEO_Newsletter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'brasilgeo_newsletter',
			__( 'Brasil GEO - Newsletter', 'brasilgeo' ),
			array( 'description' => __( 'Formulario de inscricao na newsletter.', 'brasilgeo' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Newsletter';
		$desc  = ! empty( $instance['description'] ) ? $instance['description'] : 'Receba as noticias mais importantes sobre GEO e IA.';

		echo $args['before_widget'];
		echo '<div class="widget-newsletter">';
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		echo '<p>' . esc_html( $desc ) . '</p>';
		?>
		<form class="newsletter-form">
			<input type="email" name="email" placeholder="Seu email" required>
			<button type="submit" class="btn btn-primary" style="width:100%;">Inscrever-se</button>
		</form>
		<?php
		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Newsletter';
		$desc  = ! empty( $instance['description'] ) ? $instance['description'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Titulo:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">Descricao:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $desc ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['description'] = sanitize_textarea_field( $new_instance['description'] );
		return $instance;
	}
}

function brasilgeo_register_widgets() {
	register_widget( 'BrasilGEO_Popular_Posts_Widget' );
	register_widget( 'BrasilGEO_Newsletter_Widget' );
}
add_action( 'widgets_init', 'brasilgeo_register_widgets' );
