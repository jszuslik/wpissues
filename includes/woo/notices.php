<?php

function wpi_custom_add_to_cart_message( $message, $product_id ) {
    $message = '<div class="row">';
        $message .= '<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">';
            $message .= '<p class="wpi_woo_message">&ldquo;' . get_the_title($product_id) . '&rdquo; has been added to your cart.</p>';
        $message .= '</div>';
        $message .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">';
            $message .= '<a href="/cart" class="btn btn-raised btn-danger">View Cart</a>';
        $message .= '</div>';
    $message .= '</div>';

    return $message;
}
add_filter('wc_add_to_cart_message', 'wpi_custom_add_to_cart_message', 10, 2 );

function wpi_notice_scripts(){
    wp_enqueue_style('notice-woo-css', get_template_directory_uri() . '/includes/woo/css/notices.css');
}
add_action( 'wp_enqueue_scripts', 'wpi_notice_scripts' );