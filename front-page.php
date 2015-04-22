<?php get_header(); ?>

<?php if ( is_active_sidebar( 'frontpage-top-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-top-widget' ); ?>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-left-widget' ) || is_active_sidebar( 'frontpage-right-widget' ) ) : ?>

	<div class="row">
		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-left-widget' ); ?>
		</div>

		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-right-widget' ); ?>
		</div>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-bottom-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-bottom-widget' ); ?>
	</div>

<?php else : ?>

	<div class="row">
		<?php 

		the_widget( 'Orbis_List_Posts_Widget', array(
			'post_type_name' => 'orbis_company', 
			'number'         => 8, 
			'title'          => __( 'Companies', 'orbis' ) 
		), array(
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) );

		the_widget( 'Orbis_List_Posts_Widget', array(
			'post_type_name' => 'orbis_project', 
			'number'         => 8, 
			'title'          => __( 'Projects', 'orbis' ) 
		), array(
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) );

		the_widget( 'Orbis_List_Posts_Widget', array(
			'post_type_name' => 'orbis_person', 
			'number'         => 8, 
			'title'          => __( 'Persons', 'orbis' ) 
		), array(
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) );

		?> 
	</div>

<?php endif; ?>

<?php get_footer(); ?>
