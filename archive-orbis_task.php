<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add task', 'orbis' ); ?>
	</a>
</header>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php _e( 'Task', 'orbis' ); ?></th>
						<th><?php _e( 'Assignee', 'orbis' ); ?></th>
						<th><?php _e( 'Due At', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post();

						$due_at = get_post_meta( get_the_ID(), '_orbis_task_due_at', true );

						if ( empty( $due_at ) ) {
								$due_at_ouput = '&mdash;';
						} else {
							$seconds = strtotime( $due_at );
							$delta   = $seconds - time();
							$days    = round( $delta / ( 3600 * 24 ) );

							if ( $days < 0 ) {
								$due_at_ouput = sprintf( __( '<span class="label label-danger">%d days</span>', 'orbis_tasks' ), $days );
							} else {
								$due_at_ouput = '';
							}
						}

						?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

								<div class="entry-meta">
									<span class="glyphicon glyphicon-file"></span> <?php orbis_task_project(); ?> <span class="glyphicon glyphicon-user"></span> <?php orbis_task_assignee(); ?> <span class="glyphicon glyphicon-time"></span> <?php orbis_task_time(); ?>
								</div>
							</td>
							<td>
								<?php echo get_avatar( get_post_meta( get_the_ID(), '_orbis_task_assignee_id', true ), 40 ); ?>
							</td>
							<td>
								<?php orbis_task_due_at(); ?> <?php echo $due_at_ouput; ?>
							</td>
							<td>
								<div class="actions">
									<div class="nubbin">
										<?php orbis_edit_post_link(); ?>

										<?php orbis_finish_task_link(); ?>
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
