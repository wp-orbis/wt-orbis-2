<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add person', 'orbis' ); ?>
	</a>
</header>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php _e( 'Name', 'orbis' ); ?></th>
						<th><?php _e( 'Phone number', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr>
							<td>
								<div class="person-wrapper">
									<div class="avatar">
										<?php if ( has_post_thumbnail() ) : ?>

											<?php the_post_thumbnail( 'avatar' ); ?>

										<?php else : ?>

											<img src="<?php bloginfo('template_directory'); ?>/placeholders/avatar.png" alt="">

										<?php endif; ?>
									</div>

									<div class="details">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

										<p>
											<?php if ( get_post_meta( $post->ID, '_orbis_person_email_address', true ) ) : ?>

												<span class="entry-meta"><?php echo get_post_meta( $post->ID, '_orbis_person_email_address', true ); ?></span> <br />

											<?php endif; ?>

											<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>

												<span class="entry-meta"><?php echo get_post_meta( $post->ID, '_orbis_person_phone_number', true ); ?></span>

											<?php endif; ?>
										</p>
									</div>
								</div>
							</td>
							<td>
								<?php

								$phone_number = get_post_meta( $post->ID, '_orbis_person_phone_number', true );
	
								if ( ! empty( $phone_number ) && function_exists( 'orbis_snom_call_form' ) ) {
									orbis_snom_call_form( $phone_number );
								}

								?>
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
