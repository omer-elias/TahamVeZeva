<?php
/**
 * The template for main file
 *
 * @package Matat
 * @since matat 2.0
 */
?>
<?php get_header(); ?>
<main id="main">
    <div class="container">
        <div class="single-product-section">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			the_content();

			// End the loop.
		endwhile;

		?>
        </div>
    </div>
</main>
<?php get_footer(); ?>

