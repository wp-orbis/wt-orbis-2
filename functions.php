<?php

/**
 * Includes
 */
require_once get_template_directory() . '/includes/functions.php';
require_once get_template_directory() . '/includes/projects.php';
require_once get_template_directory() . '/includes/subscriptions.php';
require_once get_template_directory() . '/includes/template-tags.php';
require_once get_template_directory() . '/includes/widgets.php';
require_once get_template_directory() . '/includes/nav.php';
require_once get_template_directory() . '/includes/shortcodes.php';
require_once get_template_directory() . '/includes/customizer.php';
require_once get_template_directory() . '/vendor/twitteroauth/twitteroauth/twitteroauth.php';

if ( function_exists( 'orbis_tasks_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/tasks.php';
}

if ( function_exists( 'orbis_timesheets_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/timesheets.php';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 728;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function orbis_setup() {
	/* Make theme available for translation */
	load_theme_textdomain( 'orbis', get_template_directory() . '/languages' );

	/* Editor style */
	add_editor_style( 'css/editor-style.css' );

	/* Add theme support */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

	/* Register navigation menu's */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'orbis' ),
	) );

	/* Add image sizes */
	add_image_size( 'featured', 244, 150, true );
	add_image_size( 'avatar', 60, 60, true );
}

add_action( 'after_setup_theme', 'orbis_setup' );

/**
 * Enqueue scripts & styles
 */
function orbis_load_scripts() {
	$uri = get_template_directory_uri();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Bootstrap
	wp_enqueue_script(
		'bootstrap',
		$uri . '/assets/bootstrap/js/bootstrap.min.js',
		array( 'jquery' ),
		'3.2.0',
		true
	);

	wp_enqueue_style(
		'bootstrap',
		$uri . '/assets/bootstrap/css/bootstrap.min.css',
		array(),
		'3.2.0'
	);

	// Font Awesome - http://fortawesome.github.io/Font-Awesome/
	wp_enqueue_style(
		'fontawesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
		'4.2.0'
	);

	// Orbis
	wp_enqueue_script(
		'wt-orbis',
		$uri . "/assets/orbis/js/orbis$suffix.js",
		array( 'jquery', 'bootstrap' ),
		'2.0.0',
		true
	);

	wp_localize_script(
		'wt-orbis',
		'orbis_timesheets_vars',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	);

	wp_enqueue_style(
		'wt-orbis',
		$uri . '/css/orbis' . $suffix . '.css',
		array( 'bootstrap' ),
		'2.0.0'
	);

}

add_action( 'wp_enqueue_scripts', 'orbis_load_scripts' );

/**
 * Sets the post excerpt length to 40 words.
 */
function orbis_excerpt_length( $length ) {
	return 24;
}

add_filter( 'excerpt_length', 'orbis_excerpt_length' );

function orbis_get_archive_post_type() {
	$post_type_obj = get_queried_object();
	$post_type = $post_type_obj->name;

	return $post_type;
}

function orbis_get_post_type_archive_link( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	return get_post_type_archive_link( $post_type );
}

function orbis_get_url_post_new( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	$url = add_query_arg( 'post_type', $post_type, admin_url( 'post-new.php' ) );

	return $url;
}

if ( ! function_exists( 'orbis_price' ) ) {
	function orbis_price( $price ) {
		return '&euro;&nbsp;' . number_format( $price, 2, ',', '.' );
	}
}

function orbis_the_content_empty( $content ) {
	if ( is_singular( array( 'post', 'orbis_person', 'orbis_project' ) ) ) {
		if ( empty( $content ) ) {
			$content =  '<p class="alt">' . __( 'No description.', 'orbis' ) . '</p>';
		}
	}

	return $content;
}

add_filter( 'the_content', 'orbis_the_content_empty', 200 );

/**
 * Orbis Companies
 */
function orbis_companies_render_contact_details() {
	if ( is_singular( 'orbis_company' ) ) {
		get_template_part( 'templates/company_contact' );
	}
}

add_action( 'orbis_before_side_content', 'orbis_companies_render_contact_details' );

/**
 * Custom excerpt
 */
function orbis_custom_excerpt( $excerpt, $charlength = 30 ) {
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );

	if ( strlen( $excerpt ) > $charlength ) {
		$excerpt = substr( $excerpt, 0, $charlength ) . '&hellip;';
	} else {
		$excerpt = $excerpt;
	}

	echo $excerpt;
}

/**
 * Load timesheet data with AJAX
 */
function orbis_load_timesheet_data() {
	get_template_part( 'templates/widget_timesheets' );

	die();
}

add_action( 'wp_ajax_load_timesheet_data', 'orbis_load_timesheet_data' );

/**
 * Page title
 */
function orbis_get_title() {
	if ( is_front_page() ) {
		return __( 'Dashboard', 'orbis' );

	} elseif ( is_home() ) {
		return __( 'News', 'orbis' );

	} elseif ( is_page() || is_single() ) {
		return get_the_title();

	} elseif ( is_category() ) {
		return single_cat_title( '', false );

	} elseif ( is_tag() ) {
		return single_tag_title( '', false );

	} elseif ( is_author() ) {
		return get_the_author();

	} elseif ( is_archive() ) {
		return post_type_archive_title();

	} elseif ( is_search() ) {
		return __( 'Search', 'orbis' );

	} elseif ( is_404() ) {
		return __( '404 - Page not found', 'orbis' );

	} else {
		return __( 'Unknown', 'orbis' );

	}
}

/**
 * Load custom CSS
 */
function orbis_load_css() {
	$style = '';
	$style .= '<style type="text/css" media="screen">';
	$style .= 'a { color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary, .panel.panel-featured { border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary { background-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: ' . get_option( 'orbis_primary_color' ) . '; border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.primary-nav > ul > li.active > a, .primary-nav > ul > li.current-menu-item > a, .primary-nav > ul > li.current-url-ancestor > a, .primary-nav > ul > li.current-menu-parent > a { border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '</style>';

	echo $style;
}

add_action( 'wp_head', 'orbis_load_css' );

/**
 * Support SVG uploads
 */
function orbis_allowed_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'orbis_allowed_mime_types' );

/**
 * Orbis get website favicon URL
 */
function orbis_get_favicon_url( $domain ) {
	if ( ! empty( $domain ) ) {
		return add_query_arg( 'domain', $domain, 'https://plus.google.com/_/favicon' );
	}

	return null;
}
