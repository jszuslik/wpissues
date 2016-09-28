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
        if (isset ($_POST['creator_id'])) {
            $creator_id = $_POST['creator_id'];
        }
        if (isset ($_POST['agent_id'])) {
            $agent_id = $_POST['agent_id'];
        }
    }
    if($creator_id == $user_id){
        wpi_email_on_question($agent_id, $creator_id, $order_title, $message);
    } else {
        wpi_email_on_question($creator_id, $agent_id, $order_title, $message);
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

function wpi_email_on_question($to, $from, $subject, $question) {
    if($to != null){
        $to_user = get_user_by('ID', $to);
        $to_user_email = $to_user->user_email;
    } else {
        $to_user = get_user_by('ID', 1);
        $to_user_email = $to_user->user_email;
    }
    if($from != null){
        $from_user = get_user_by('ID', $from);
        $from_user_email = $from_user->user_email;
    } else {
        $from_user = get_user_by('ID', 1);
        $from_user_email = $from_user->user_email;
    }

    $headers = "From: do-not-reply@wp-issues.com\r\n";
    $headers .= "Reply-To: do-not-reply@wp-issues.com\r\n";
    $headers .= "CC: " . $from_user_email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = '<html><body>';
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $message .= "<tr style='background: #eee;'><td><strong>Order Number:</strong> </td><td>" . $subject . "</td></tr>";
    $message .= "<tr><td><strong>Email:</strong> </td><td>" . $from_user_email . "</td></tr>";
    $message .= "<tr><td><strong>Message:</strong> </td><td>" . $question . "</td></tr>";
    $message .= "<tr><td><strong>Mission URL (click to respond):</strong> </td><td>" . url(). "/mission/". $subject . "</td></tr>";
    $message .= "</table>";
    $message .= '</body></html>';

    @mail($to_user_email, $subject, $message, $headers);

}