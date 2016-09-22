<?php
//add_action( 'admin_init', 'remove_admin_styles' );
//function remove_admin_styles(){
//    wp_deregister_style(
//        'wp-admin',
//        'ie',
//        'colors',
//        'colors-fresh',
//        'colors-classic',
//        'media',
//        'install',
//        'thickbox',
//        'farbtastic',
//        'jcrop',
//        'imgareaselect',
//        'admin-bar',
//        'wp-jquery-ui-dialog',
//        'editor-buttons',
//        'wp-pointer',
//        'jquery-listfilterizer',
//        'jquery-ui-smoothness',
//        'tooltips'
//    );
//}
function wpissues_register_js() {
    if (!is_admin()){
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', TRUE);
        wp_enqueue_script('material-js', get_template_directory_uri() . '/assets/material/js/material.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script('ripples-js', get_template_directory_uri() . '/assets/material/js/ripples.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script('owl-js', get_template_directory_uri() . '/assets/owl-carousel/js/owl.carousel.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script('inputmask-js', get_template_directory_uri() . '/assets/inputmask/jquery.inputmask.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script('custom-js', get_template_directory_uri() . '/src/js/custom.js', array('jquery'), null, TRUE);
        
    }

}
add_action('wp_enqueue_scripts', 'wpissues_register_js');
add_action('admin_enqueue_scripts', 'wpissues_register_js');

function wpissues_register_css() {

    if (!is_admin()){
        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('material-css', get_template_directory_uri() . '/assets/material/css/bootstrap-material-design.min.css');
        wp_enqueue_style('ripples-css', get_template_directory_uri() . '/assets/material/css/ripples.min.css');
        wp_enqueue_style('fontawesome-css', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');
        wp_enqueue_style('owl-css', get_template_directory_uri() . '/assets/owl-carousel/css/owl.carousel.css');
        wp_enqueue_style( 'custom-css', get_stylesheet_uri(), array(), '1.4' );
    }

}
add_action( 'wp_enqueue_scripts', 'wpissues_register_css' );
add_action('admin_enqueue_scripts', 'wpissues_register_css');

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

?>