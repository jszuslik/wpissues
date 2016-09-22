<?php
function wpi_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<div class="container"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><ul class="breadcrumb panel">',
        'wrap_after'  => '</ul></div></div></div>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'wpi_woocommerce_breadcrumbs' );


?>