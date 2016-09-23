<?php
/**
 * Adds a meta box to the post editing screen
 */
function wpi_guarantee_meta() {
    add_meta_box( 'wpi_meta', __( 'Image', WPISSUES_THEME_NAME ), 'wpi_meta_guarantee_callback', 'page' );
}
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
$pgname = get_the_title($post_id);

if($pgname == 'Our Guarantee'){
    add_action( 'add_meta_boxes', 'wpi_guarantee_meta' );
    add_action( 'admin_enqueue_scripts', 'wpi_homepage_image_enqueue' );
}

function wpi_meta_guarantee_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'wpi_guarantee_nonce' );
    $wpi_guarantee_stored_meta = get_post_meta( $post->ID );
    ?>
    <div class="wpi_admin_column_1">
        <label><?php _e( 'Image Upload', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <input type="text" name="wpi_works_image_2" id="wpi_works_image_2" value="<?php if (isset( $wpi_guarantee_stored_meta["wpi_works_image_2"] ) ) echo $wpi_guarantee_stored_meta["wpi_works_image_2"][0]; ?>" />
        </p>
        <p>
            <input type="button" id="wpi_image_button_2" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
        </p>
</div>
<?php
}
function wpi_guarantee_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wpi_guarantee_nonce'] ) && wp_verify_nonce( $_POST['wpi_guarantee_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if (isset($_POST["wpi_works_image_2"])) {
        update_post_meta($post_id, "wpi_works_image_2", sanitize_text_field($_POST["wpi_works_image_2"]));
    }
}
add_action( 'save_post', 'wpi_guarantee_meta_save' );
