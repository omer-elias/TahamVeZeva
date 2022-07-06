<?php
/**
 * The template for displaying search results pages.
 *
 * @package Matat
 * @since Matat 2.0
 */

get_header(); ?>
<div class="container">
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="content" class="site-content">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <?php if ( have_posts() ) : ?>

                        <header class="page-header">
                            <h1 class="page-title"><h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'matat' ), get_search_query() ); ?></h1></h1>

                        </header><!-- .page-header -->
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post(); ?>

                            <?php
                            /*
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'content', 'search' );

                            // End the loop.
                        endwhile;
                        // Previous/next page navigation.
                        the_posts_pagination(array(
                            'prev_text' => __('Previous page', 'matat'),
                            'next_text' => __('Next page', 'matat'),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'matat') . ' </span>',
                        ));

                        // If no content, include the "No posts found" template.
                        else :
                        get_template_part( 'content', 'none' );

                        endif;
                        ?>
                    </main><!-- .main -->
                </div><!-- .content-area -->
            </div><!-- .site-content -->
        </div><!-- .col-lg-12 -->
    </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
