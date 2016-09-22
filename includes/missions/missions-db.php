<?php
global $wpi_mission_questions_db_version;
$wpi_mission_questions_db_version = '0.2';
function wpi_mission_question_table_install(){
    global $wpi_mission_questions_db_version;
    global $wpdb;

    $sql = "CREATE TABLE wp_wpi_mission_question_table ( id INT NOT NULL AUTO_INCREMENT , entry_key VARCHAR(255) NOT NULL , post_id VARCHAR(255) NOT NULL , order_id VARCHAR(255) NOT NULL , order_title VARCHAR(255) NOT NULL , user_id VARCHAR(255) NOT NULL , user_role VARCHAR(255) NOT NULL , message TEXT NOT NULL , creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , ip VARCHAR(255) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

    $wpdb->query($sql);

    update_option('wpi_mission_questions_db_version', $wpi_mission_questions_db_version);
}

function wpi_mission_question_db_check(){
    global $wpi_mission_questions_db_version;
     $installed_ver = get_option( 'wpi_mission_questions_db_version');
    // wpi_mission_question_table_install();
    if ( $installed_ver != $wpi_mission_questions_db_version ) {
        wpi_mission_question_table_install();
    }
}
add_action('init', 'wpi_mission_question_db_check');
