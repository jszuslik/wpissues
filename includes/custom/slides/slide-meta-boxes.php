<?php

/**
 * Adds a meta box to the post editing screen
 */
function wpi_slide_meta() {
    add_meta_box( 'wpi_meta', __( 'Slide Details', WPISSUES_THEME_NAME ), 'wpi_meta_callback', 'wpi_slides' );
}
add_action( 'add_meta_boxes', 'wpi_slide_meta' );

/**
 * Outputs the content of the meta box
 */
function wpi_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'wpi_slide_nonce' );
    $wpi_slide_stored_meta = get_post_meta( $post->ID );
    ?>
<div class="my_meta_control">
    <label><?php _e( 'Content', WPISSUES_THEME_NAME ); ?></label>
    <p>
        <textarea name="wpi_slide_content" id="wpi_slide_content" rows="5"><?php if ( isset ( $wpi_slide_stored_meta['wpi_slide_content'] ) ) echo $wpi_slide_stored_meta['wpi_slide_content'][0]; ?></textarea>
    </p>
    <label for="wpi_slide_tagline"><?php _e( 'Tagline', WPISSUES_THEME_NAME )?></label>
    <p>
        <input type="text" name="wpi_slide_tagline" id="wpi_slide_tagline" value="<?php if ( isset ( $wpi_slide_stored_meta['wpi_slide_tagline'] ) ) echo $wpi_slide_stored_meta['wpi_slide_tagline'][0]; ?>" />
    </p>
    <label for="wpi_slide_image"><?php _e( 'Image Upload', WPISSUES_THEME_NAME )?></label>
    <p>
        <input type="text" name="wpi_slide_image" id="wpi_slide_image" value="<?php if ( isset ( $wpi_slide_stored_meta['wpi_slide_image'] ) ) echo $wpi_slide_stored_meta['wpi_slide_image'][0]; ?>" />
        <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
    </p>
</div>
<?php
}

/**
 * Saves the custom meta input
 */
function wpi_slide_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wpi_slide_nonce' ] ) && wp_verify_nonce( $_POST[ 'wpi_slide_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'wpi_slide_content' ] ) ) {
        update_post_meta( $post_id, 'wpi_slide_content', sanitize_text_field( $_POST[ 'wpi_slide_content' ] ) );
    }
    if( isset( $_POST[ 'wpi_slide_tagline' ] ) ) {
        update_post_meta( $post_id, 'wpi_slide_tagline', sanitize_text_field( $_POST[ 'wpi_slide_tagline' ] ) );
    }
    if( isset( $_POST[ 'wpi_slide_image' ] ) ) {
        update_post_meta( $post_id, 'wpi_slide_image', sanitize_text_field( $_POST[ 'wpi_slide_image' ] ) );
    }

}
add_action( 'save_post', 'wpi_slide_meta_save' );

/**
 * Adds the meta box stylesheet when appropriate
 */
function wpi_slide_admin_styles(){
    global $typenow;
    if( $typenow == 'wpi_slides' ) {
        wp_enqueue_style( 'wpi_slide_meta_box_styles', get_template_directory_uri() . '/includes/custom/slides/slide-meta.css' );
    }
}
add_action( 'admin_print_styles', 'wpi_slide_admin_styles' );

/**
 * Loads the image management javascript
 */
function wpi_slide_image_enqueue() {
    global $typenow;
    if( $typenow == 'wpi_slides' ) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', get_template_directory_uri() . '/includes/custom/slides/slide-meta.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', WPISSUES_THEME_NAME ),
                'button' => __( 'Use this image', WPISSUES_THEME_NAME ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'wpi_slide_image_enqueue' );


?>