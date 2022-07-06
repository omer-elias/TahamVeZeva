<?php get_header();?>

	<div class="error-container">
		<div class="container">
			<div class="oops-text"><?php _e('Oops...','matat'); ?></div>
			<div class="error-info"><?php _e('The requested page was not found','matat') ?></div>
			<div class="error-img">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/error.png" alt="error">
			</div>
			<a href="<?php echo site_url(); ?>" class="btn btn-back-home"><?php _e('Back to the homepage','matat'); ?></a>
		</div>
	</div>

<?php get_footer();?>