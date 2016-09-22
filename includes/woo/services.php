<?php
function wpi_before_shop_loop(){
    $content = '<div class="container">';
    $content .= '<div class="row">';
    $content .= '<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">';
    echo $content;
}
//add_action( 'woocommerce_before_shop_loop', 'wpi_before_shop_loop');

function wpi_after_shop_loop(){
    $content = '</div>';
    echo $content;
}
add_action( 'woocommerce_after_shop_loop', 'wpi_after_shop_loop');