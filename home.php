<?php get_header(); ?>

<div class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php">
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add post', 'orbis' ); ?>
	</a>
</div>

<?php get_template_part( 'content', 'post' ); ?>

<?php get_footer(); ?>
