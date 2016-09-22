<?php
/**
 * Template Name: Mission Details
 */
$wpi_order = get_query_var( 'wpi_order_id' );
$order = new WC_Order( $wpi_order );

$user_from_order_id = $order->get_user_id();
$logged_in_user = wp_get_current_user();
$logged_in_user_id = $logged_in_user->ID;
if(!$is_admin){
    if($user_from_order_id != $logged_in_user_id){
        $this_site_url = get_site_url();
        $url = $this_site_url . "/my-account/";
        $js = "<script>";
        $js .= "window.location.replace('".$url."')";
        $js .= "</script>";
        echo $js;
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
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <header>
                                            <h1 class="page-title screen-reader-text">Order #<?php echo $order->id ?></h1>
                                        </header>
                                    </div>
                                    <div class="panel-body">

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
                            endwhile; ?>
                                        <div class="woocommerce">
                                            <p class="woocommerce-thankyou-order-received">Thank you. Your order has been received.</p>
                                            <ul class="woocommerce-thankyou-order-details order_details">
                                                <li class="order">
                                                    Order Number: <strong><?php echo $order->id; ?></strong>
                                                </li>
                                                <li class="date">
                                                    Date: <strong><?php
                                                        $order_time = strtotime($order->order_date);
                                                        $order_date = date('F j, Y', $order_time);
                                                        echo $order_date;
                                                        ?></strong>
                                                </li>
                                                <li class="total">
                                                    Total: <strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php echo $order->get_total(); ?>.00</span></strong>
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
                                                    Status: <strong><?php echo $order->get_status(); ?></strong>
                                                </li>
                                                <li class="assignment">
                                                    Agent Assigned: <strong>N/A</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        endif;
                        ?>
                    </main>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php include(locate_template('template-parts/missions/content-missiondetails.php')); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
