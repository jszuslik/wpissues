<?php
/*-------------------------------------------------------------------------------------------*/
/* wpi_slides Post Type */
/*-------------------------------------------------------------------------------------------*/
class wpi_slides {

    function wpi_slides() {
        add_action('init',array($this,'create_post_type'));
    }

    function create_post_type() {
        $labels = array(
            'name' => 'Slides',
            'singular_name' => 'Slide',
            'add_new' => 'Add New',
            'all_items' => 'All Slides',
            'add_new_item' => 'Add New Slide',
            'edit_item' => 'Edit Slide',
            'new_item' => 'New Slide',
            'view_item' => 'View Slide',
            'search_items' => 'Search Slides',
            'not_found' =>  'No Slides Found',
            'not_found_in_trash' => 'No Slides found in trash',
            'parent_item_colon' => 'Parent Slide:',
            'menu_name' => 'Slides'
        );
        $args = array(
            'labels' => $labels,
            'description' => "Slides Used On Home Page",
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-format-gallery',
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array('title'),
            'has_archive' => false,
            'rewrite' => false,
            'query_var' => true,
            'can_export' => true
        );
        register_post_type('wpi_slides',$args);
    }
}

$wpi_slides = new wpi_slides();
