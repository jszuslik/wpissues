<?php
function wpi_mission_submit_scripts(){
    wp_register_script('wpi-mission-submit-js', get_stylesheet_directory_uri() . '/includes/missions/js/missions.js', array('jquery'), '2.16', true);
    wp_localize_script( 'wpi-mission-submit-js', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
    wp_enqueue_script('wpi-mission-submit-js');
}
add_action( 'wp_enqueue_scripts', 'wpi_mission_submit_scripts' );

add_action( 'wp_ajax_mission_submit', 'wpi_mission_submit_info' );
add_action( 'wp_ajax_nopriv_mission_submit', 'wpi_mission_submit_info' );

//$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
//require_once( $parse_uri[0] . 'wp-load.php' );
function wpi_mission_submit_info()
{
    if ($_POST['type'] == 'mission') {
        if (isset ($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
        }
        if (isset ($_POST['order_title'])) {
            $order_title = $_POST['order_title'];
        }
        if (isset ($_POST['user_role'])) {
            $user_role = $_POST['user_role'];
        }
        if (isset ($_POST['order_id'])) {
            $order_id = $_POST['order_id'];
            $mission_title = '#' . $order_id . ' - ';
        }
        if (isset ($_POST['contact_method'])) {
            $contact_method = $_POST['contact_method'];
        }
        if (isset ($_POST['contact_info'])) {
            $contact_info = $_POST['contact_info'];
        }
        if (isset ($_POST['website_url'])) {
            $website_url = $_POST['website_url'];
        }
        if (isset ($_POST['admin_url'])) {
            $admin_url = $_POST['admin_url'];
        }
        if (isset ($_POST['username'])) {
            $username = $_POST['username'];
        }
        if (isset ($_POST['admin_pw'])) {
            $admin_pw = $_POST['admin_pw'];
        }
        if (isset ($_POST['details'])) {
            $details = $_POST['details'];
        }
        $meta_data = array(
            'user_role' => $user_role,
            'contact_method' => $contact_method,
            'contact_info' => $contact_info,
            'website_url' => $website_url,
            'admin_url' => $admin_url,
            'username' => $username,
            'admin_pw' => $admin_pw
        );
        $mission = array(
            'post_content' => $details,
            'post_title' => $mission_title . $order_title,
            'post_status' => 'publish',
            'post_type' => 'mission',
            'comment_status' => 'open',
            'ping_status' => 'closed',
            'post_name' => $order_id,
            'guid' => $order_id,
            'meta_input' => $meta_data
        );
        wp_insert_post($mission);

    }
    do_action('wp_insert_post', 'wp_insert_post');
    echo url()."/mission/".$order_id;
    wp_die();
}