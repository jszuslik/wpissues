<?php
function url(){
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}


function wpi_mission_question_form($order, $post_id) {
    $header = '<nav id="chat_nav" class="chat_nav">
                    <div class="chat_default-nav">
                        <div class="chat_main-nav">
                            <h5 class="chat_main-nav-item">Ask A Question Here</h5>
                        </div>
                    </div>
                </nav>';

    $chat = '<div id="chat_inner" class="chat_inner">';
    $chat .= '<div id="chat_content" class="chat_content">';
    $questions = wpi_get_questions($post_id);
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
    $chat .= '</div>';
    $chat .= '</div>';

    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_role = $user->roles[0];

    $creator_id = get_the_author_id();
    $agent_id = get_post_meta($post_id, 'assigned_agent', true);

    $form = '<input type="hidden" name="order_title" id="order_title" value="'.wpi_show_custom_order_number($order->id, $order).'">';
    $form .= '<input type="hidden" name="post_id" id="post_id" value="'.$post_id.'">';
    $form .= '<input type="hidden" name="order_id" id="order_id" value="'.$order->id.'">';
    $form .= '<input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">';
    $form .= '<input type="hidden" name="user_role" id="user_role" value="'.$user_role.'">';
    $form .= '<input type="hidden" name="creator_id" id="creator_id" value="'.$creator_id.'">';
    $form .= '<input type="hidden" name="agent_id" id="agent_id" value="'.$agent_id.'">';
    $form .= '<div id="chat_bottom" class="chat_bottom">';
    $form .= '<textarea class="chat_input" name="chat_input" id="chat_input" placeholder="Ask Question Here"></textarea>';
    $form .= '<button class="chat_send" onclick="askQuestion()"></button>';
    $form .= '</div>';

    return $header.$chat.$form;
}

function wpi_get_questions($post_id) {
    global $wpdb;
    $sql = "SELECT * FROM wp_wpi_mission_question_table WHERE post_id = ".$post_id." ORDER BY id ASC";

    $questions = $wpdb->get_results($sql, OBJECT);

    return $questions;
}

function wpi_mission_submit_form($order) {
    $items = $order->get_items();
    foreach($items as $item){
        $name = $item['name'];
    }
    $logged_in_user = wp_get_current_user();
    $logged_in_user_id = $logged_in_user->ID;
    foreach($logged_in_user->roles as $role){
        $role = $role;
    }


    $form = '<div class="panel panel-thankyou">
        <div class="panel-heading">
            <h2>Mission: '. $name .'</h2>
        </div>
        <div class="panel-body">
            
                <input class="hidden" name="user_id" id="user_id" value="'. $logged_in_user_id.'">
                <input class="hidden" name="order_title" id="order_title" value="'. $name .'">
                <input class="hidden" name="user_role" id="user_role" value="'.$role .'">
                <input class="hidden" name="order_id" id="order_id" value="'. wpi_show_custom_order_number($order->id, $order) .'">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-push-1 col-md-5 col-lg-push-1 col-lg-5">
                        <h4>Primary Method of Contact</h4>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="contact-check" name="contact_method" value="email"> E-mail
                            </label>
                            <label>
                                <input type="checkbox" class="contact-check" name="contact_method" value="phone"> Phone
                            </label>
                            <label>
                                <input type="checkbox" class="contact-check" name="contact_method" value="skype"> Skype
                            </label>
                            <!--                        <label>-->
                            <!--                            <input type="checkbox" class="contact-check" name="contact_method" value="other"> Other-->
                            <!--                        </label>-->
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-push-1 col-lg-5">
                        <div id="contact_checks"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-push-1 col-lg-5">
                        <div class="form-group">
                            <label for="website" class="control-label">Website URL</label>
                            <input type="text" name="website_url" class="form-control" id="website_url" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-push-1 col-lg-5">
                        <div class="form-group">
                            <label for="admin_url" class="control-label">Website Admin URL</label>
                            <input type="text" class="form-control" name="admin_url" id="admin_url" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-push-1 col-lg-5">
                        <div class="form-group">
                            <label for="username" class="control-label">Admin Username</label>
                            <input type="text" class="form-control" name="username" id="username" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-push-1 col-lg-5">
                        <div class="form-group">
                            <label for="admin_pw" class="control-label">Admin Password</label>
                            <input type="password" class="form-control" name="admin_pw" id="admin_pw" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-10 col-lg-push-1">
                        <div class="form-group">
                            <label for="details" class="control-label">Mission Details</label>
                            <textarea class="form-control" name="details" id="details" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-md-push-1 col-lg-4 col-lg-push-1">
                        <button class="btn btn-raised btn-danger" onclick="addMission()">Submit</button>
                    </div>
                </div>
            
        </div>
    </div>';
    return $form;
}
function wpi_get_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug, OBJECT, 'mission');
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}
add_filter( 'woocommerce_order_number', 'hyperv_custom_order_number', 99, 2);
function hyperv_custom_order_number( $order_number, $order ) {
    if ( isset( $order_number ) ) {
        $order_number = (int) ltrim($order_number, '#'); // strip #
        $order_number = $order_number + 100000; // padding / offset
        $order_year = date_i18n( 'Y', strtotime( $order->order_date ) );

        // B-2014-100002
        $order_number = 'WPI-' . $order_year . '-' . $order_number;
    }

    return $order_number;
}
function wpi_show_custom_order_number( $order_number, $order) {
    if ( isset( $order_number ) ) {
        $order_number = (int) ltrim($order_number, '#'); // strip #
        $order_number = $order_number + 100000; // padding / offset
        $order_year = date_i18n( 'Y', strtotime( $order->order_date ) );

        // B-2014-100002
        $order_number = 'WPI-' . $order_year . '-' . $order_number;
    }

    return $order_number;
}
add_filter( 'slack_event_transition_post_status_post_types', function( $post_types ) {
    $post_types[] = 'mission';

    return $post_types;
} );
function wpi_add_open_status(){
    register_post_status('wc-open-mission', array(
        'label' => 'Open Mission',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop( 'Open <span class="count">(%s)</span>', 'Open <span class="count">(%s)</span>' )
    ));
}
add_action( 'init', 'wpi_add_open_status' );

function wpi_add_open_to_order_statuses($order_statuses){

    $order_statuses['wc-processing'] = 'Open Mission';
    $order_statuses['wc-completed'] = 'Closed';

    return $order_statuses;
}
add_filter( 'wc_order_statuses', 'wpi_add_open_to_order_statuses', 10, 1 );

?>
