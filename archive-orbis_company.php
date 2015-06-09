<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo esc_url( orbis_get_url_post_new() ); ?>">		
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add company', 'orbis' ); ?>
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
						<th><?php _e( 'Address', 'orbis' ); ?></th>
						<th><?php _e( 'Online', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php 

								$favicon_url = orbis_get_favicon_url( get_post_meta( get_the_ID(), '_orbis_company_website', true ) );

								if ( ! empty( $favicon_url ) ) : ?>

									<img src="<?php echo esc_attr( $favicon_url ); ?>" alt="" />

								<?php endif; ?>

								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php if ( get_comments_number() != 0  ) : ?>

									<div class="comments-number">
										<span class="glyphicon glyphicon-comment"></span>
										<?php comments_number( '0', '1', '%' ); ?>
									</div>

								<?php endif; ?>
							</td>
							<td>
								<?php

								$address  = get_post_meta( $post->ID, '_orbis_company_address', true );
								$postcode = get_post_meta( $post->ID, '_orbis_company_postcode', true );
								$city     = get_post_meta( $post->ID, '_orbis_company_city', true );

								printf( '%s<br />%s %s', $address, $postcode, $city );

								?>
							</td>
							<td>
								<?php

								$break = '';

								$website = get_post_meta( $post->ID, '_orbis_company_website', true );

								if ( ! empty( $website ) ) {
									printf( '<a href="%s" target="_blank">%s</a>', $website, $website );

									$break = '<br />';
								}

								$email = get_post_meta( $post->ID, '_orbis_company_email', true );

								if ( ! empty( $email ) ) {
									printf( $break );

									printf( '<a href="mailto:%s" target="_blank">%s</a>', $email, $email );
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
