<?php get_header(); ?>

<header class="clearfix">
	<h3 class="pull-left"><?php _e( 'Overview', 'orbis' ); ?></h3>

	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add deal', 'orbis' ); ?>
	</a>
</header>

<div class="panel">
	<?php get_template_part( 'templates/search_form' ); ?>
	
	<?php if ( have_posts() ) : ?>
		
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condense table-hover">
				<thead>
					<tr>
						<th><?php _e( 'Date', 'orbis' ); ?></th>
						<th><?php _e( 'Company', 'orbis' ); ?></th>
						<th><?php _e( 'Title'  , 'orbis' ); ?></th>
						<th><?php _e( 'Price'  , 'orbis' ); ?></th>
						<th><?php _e( 'Status' , 'orbis' ); ?></th>
						<th><?php _e( 'Author' , 'orbis' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>
	
						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php the_date(); ?>
							</td>
							<td>
								<?php orbis_deal_the_company_name(); ?>
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
							<td>
								<?php orbis_deal_the_price(); ?>
							</td>
							<td>
								<?php orbis_deal_the_status(); ?>
							</td>
							<td>
								<div class="actions">
									<?php the_author(); ?>
							
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