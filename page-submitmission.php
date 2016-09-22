<?php
/**
 * Template Name: Mission Submit Page
 */

$wpi_order = get_query_var( 'wpi_order_id' );
// p($wpi_order);
$order = new WC_Order( $wpi_order );

// p($order);
$slug = wpi_show_custom_order_number( $order->id, $order);
$mission_id = wpi_get_ID_by_slug($slug);
// p($mission_id);
if($mission_id){
    $this_site_url = get_site_url();
    $url = $this_site_url . "/mission/" . $slug;
    $js = "<script>";
    $js .= "window.location.replace('".$url."')";
    $js .= "</script>";
    echo $js;
}
$user_from_order_id = $order->get_user_id();
$is_admin = current_user_can( 'manage_options' );

$logged_in_user = wp_get_current_user();
// p($logged_in_user->roles[0]);

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

<?php
$globals = array(
    'userEmail' => $logged_in_user_email,
    'userPhone' => $logged_in_user_phone,
    'get_customer_details_nonce' => wp_create_nonce('get-customer-details')
);
wp_localize_script( 'custom-js', 'globals', $globals ); ?>
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
                                            <h1 class="page-title screen-reader-text"><?php echo wpi_show_custom_order_number($order->id, $order) ?></h1>
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
                                get_template_part( 'template-parts/content', get_post_format() );

                                // End the loop.
                            endwhile;

                            ?>
                                        <div class="woocommerce">
                                            <p class="woocommerce-thankyou-order-received">Thank you. Your order has been received.</p>
                                            <ul class="woocommerce-thankyou-order-details order_details">
                                                <li class="order">
                                                    Order Number: <strong><?php echo wpi_show_custom_order_number($order->id, $order); ?></strong>
                                                </li>
                                                <li class="date">
                                                    Date: <strong><?php
                                                        $order_time = strtotime($order->order_date);
                                                        $order_date = date('F j, Y', $order_time);
                                                        echo $order_date;
                                                        ?></strong>
                                                </li>
                                                <li class="total">
                                                    Total: <strong><span class="woocommerce-Price-amount amount"><?php echo $order->get_formatted_order_total(); ?></strong>
                                                </li>
                                                <li class="method">
                                                    Payment Method: <strong><?php
                                                        $method = get_post_meta( $order->id, '_payment_method', true );
                                                        switch($method) {
                                                            case 'stripe':
                                                                echo 'Credit Card (Stripe)';
                                                                break;
                                                        }

                                                        ?></strong>
                                                </li>
                                                <li class="status">
                                                    Status: <strong><?php echo wpi_get_order_status_from_post_id($mission_id); ?></strong>
                                                </li>
                                                <li class="assignment">
                                                    Agent Assigned: <strong>N/A</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                                    <?php
                        // If no content, include the "No posts found" template.
                        else :
                            get_template_part( 'template-parts/content', 'none' );

                        endif;
                        ?>
                    </main>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="wpi_order_form">
                    <?php
                    $form = wpi_mission_submit_form($order);
                    echo $form;

                    ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
