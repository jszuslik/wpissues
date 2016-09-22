<?php
add_action( 'admin_menu', 'wpi_add_admin_menu' );
add_action( 'admin_init', 'wpi_settings_init' );


function wpi_add_admin_menu(  ) {

    add_menu_page( 'WPIssues', 'WPIssues', 'manage_options', 'wpissues', 'wpi_options_page' );

}


function wpi_settings_init(  ) {

    register_setting( 'pluginPage', 'wpi_settings' );

    add_settings_section(
        'wpi_pluginPage_section',
        __( 'WP-Issues.com Contact Information', 'wpissues' ),
        'wpi_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'wpi_facebook_link',
        __( 'Facebook Link', 'wpissues' ),
        'wpi_facebook_link_render',
        'pluginPage',
        'wpi_pluginPage_section'
    );

    add_settings_field(
        'wpi_twitter_link',
        __( 'Twitter Link', 'wpissues' ),
        'wpi_twitter_link_render',
        'pluginPage',
        'wpi_pluginPage_section'
    );

    add_settings_field(
        'wpi_phone_number',
        __( 'Enter Phone Number', 'wpissues' ),
        'wpi_phone_number_render',
        'pluginPage',
        'wpi_pluginPage_section'
    );

    add_settings_field(
        'wpi_email_field',
        __( 'E-mail address', 'wpissues' ),
        'wpi_email_field_render',
        'pluginPage',
        'wpi_pluginPage_section'
    );


}


function wpi_facebook_link_render(  ) {

    $options = get_option( 'wpi_settings' );
    ?>
    <input type='text' name='wpi_settings[wpi_facebook_link]' value='<?php echo $options['wpi_facebook_link']; ?>'>
    <?php

}


function wpi_twitter_link_render(  ) {

    $options = get_option( 'wpi_settings' );
    ?>
    <input type='text' name='wpi_settings[wpi_twitter_link]' value='<?php echo $options['wpi_twitter_link']; ?>'>
    <?php

}


function wpi_phone_number_render(  ) {

    $options = get_option( 'wpi_settings' );
    ?>
    <input type='text' name='wpi_settings[wpi_phone_number]' value='<?php echo $options['wpi_phone_number']; ?>'>
    <?php

}


function wpi_email_field_render(  ) {

    $options = get_option( 'wpi_settings' );
    ?>
    <input type='text' name='wpi_settings[wpi_email_field]' value='<?php echo $options['wpi_email_field']; ?>'>
    <?php

}


function wpi_settings_section_callback(  ) {

    echo __( 'Put contact info here', 'wpissues' );

}


function wpi_options_page(  ) {

    ?>
    <form action='options.php' method='post'>

        <h2>WP-Issues.com</h2>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}

?>