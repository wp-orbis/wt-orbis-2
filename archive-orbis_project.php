<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">	
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add project', 'orbis' ); ?>
	</a>
</header>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php _e( 'Client', 'orbis' ); ?></th>
						<th><?php _e( 'Project', 'orbis' ); ?></th>
						<th><?php _e( 'Time', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php 

								if ( function_exists( 'orbis_project_has_principal' ) ) {
									if ( orbis_project_has_principal() ) {
										printf( 
											'<a href="%s">%s</a>',
											esc_attr( orbis_project_principal_get_permalink() ),
											orbis_project_principel_get_the_name()
										);
									}
								}

								?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php if ( get_comments_number() != 0  ) : ?>

									<div class="comments-number">
										<span class="glyphicon glyphicon-comment"></span>
										<?php comments_number( '0', '1', '%' ); ?>
									</div>

								<?php endif; ?>
							</td>
							<td class="project-time">
								<?php 

								if ( function_exists( 'orbis_project_the_time' ) ) {
									orbis_project_the_time();
								}

								if ( function_exists( 'orbis_project_the_logged_time' ) ) :

									$classes = array();
									$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

									?>

									<span class="<?php echo implode( $classes, ' ' ); ?>"><?php orbis_project_the_logged_time(); ?></span>

								<?php endif; ?>
							</td>
							<td>
								<div class="actions">
									<div class="nubbin">
										<?php orbis_edit_post_link(); ?>
									</div>
								</div>
							</td>
						</tr>

					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No results found.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
