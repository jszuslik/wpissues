<?php


/****** Cart ******/

function wpi_before_cart_table(){
    $content = '<div class="panel panel-default">';
    $content .= '<div class="panel-body cart_panel">';
    echo $content;
}
add_action( 'woocommerce_before_cart_table', 'wpi_before_cart_table');

function wpi_after_cart_table(){
    $content = '</div>';
    $content .= '</div>';
    echo $content;
}
add_action( 'woocommerce_after_cart_table', 'wpi_after_cart_table');

function filter_woocommerce_cart_item_class( $cart_item, $cart_item_key ) {
    $cart_item = 'cart_item danger';
    return $cart_item;
};
add_filter( 'woocommerce_cart_item_class', 'filter_woocommerce_cart_item_class', 10, 3 );

function wpi_cart_scripts(){
    wp_enqueue_style('cart-woo-css', get_template_directory_uri() . '/includes/woo/css/cart.css');
}
add_action( 'wp_enqueue_scripts', 'wpi_cart_scripts' );

function wpi_allow_one_item_in_cart( $cart_item_data ) {
    global $woocommerce;
    $woocommerce->cart->empty_cart();

    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'wpi_allow_one_item_in_cart' );

function wpi_redirect_to_checkout() {
    return WC()->cart->get_checkout_url();
}
add_filter ('woocommerce_add_to_cart_redirect', 'wpi_redirect_to_checkout');