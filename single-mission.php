<?php
$request_uri = $_SERVER[REQUEST_URI];
$order_no_str = str_replace("/mission/WPI-2016-", "", $request_uri);
$order_no_str = str_replace("/", "", $order_no_str);
$order_no = intval($order_no_str);
$order_no = $order_no - 100000;
$order = new WC_Order( $order_no );

// p($order);

 $user_from_order_id = $order->get_user_id();
$is_admin = current_user_can( 'manage_options' );

$logged_in_user = wp_get_current_user();

$logged_in_user_id = $logged_in_user->ID;
$logged_in_user_email = $logged_in_user->user_email;
$logged_in_user_phone = get_user_meta( $logged_in_user_id, 'billing_phone', true );

if(!$is_admin){
    if($user_from_order_id != $logged_in_user_id){
        $this_site_url = get_site_url();
        $url = $this_site_url . "/my-account/";
        wp_redirect($url);
    }
}
?>
<?php get_header(); ?>
    <?php woocommerce_breadcrumb(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <?php if ( have_posts() ) : ?>


                            <?php
                            // Start the loop.
                            while ( have_posts() ) : the_post();

                                    get_template_part('template-parts/missions/content', 'missiondetails');


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
                        ?>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
