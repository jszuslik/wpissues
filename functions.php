<?php

#-----------------------------------------------------------------#
# Default theme constants
#-----------------------------------------------------------------#
define('WPISSUES_THEME_NAME', 'wpissues');
define('WPISSUES_FOLDER', $_SERVER['DOCUMENT_ROOT']);
define('WPISSUES_THEME_FOLDER', str_replace("\\", "/", dirname(__FILE__)));
define('WPISSUES_THEME_PATH', '/' . substr(WPISSUES_THEME_FOLDER, stripos(WPISSUES_THEME_FOLDER, 'wp-content')));
define( 'GITHUB_UPDATER_EXTENDED_NAMING', true );

function p($value){
    echo '<pre>'; var_dump($value); echo '</pre>';
}


function wpi_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', WPISSUES_THEME_NAME),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', WPISSUES_THEME_NAME),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Shop Sidebar', WPISSUES_THEME_NAME),
        'id' => 'shop-sidebar',
        'description' => __('Add widgets here to appear in your sidebar.', WPISSUES_THEME_NAME),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action( 'widgets_init', 'wpi_widgets_init' );

register_nav_menus( array(
    'primary' => __( 'Primary Menu', WPISSUES_THEME_NAME ),
    'quick' => __( 'Quick Links', WPISSUES_THEME_NAME )
) );

#-----------------------------------------------------------------#
# Register/Enqueue JS
#-----------------------------------------------------------------#
require_once('includes/scripts/scripts.php');


#-----------------------------------------------------------------#
# Custom Includes
#-----------------------------------------------------------------#
require_once('includes/custom/wp_bootstrap_navwalker.php');
require_once('includes/custom/options.php');
require_once('includes/custom/custom-functions.php');
require_once('includes/custom/custom-meta-boxes.php');
require_once('includes/custom/slides/slides-post-type.php');
require_once('includes/custom/slides/slide-meta-boxes.php');
require_once('includes/custom/homepage/homepage-meta-boxes.php');
require_once('includes/email-submit-plugin/email-submit.php');
require_once('includes/email-submit-plugin/email-ajax.php');
require_once('includes/custom/faqs/admin/faqs-admin.php');

#-----------------------------------------------------------------#
# WooCommerce Includes
#-----------------------------------------------------------------#
require_once('includes/woo/woo-integration.php');
require_once('includes/woo/breadcrumbs.php');
require_once('includes/woo/single.php');
require_once('includes/woo/notices.php');
require_once('includes/woo/cart.php');
require_once('includes/woo/services.php');
require_once('includes/woo/thankyou-redirect.php');
require_once('includes/woo/orders.php');

#-----------------------------------------------------------------#
# Mission Includes
#-----------------------------------------------------------------#
require_once('includes/missions/missions.php');
require_once('includes/missions/missions-ajax.php');
require_once('includes/missions/questions-ajax.php');
require_once('includes/missions/missions-db.php');
require_once('includes/missions/mission-posts.php');

