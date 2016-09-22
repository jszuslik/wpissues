<?php
global $post;
$post_id = get_the_ID();
$title = get_the_title($post_id);
$details = get_the_content();
$meta_data = get_post_meta($post_id);
$slug = $post->post_name;

$str = "wpi-2016-";
$slug = str_replace($str, '', $slug);
$slug = (int) $slug;
$slug = $slug - 100000;
$slug = (string) $slug;
// p($slug);

$order_no = $slug;
$order = new WC_Order( $order_no );
//p(gettype($post_id));
//p($meta_data);
?>
<div class="panel panel-default">
    <div class="panel-body">
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
                    Total: <strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span<?php echo $order->get_formatted_order_total(); ?></span></strong>
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
                    <?php
                        $agent = get_post_meta($post->ID, 'assigned_agent', true);
                        $agent = get_user_by('id', $agent);
                        $assignment = $agent->data->user_nicename;
                        if(get_post_meta($post->ID, 'assigned_agent', true)){
                            $assigned_agent = $assignment;
                        } else {
                            $assigned_agent = "N/A";
                        }

                    ?>
                    Agent Assigned: <strong><?php echo $assigned_agent; ?></strong>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-thankyou">
    <div class="panel-heading">
        <h2><?php echo $title; ?></h2>
    </div>
    <div class="panel-body">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h5>Website URL</h5>
            <h3><?php echo $meta_data['website_url'][0]; ?></h3>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h5>Admin URL</h5>
            <h3><?php echo $meta_data['admin_url'][0]; ?></h3>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mission-details">
            <h5>Mission Details</h5>
            <p><?php echo $details; ?></p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mission-details">
            <div class="chat_wrapper">

                <?php echo wpi_mission_question_form($order, $post_id); ?>

            </div>
        </div>
    </div>
</div>

