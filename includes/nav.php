<?php

/**
 * Navigation icons
 */
function orbis_nav_menu_icons( $classes, $item, $args ) {
	$fa = 'fa-edit';

	foreach( $classes as $class ) {
		$icon = strpos( $class, 'icon-' );

		if ( 0 === $icon ) {
			$class = str_replace( 'icon-', 'fa-', $class );

			$fa = $class;
		}
	}

	$item->title = '<i class="fa ' . $fa . '"></i> <span class="nav-label">' . $item->title . '</span>';

	return $classes;
}

add_filter( 'nav_menu_css_class', 'orbis_nav_menu_icons', 10, 3 );

/**
 * Active archive links
 */
function robbery_nav_menu_css_class( $classes, $item ) {
	if ( 'custom' == $item->type ) {
		$is_ancestor = strncmp( get_permalink(), $item->url, strlen( $item->url ) ) == 0;
		$is_home = untrailingslashit( $item->url ) == home_url();

		if ( $is_ancestor && ! $is_home ) {
			$classes[] = 'current-url-ancestor';
		}
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'robbery_nav_menu_css_class', 10, 2 );
