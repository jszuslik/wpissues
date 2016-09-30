<?php
function wpi_email_form(){
    $form = '<form id="wpi_email_form" name="wpi_email_submit_form" type="post" action="#" >
    <input type="hidden" id="email-url" value="'.get_template_directory_uri().'/includes/email-submit-plugin/email-ajax.php" />
    <div class="form-group label-floating is-empty">
        <label for="focusedInput2" class="control-label">Enter Your E-mail Address
        </label>
        <input type="email" id="email" name="email" class="form-control" autocomplete="off" required>

        <p class="help-block">Your e-mail will only be used to communicate with you</p>

    </div>
    <input type="button" value="Submit Mission Now!" class="btn btn-raised btn-danger" onclick="emailSubmit()">
</form>';

    return $form;
}

function wpi_email_submit_scripts(){

        wp_enqueue_script('wpi-email-submit-js', get_stylesheet_directory_uri() . '/includes/email-submit-plugin/js/wpi-email-submit.js', array('jquery'), '1.13', true);


    if(is_checkout()){
        wp_enqueue_script('wpi-email-to-checkout', get_stylesheet_directory_uri() . '/includes/email-submit-plugin/js/wpi-email-to-checkout.js', array('jquery'), '1.0', true);
    }
}
add_action( 'wp_enqueue_scripts', 'wpi_email_submit_scripts' );

function wpi_email_redirect($email){
    $this_site_url = get_site_url();
    $url = $this_site_url . '/checkout?wpi_submitted_email=' . $email;
    wp_redirect($url);
}

function wpi_email_send($email_from) {

    $email_to = "support@wp-issues.com";
    $email_subject = "New E-mail Submission";

    $headers = 'From: ' . $email_from . "\r\n" . 'Reply-To: ' . $email_from . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    $message = '<html><body>';
    $message .= '<h2>New E-mail Submission</h2>';
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $message .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . $email_from . "</td></tr>";
    $message .= "</table>";
    $message .= '</body></html>';

    @mail($email_to, $email_subject, $message, $headers);
}
function wpi_add_email_submission($email){
    global $wpdb;
    $table = 'wp_wpi_email_entries';
    $data = array(
        'entry_key' => wpi_generate_guid(),
        'email'     => $email,
        'ip' => wpi_get_client_ip()
    );
    $wpdb->insert($table, $data);
}
function wpi_generate_guid($len = 5){
    $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $base = strlen($charset);
    $result = '';

    $now = explode(' ', microtime())[1];
    while ($now >= $base){
        $i = $now % $base;
        $result = $charset[$i] . $result;
        $now /= $base;
    }
    return substr($result, -5);
}
function wpi_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function wpi_add_mission_to_cart(){
    global $woocommerce;
    // $woocommerce->cart->empty_cart();
    $product_id = 29;
    $woocommerce->cart->add_to_cart( $product_id );
}
global $wpi_email_entry_version;
$wpi_email_entry_version = '1.0';
function wpi_email_entires_table_install(){
     global $wpdb;
     global $wpi_email_entry_version;
    $sql = "CREATE TABLE wp_wpi_email_entries ( id INT NOT NULL AUTO_INCREMENT , entry_key VARCHAR(255) NOT NULL , email VARCHAR(255) NOT NULL , creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , ip VARCHAR(255) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

    $wpdb->query($sql);
    update_option( "wpi_email_entry_version", $wpi_email_entry_version );
}
function wpi_email_entry_db_check(){
    global $wpi_email_entry_version;;
    $installed_ver = get_option( 'wpi_email_entry_version');
    // wpi_email_entires_table_install();
    if ( $installed_ver != $wpi_email_entry_version ) {
        wpi_email_entires_table_install();
    }
}
add_action('init', 'wpi_email_entry_db_check');
function wpi_clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
}

add_action( 'admin_menu', 'wpi_email_capture');

function wpi_email_capture() {
    add_menu_page('Email Capture', 'Email Capture', 'manage_options', 'email-submit', 'wpi_email_capture_options', 'dashicons-email-alt', 5);
}
function wpi_enqueue_email_scripts(){
    if($_SERVER['QUERY_STRING'] === 'page=email-submit') {
        wp_enqueue_script('admin-bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', TRUE);
        wp_enqueue_style('admin-bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
    }
}
add_action('admin_enqueue_scripts', 'wpi_enqueue_email_scripts');
function wpi_email_capture_options() {
    global $wpdb;
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    $entries = $wpdb->get_results('SELECT * FROM wp_wpi_email_entries');
    $query = $_SERVER['QUERY_STRING'];
    // p($query);
    $output = '';
    $output .= '<div class="row"><div class="col-lg-12">';
    $output .= '<h2>E-mail Submissions</h2>';
    $output .= '<table class="table wp-list-table widefat fixed striped pages">';
        $output .= '<thead>';
            $output .= '<tr>';
                $output .= '<th>ID</th>';
                $output .= '<th>Entry Key</th>';
                $output .= '<th>E-mail</th>';
                $output .= '<th>Creation Date</th>';
                $output .= '<th>IP Address</th>';
            $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
            foreach($entries as $entry){
                $output .= '<tr>';
                    $output .= '<td>'.$entry->id.'</td>';
                    $output .= '<td>'.$entry->entry_key.'</td>';
                    $output .= '<td>'.$entry->email.'</td>';
                    $output .= '<td>'.$entry->creation_date.'</td>';
                    $output .= '<td>'.$entry->ip.'</td>';
                $output .= '<tr>';
            }
        $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div></div>';


    echo $output;
}