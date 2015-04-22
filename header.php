<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php get_template_part( 'templates/head-icons' ); ?>

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div class="page-wrapper">
			<div class="sidebar-wrapper">
				<div class="site-title">
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<?php if ( get_theme_mod( 'orbis_logo' ) ) : ?>

							<img src="<?php echo esc_url( get_theme_mod( 'orbis_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />

						<?php else : ?>

							<?php bloginfo( 'name' ); ?>

						<?php endif; ?>
					</a>
				</div>

				<div class="primary-nav" role="navigation">
					<h3><?php _e( 'Menu', 'orbis' ); ?></h3>

					<?php

					wp_nav_menu( array(
						'container'      => false,
						'theme_location' => 'primary',
						'depth'          => 2,
						'fallback_cb'    => '',
					) );

					?>

					<a class="toggle-nav"><span class="nav-label"><?php _e( 'Collapse menu', 'orbis' ); ?></span></a>
				</div>
			</div>

			<div class="main-wrapper">
				<div class="page-header clearfix">
					<h1 class="pull-left">
						<?php echo orbis_get_title(); ?>
					</h1>

					<?php if ( is_user_logged_in() ) : global $current_user; get_currentuserinfo(); ?>

						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo get_avatar( $current_user->ID, 24 ); ?> <?php echo esc_html( $current_user->display_name ); ?> <b class="caret"></b></a>

								<ul class="dropdown-menu">
									<li><a href="http://orbiswp.com/help/"><i class="fa fa-question-circle"></i> <?php _e( 'Help', 'orbis' ); ?></a></li>
									<li><a href="<?php echo admin_url( 'profile.php' ); ?>"><i class="fa fa-user"></i> <?php _e( 'Edit profile', 'orbis' ); ?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-power-off"></i> <?php _e( 'Log out', 'orbis' ); ?></a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle search-btn" href="#"><i class="fa fa-search"></i></a>

								<div class="dropdown-menu">
									<form method="get" class="navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
										<div class="form-group">
											<input type="search" name="s" class="form-control search-input" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>">
										</div>
									</form>
								</div>
							</li>
						</ul>

					<?php endif; ?>
				</div>

				<div class="main-content">
