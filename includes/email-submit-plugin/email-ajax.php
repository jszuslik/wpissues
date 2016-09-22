<?php
add_action( 'wp_ajax_email_submit', 'wpi_user_submit_email' );
add_action( 'wp_ajax_nopriv_email_submit', 'wpi_user_submit_email' );

function wpi_user_submit_email(){
    if( $_POST['type'] == 'email_submit'){
        if (isset ($_POST['email'])) {
            $email_from =  $_POST['email'];
        }
        wpi_email_send($email_from);
        wpi_add_email_submission($email_from);
        wpi_add_mission_to_cart();

        echo url()."/checkout?wpi_submitted_email=".$email_from;
        wp_die();
    }
}