<?php
function wpi_question_submit_scripts(){
    global $post_type;
    if($post_type == 'mission'){
        wp_register_script('wpi-question-submit-js', get_stylesheet_directory_uri() . '/includes/missions/js/questions.js', array('jquery'), '0.3', true);
        wp_enqueue_script('wpi-question-submit-js');
    }
}
add_action( 'wp_enqueue_scripts', 'wpi_question_submit_scripts' );
add_action( 'wp_ajax_question_submit', 'wpi_submit_question' );
add_action( 'wp_ajax_nopriv_question_submit', 'wpi_submit_question' );
function wpi_submit_question() {
    global $wpdb;

    $table_name = 'wp_wpi_mission_question_table';

    $entry_key = wpi_generate_guid();
    $ip = wpi_get_client_ip();

    if( $_POST['type'] == 'ask_question'){
        if (isset ($_POST['question'])) {
            $message =  $_POST['question'];
        }
        if (isset ($_POST['order_title'])) {
            $order_title = $_POST['order_title'];
        }
        if (isset ($_POST['order_id'])) {
            $order_id = $_POST['order_id'];
        }
        if (isset ($_POST['post_id'])) {
            $post_id =  $_POST['post_id'];
        }
        if (isset ($_POST['user_id'])) {
            $user_id =  $_POST['user_id'];
        }
        if (isset ($_POST['user_role'])) {
            $user_role =  $_POST['user_role'];
        }
        if (isset ($_POST['admin_page'])) {
            $admin_page = $_POST['admin_page'];
        }
    }
    $data = array(
        'entry_key' => $entry_key,
        'post_id' => $post_id,
        'order_title' => $order_title,
        'order_id' => $order_id,
        'user_id' => $user_id,
        'user_role' => $user_role,
        'message' => $message,
        'ip' => $ip
    );
    $format = array(
        '%s',
        '%d',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s'
    );
    $new_question = $wpdb->insert( $table_name, $data, $format );
    $questions = wpi_get_questions($post_id);
    $chat = '';
    foreach($questions as $question){
        $user = get_user_by('ID', $question->user_id);
        $user_name = $user->data->user_nicename;
        if($question->user_role === 'administrator'){
            $chat .= '<div class="chat_message-wrapper chat_me">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'<br><small>'.$user_name.'</small></div>';
            $chat .= '</div>';
        } else {
            $chat .= '<div class="chat_message-wrapper chat_them">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'<br><small>'.$user_name.'</small></div>';
            $chat .= '</div>';
        }
    }
    echo $chat;

    wp_die();
}
add_action( 'wp_ajax_reload_questions', 'wpi_reload_questions' );
add_action( 'wp_ajax_nopriv_reload_questions', 'wpi_reload_questions' );
function wpi_reload_questions(){
    if( $_POST['type'] == 'reload'){
        if (isset ($_POST['order_title'])) {
            $order_title = $_POST['order_title'];
        }
        if (isset ($_POST['admin_page'])) {
            $admin_page = $_POST['admin_page'];
        }
        if (isset ($_POST['post_id'])) {
            $post_id =  $_POST['post_id'];
        }
    }
    $questions = wpi_get_questions($post_id);
    $chat = '';
    foreach($questions as $question){
        $user = get_user_by('ID', $question->user_id);
        $user_name = $user->data->user_nicename;
        if($question->user_role === 'administrator'){
            $chat .= '<div class="chat_message-wrapper chat_me">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'<br><small>'.$user_name.'</small></div>';
            $chat .= '</div>';
        } else {
            $chat .= '<div class="chat_message-wrapper chat_them">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'<br><small>'.$user_name.'</small></div>';
            $chat .= '</div>';
        }
    }
    echo $chat;
    wp_die();
}