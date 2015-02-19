<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">		
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add company', 'orbis' ); ?>
	</a>
</header>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>
	
	<?php if ( have_posts() ) : ?>
		
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condense table-hover">
				<thead>
					<tr>
						<th><?php _e( 'Name', 'orbis' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>
		
						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<div class="actions">
									<?php if ( get_post_meta( $post->ID, '_orbis_company_website', true ) ) : ?>
								
										<?php $favicon_url = add_query_arg( 'domain', get_post_meta( $post->ID, '_orbis_company_website', true ), 'https://plus.google.com/_/favicon' ); ?>
								
										<img src="<?php echo esc_attr( $favicon_url ); ?>" alt="" />

									<?php endif; ?>

									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

									<?php if ( get_comments_number() != 0  ) : ?>
							
										<div class="comments-number">
											<span class="glyphicon glyphicon-comment"></span>
											<?php comments_number( '0', '1', '%' ); ?>
										</div>
							
									<?php endif; ?>
							
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