<?php
/**
 * Template Name: FAQs
 */

?>
<?php get_header(); ?>
    <?php woocommerce_breadcrumb(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <?php if ( have_posts() ) : ?>

                            <?php if ( ! is_front_page() ) : ?>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <header>
                                            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                        </header>
                                    </div>
                                    <div class="panel-body">
                            <?php endif; ?>
                            <?php
                            // Start the loop.
                            while ( have_posts() ) : the_post();

                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part( 'template-parts/content', 'faqs' );

                                // End the loop.
                            endwhile;

                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', WPISSUES_THEME_NAME ),
                                'next_text'          => __( 'Next page', WPISSUES_THEME_NAME ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', WPISSUES_THEME_NAME ) . ' </span>',
                            ) );

                        // If no content, include the "No posts found" template.
                        else :
                            get_template_part( 'template-parts/content', 'none' );

                        endif;
                        ?></div>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
