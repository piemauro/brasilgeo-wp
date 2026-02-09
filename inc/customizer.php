<?php
/**
 * Customizer Settings
 *
 * @package BrasilGEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function brasilgeo_customize_register( $wp_customize ) {
	// ── Section: General ──
	$wp_customize->add_section( 'brasilgeo_general', array(
		'title'    => __( 'Brasil GEO - Geral', 'brasilgeo' ),
		'priority' => 30,
	) );

	// Ticker toggle
	$wp_customize->add_setting( 'brasilgeo_ticker_enable', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'brasilgeo_ticker_enable', array(
		'type'    => 'checkbox',
		'section' => 'brasilgeo_general',
		'label'   => __( 'Mostrar barra de noticias (ticker)', 'brasilgeo' ),
	) );

	// Ticker label
	$wp_customize->add_setting( 'brasilgeo_ticker_label', array(
		'default'           => 'Destaques',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'brasilgeo_ticker_label', array(
		'type'    => 'text',
		'section' => 'brasilgeo_general',
		'label'   => __( 'Label do ticker', 'brasilgeo' ),
	) );

	// ── Section: Social ──
	$wp_customize->add_section( 'brasilgeo_social', array(
		'title'    => __( 'Brasil GEO - Redes Sociais', 'brasilgeo' ),
		'priority' => 35,
	) );

	$social_networks = array(
		'twitter'   => 'Twitter / X',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'instagram' => 'Instagram',
	);

	foreach ( $social_networks as $key => $label ) {
		$wp_customize->add_setting( "brasilgeo_{$key}", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "brasilgeo_{$key}", array(
			'type'    => 'url',
			'section' => 'brasilgeo_social',
			'label'   => $label,
		) );
	}

	// ── Section: Footer ──
	$wp_customize->add_section( 'brasilgeo_footer', array(
		'title'    => __( 'Brasil GEO - Footer', 'brasilgeo' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'brasilgeo_footer_desc', array(
		'default'           => 'O portal brasileiro de referencia em Generative Engine Optimization. Conteudo, analises e tendencias sobre IA e visibilidade digital.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'brasilgeo_footer_desc', array(
		'type'    => 'textarea',
		'section' => 'brasilgeo_footer',
		'label'   => __( 'Descricao do footer', 'brasilgeo' ),
	) );

	$wp_customize->add_setting( 'brasilgeo_email', array(
		'default'           => 'contato@brasilgeo.ai',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'brasilgeo_email', array(
		'type'    => 'email',
		'section' => 'brasilgeo_footer',
		'label'   => __( 'Email de contato', 'brasilgeo' ),
	) );
}
add_action( 'customize_register', 'brasilgeo_customize_register' );
