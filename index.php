<?php get_header(); ?>

<?php if ( is_post_type_archive() ) : ?>

	<div class="section-header clearfix">
		<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
			<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add new', 'orbis' ); ?>
		</a>
	</div>

<?php endif; ?>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>

	<?php if ( have_posts() ) : ?>

		<table class="table table-striped table-condense table-hover">
			<thead>
				<tr>
					<?php if ( is_search() ) : ?><th><?php _e( 'Type', 'orbis' ); ?></th><?php endif; ?>
					<th><?php _e( 'Title', 'orbis' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while ( have_posts() ) : the_post(); ?>

					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( is_search() ) : ?>

							<td>
								<?php

								$post_type = get_post_type_object( get_post_type( $post ) );

								echo $post_type->labels->singular_name;

								?>
							</td>

						<?php endif; ?>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							<?php if ( get_comments_number() != 0  ) : ?>

								<div class="comments-number">
									<span class="glyphicon glyphicon-comment"></span>
									<?php comments_number( '0', '1', '%' ); ?>
								</div>

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
