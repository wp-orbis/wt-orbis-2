<?php get_header(); ?>

<header class="clearfix">
	<a class="btn btn-primary pull-right" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php">	
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add post', 'orbis' ); ?>
	</a>
</header>

<?php get_template_part( 'content', 'post' ); ?>

<?php get_footer(); ?>
