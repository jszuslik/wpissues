<?php

// Redirect custom thank you

add_action( 'woocommerce_thankyou', 'wpi_thankyou_redirect');

function wpi_thankyou_redirect( $order_id ){
    $order = new WC_Order( $order_id );

    // $items = $order->get_items();

    // p($items);
    $this_site_url = get_site_url();
    $url = $this_site_url . '/my-missions/?wpi_order_id=' . $order_id;

    if ( $order->status != 'failed' ) {
        wp_redirect($url);
    }
}

function wpi_add_query_vars($aVars) {
    $aVars[] = "wpi_order_id";
    $aVars[] = "wpi_submitted_email";
    return $aVars;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'wpi_add_query_vars');