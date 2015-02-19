<?php

/**
 * Shortcode support for text widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Fix shortcode output
 */
function orbis_shortcode_empty_paragraph_fix( $content ) {
	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']',
	);

	$content = strtr( $content, $array );

	return $content;
}

add_filter( 'the_content', 'orbis_shortcode_empty_paragraph_fix' );

/**
 * Grid
 */
function orbis_row_grid( $atts, $content = null ) {
	$output = '<div class="row">' . do_shortcode( $content ) . '</div>';

	return $output;
}

function orbis_columns_grid( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'number' => '12',
		'offset' => '',
	), $atts );

	return '<div class="col-md-' . $atts['number'] . ' ' . ( $atts['offset'] ? 'col-md-offset-' . $atts['offset'] : '' ) . '">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'row', 'orbis_row_grid' );
add_shortcode( 'col', 'orbis_columns_grid' );

/**
 * Panel
 */
function orbis_panel_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class' => '',
	), $atts );

	return '<div class="panel ' . $atts['class'] . '"><div class="content">' . do_shortcode( $content ) . '</div></div>';
}

add_shortcode( 'panel', 'orbis_panel_shortcode' );

/**
 * Table
 */
function orbis_table_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'classes' => '',
	), $atts );

	$content = str_replace( '<table', '<table class="table ' . $atts['classes'] . '"', do_shortcode( $content ) );

	return $content;
}

add_shortcode( 'table', 'orbis_table_shortcode' );

/**
 * Icon
 */
function orbis_icon_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'type'  => 'phone',
	), $atts );

	return '<i class="fa fa-' . $atts['type'] . '"></i>';
}

add_shortcode( 'icon', 'orbis_icon_shortcode' );
