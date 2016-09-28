<?php
function wpi_enqueue_mission_post_scripts(){
    if($_SERVER['QUERY_STRING'] === 'post_type=mission') {
        wp_enqueue_script('admin-bootstrap-js-2', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', TRUE);
        wp_enqueue_script('admin-isotope-js-2', get_template_directory_uri() . '/assets/isotope/isotope.pkgd.js', array(), '3.0', TRUE);
        $user = wp_get_current_user();
        $logged_in_user = array(
            'username' => $user->data->user_nicename,
            'user_id' => $user->ID
        );
        wp_register_script('admin-mission-post-js', get_template_directory_uri() . '/includes/missions/js/admin-missions.js', array(), '0.1', true);
        wp_localize_script('admin-mission-post-js', 'agents', $logged_in_user);
        wp_enqueue_script('admin-mission-post-js');

        wp_enqueue_style('admin-bootstrap-css-2', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
    }
    global $post_type;
    if($post_type == 'mission'){
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', TRUE);
        wp_enqueue_script('material-js', get_template_directory_uri() . '/assets/material/js/material.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script('ripples-js', get_template_directory_uri() . '/assets/material/js/ripples.min.js', array('jquery'), null, TRUE);
        wp_enqueue_script( 'ajax_admin_script', get_template_directory_uri() . '/includes/missions/js/ajax-backend-mission.js', array('jquery'), null, true );

        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('material-css', get_template_directory_uri() . '/assets/material/css/bootstrap-material-design.min.css');
        wp_enqueue_style('ripples-css', get_template_directory_uri() . '/assets/material/css/ripples.min.css');
        wp_enqueue_style('fontawesome-css', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');
        wp_enqueue_style( 'custom-css', get_stylesheet_uri() );
    }
}
add_action('admin_enqueue_scripts', 'wpi_enqueue_mission_post_scripts');

add_action( 'init', 'wpi_create_mission_post_type' );
function wpi_create_mission_post_type() {

    $labels = array(
        'name'                => __( 'Missions', WPISSUES_THEME_NAME ),
        'singular_name'       => __( 'Mission', WPISSUES_THEME_NAME ),
        'add_new'             => __( 'Add New', WPISSUES_THEME_NAME ),
        'add_new_item'        => __( 'Add New Mission', WPISSUES_THEME_NAME ),
        'edit_item'           => __( 'Edit Mission', WPISSUES_THEME_NAME ),
        'new_item'            => __( 'New Mission', WPISSUES_THEME_NAME ),
        'all_items'           => __( 'All Mission', WPISSUES_THEME_NAME ),
        'view_item'           => __( 'View Mission', WPISSUES_THEME_NAME ),
        'search_items'        => __( 'Search Missions', WPISSUES_THEME_NAME ),
        'not_found'           => __( 'No missions found', WPISSUES_THEME_NAME ),
        'not_found_in_trash'  => __( 'No missions found in Trash', WPISSUES_THEME_NAME ),
        'menu_name'           => __( 'Missions', WPISSUES_THEME_NAME ),
    );

    $supports = array( 'title');

    $slug = get_theme_mod( 'mission_permalink' );
    $slug = ( empty( $slug ) ) ? 'mission' : $slug;

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => false,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => $slug ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'supports'            => $supports,
        'menu_icon' => 'dashicons-tickets'
    );

    register_post_type( 'mission', $args );

}
add_action( 'admin_menu', 'wpi_remove_meta_boxes' );
function wpi_remove_meta_boxes(){
    $post_types = get_post_types();
    foreach($post_types as $post_type){
        remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
        remove_meta_box( 'commentsdiv', $post_type, 'normal' );
        remove_meta_box( 'slugdiv', $post_type, 'normal' );
    }
}
function wpi_adding_custom_meta_boxes( $post ) {
    add_meta_box(
        'wpi-assigned-agent',
        __( 'Assigned Agent' ),
        'render_wpi_assigned_agent',
        'mission',
        'side',
        'high'
    );
    add_meta_box(
        'wpi-mission-info',
        __( 'Mission Info' ),
        'render_wpi_mission_info',
        'mission',
        'normal',
        'default'
    );
    add_meta_box(
        'wpi-chat-box',
        __( 'Mission Chat' ),
        'render_wpi_mission_chat',
        'mission',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes_mission', 'wpi_adding_custom_meta_boxes' );
function render_wpi_assigned_agent($object){
    wp_nonce_field(basename(__FILE__), "wpi-assigned-agent-nonce");

    ?>
    <div>
        <select id="assigned_agent" name="assigned_agent">
            <option selected value="0" disabled>Choose Agent</option>
            <?php
                $args = array(
                    'blog_id'      => $GLOBALS['blog_id'],
                    'role'         => 'administrator'
                );
                $admins = get_users( $args );
                $value = get_post_meta($object->ID, "assigned_agent", true);
                foreach($admins as $admin){
                    $admin_id = $admin->ID;
                    if($value == $admin_id){
                    ?>
                        <option selected value="<?php echo $admin_id; ?>"><?php echo $admin->data->user_nicename; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $admin_id; ?>"><?php echo $admin->data->user_nicename; ?></option>
                        <?php }
                }
            ?>
        </select>
    </div>

<?php
}
function render_wpi_mission_info($object){
    wp_nonce_field(basename(__FILE__), "wpi-mission-info-nonce");
    $mission_id = $object->post_name;
    $order_number = strtoupper($mission_id);
    $date = $object->post_date;
    $order = new WC_Order(wpi_slug_order_number($mission_id));
    $total = $order->get_formatted_order_total();
    $method = get_post_meta( $order->id, '_payment_method', true );
    $status = wpi_get_order_status_from_post_id($object->ID);
    $agent = get_post_meta($object->ID, 'assigned_agent', true);
    $agent = get_user_by('id', $agent);
    $assignment = $agent->data->user_nicename;

    $website_url = get_post_meta($object->ID, 'website_url', true);
    $admin_url = get_post_meta($object->ID, 'admin_url', true);
    $username = get_post_meta($object->ID, 'username', true);
    $password = get_post_meta($object->ID, 'admin_pw', true);
    $details = $object->post_content;

    ?>
    <div>
        <ul class="order-details">
            <li class="order">
                Order Number: <strong><?php echo $order_number; ?></strong>
            </li>
            <li class="date">
                Date: <strong><?php echo $date; ?></strong>
            </li>
            <li class="total">
                Total: <strong><?php echo $total; ?></strong>
            </li>
            <li class="method">
                Payment Method: <strong><?php echo $method; ?></strong>
            </li>
            <li class="status">
                Status: <strong><?php echo $status; ?></strong>
            </li>
            <li class="assignment">
                Agent Assigned: <strong><?php echo $assignment; ?></strong>
            </li>
        </ul>
        <ul class="website-details">
            <li class="website-url">
                Website URL: <strong><?php echo $website_url; ?></strong>
            </li>
            <li class="admin-url">
                Admin URL: <strong><?php echo $admin_url; ?></strong>
            </li>
            <li class="admin-username">
                Admin Username: <strong><?php echo $username; ?></strong>
            </li>
            <li class="admin-pw">
                Admin Password: <strong><?php echo $password; ?></strong>
            </li>
            <li class="details">
                Details: <?php echo $details; ?>
            </li>
        </ul>
    </div>
<?php
}
function render_wpi_mission_chat($object){
    $post_id = $object->ID;
    $mission_id = $object->post_name;
    $order = new WC_Order(wpi_slug_order_number($mission_id));
    echo '<div class="chat_wrapper">';
    echo wpi_mission_question_admin($order, $post_id);
    echo '</div>';
}
function save_wpi_agent_meta_box($post_id){

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wpi-assigned-agent-nonce'] ) && wp_verify_nonce( $_POST['wpi-assigned-agent-nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    $assigned_agent = '';
    if(isset($_POST["assigned_agent"])) {
        $assigned_agent = $_POST["assigned_agent"];
    }
    update_post_meta($post_id, "assigned_agent", $assigned_agent);


}
add_action('save_post', 'save_wpi_agent_meta_box');

function wpi_mission_post_columns($columns){
    unset(
        $columns['date']
    );
    $columns['wpi_from'] = __('From', WPISSUES_THEME_NAME);
    $columns['wpi_status'] = __('Status', WPISSUES_THEME_NAME);
    $columns['wpi_created'] = __('Created On', WPISSUES_THEME_NAME);
    $columns['wpi_assigned'] = __('Assigned Agent', WPISSUES_THEME_NAME);
    return $columns;
}
add_filter('manage_mission_posts_columns', 'wpi_mission_post_columns');
function wpi_mission_columns( $column, $post_id){
    $order = wpi_get_order_from_post_id($post_id);
    $agent = get_post_meta($post_id, 'assigned_agent', true);
    $agent = get_user_by('id', $agent);
    $agent_name = $agent->data->user_nicename;
    switch($column){
        case 'wpi_status':
            echo wpi_get_order_status_from_post_id($post_id);
            break;
        case 'wpi_from':
            $full_name = $order->get_formatted_billing_full_name();
            $user_id = $order->get_user_id();
            $user_data = get_userdata( $user_id );
            $user_email = $user_data->data->user_email;
            $from = $full_name.'<br>';
            $from .= '<small><a href="mailto:'. $user_email .'">' .$user_email. '</a></small>';
            echo $from;
            break;
        case 'wpi_created':
            echo $order->order_date;
            break;
        case 'wpi_assigned':
            echo $agent_name;
            break;
    }

}
add_action('manage_mission_posts_custom_column', 'wpi_mission_columns', 10, 2);

add_filter( 'views_edit-mission', 'wpi_add_my_views');
function wpi_add_my_views($views){
    unset(
        $views['publish'],
        $views['mine']
    );
    $views['my_missions'] = "<a id='view_my_missions'>".__('My Missions', WPISSUES_THEME_NAME)."</a>";
    $views['closed'] = "<a id='view_completed'>".__('Closed', WPISSUES_THEME_NAME)."</a>";
    $views['open'] = "<a id='view_processing'>".__('Open Missions',WPISSUES_THEME_NAME)."</a>";

    return $views;
}
function wpi_get_order_from_post_id($post_id){
    $post = get_post($post_id);
    $order_id = $post->post_name;
    $order_year = date_i18n( 'Y', strtotime( $post->post_date ) );
    $order_id = str_replace("wpi-".$order_year."-", "", $order_id);
    $order_id = intval($order_id) - 100000;
    $order = new WC_Order( $order_id );
    return $order;
}
function wpi_get_order_status_from_post_id($post_id){
    $post = get_post($post_id);
    $order_id = $post->post_name;
    $order_year = date_i18n( 'Y', strtotime( $post->post_date ) );
    $order_id = str_replace("wpi-".$order_year."-", "", $order_id);
    $order_id = intval($order_id) - 100000;
    $order = new WC_Order( $order_id );
    $status = $order->get_status();
    $status = "wc-".$status;
    $valid_statuses = wc_get_order_statuses();

    foreach($valid_statuses as $key => $value){
        if($status === $key){
            $status = $value;
        }
    }
    return $status;
}

function wpi_slug_order_number($slug){
    $str = "wpi-2016-";
    $slug = str_replace($str, '', $slug);
    $slug = (int) $slug;
    $slug = $slug - 100000;
    $slug = (string) $slug;

    return $slug;
}
function wpi_mission_question_admin($order, $post_id) {
    // p($order);

    $chat = '<div id="chat_inner" class="chat_inner">';
    $chat .= '<div id="chat_content" class="chat_content">';
    $questions = wpi_get_questions($post_id);
    foreach($questions as $question){
        if($question->user_role === 'administrator'){
            $chat .= '<div class="chat_message-wrapper chat_me">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'</div>';
            $chat .= '</div>';
        } else {
            $chat .= '<div class="chat_message-wrapper chat_them">';
            $chat .= '<div class="chat_circle-wrapper animated bounceIn"></div>';
            $chat .= '<div class="chat_text-wrapper animated fadeIn">'.$question->message.'</div>';
            $chat .= '</div>';
        }
    }
    $chat .= '</div>';
    $chat .= '</div>';

    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_role = $user->roles[0];

    global $wpdb;
    $creator_id = $wpdb->get_var("SELECT post_author FROM wp_posts WHERE id = ".$post_id);
    $agent_id = $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE post_id = ". $post_id ." AND meta_key = 'assigned_agent'");

    $form = '<input type="hidden" name="order_title" id="order_title" value="'.wpi_show_custom_order_number($order->id, $order).'">';
    $form .= '<input type="hidden" name="post_id" id="post_id" value="'.$post_id.'">';
    $form .= '<input type="hidden" name="order_id" id="order_id" value="'.$order->id.'">';
    $form .= '<input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">';
    $form .= '<input type="hidden" name="user_role" id="user_role" value="'.$user_role.'">';
    $form .= '<input type="hidden" name="user_role" id="user_role" value="'.$user_role.'">';
    $form .= '<input type="hidden" name="creator_id" id="creator_id" value="'.$creator_id.'">';
    if($agent_id != null){
        $form .= '<input type="hidden" name="agent_id" id="agent_id" value="'.$agent_id.'">';
    }
    $form .= '<div id="chat_bottom" class="chat_bottom">';
    $form .= '<textarea class="chat_input" name="chat_input" id="chat_input" placeholder="Enter Message Here"></textarea>';
    $form .= '<button class="chat_send" onclick="adminQuestion()"></button>';
    $form .= '</div>';

    return $chat.$form;
}