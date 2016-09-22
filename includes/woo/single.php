<?php
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function wpi_before_single_product(){
    $content = '<div class="container">';
    $content .= '<div class="row">';
    $content .= '<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">';
    $content .= '<div class="panel panel-default">';
    $content .= '<div class="panel-body">';
    echo $content;
}
add_action( 'woocommerce_before_single_product', 'wpi_before_single_product');

function wpi_after_single_product(){
    $content = '</div></div></div></div>';
    $content .= '<div class="panel panel-default">';
    $content .= '<div class="panel-body attribute_tabs">';
    echo $content;
}
add_action( 'woocommerce_after_single_product_summary', 'wpi_after_single_product', 5 );

function wpi_remove_product_tabs( $tabs ) {

    // unset( $tabs['description'] );      	// Remove the description tab
    // unset( $tabs['reviews'] ); 			// Remove the reviews tab
    // unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'wpi_remove_product_tabs', 98 );

function wpi_single_product_scripts(){
    wp_enqueue_style('single-woo-css', get_template_directory_uri() . '/includes/woo/css/single-product.css');
}
add_action( 'wp_enqueue_scripts', 'wpi_single_product_scripts' );





?>