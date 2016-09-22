<?php
/**
 * Adds a meta box to the post editing screen
 */
function wpi_home_meta() {
    add_meta_box( 'wpi_meta', __( 'Funnel Area', WPISSUES_THEME_NAME ), 'wpi_meta_homepage_callback', 'page' );
}
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
$homepgname = get_the_title($post_id);

if($homepgname == 'Home'){
    add_action( 'add_meta_boxes', 'wpi_home_meta' );
    add_action( 'admin_enqueue_scripts', 'wpi_homepage_image_enqueue' );
}

/**
 *  Outputs the content of the meta box
 */
function wpi_meta_homepage_callback( $post ){
    wp_nonce_field( basename( __FILE__ ), 'wpi_homepage_nonce' );
    $wpi_homepage_stored_meta = get_post_meta( $post->ID );
    ?>
    <?php
    $post_args = array(
        'posts_per_page'   => -1,
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => 'product',
        'post_status' => 'publish'
    );
    $wpi_posts = get_posts($post_args);

    $page_args = array(
        'posts_per_page'   => -1,
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $wpi_pages = get_pages($page_args);

    $wpi_all_links = array_merge($wpi_posts, $wpi_pages);
    ?>
    <div class="wpi_admin_column_1">
        <label><?php _e( 'Funnel Area Header', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <input type="text" name="wpi_works_title" id="wpi_works_title" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_works_title"] ) ) echo $wpi_homepage_stored_meta["wpi_works_title"][0]; ?>" />
        </p>
    </div>
    <div class="wpi_admin_column_3">
        <h2>Column 1</h2>
        <label><?php _e( 'Column 1 Image', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <input type="text" name="wpi_works_image_1" id="wpi_works_image_1" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_works_image_1"] ) ) echo $wpi_homepage_stored_meta["wpi_works_image_1"][0]; ?>" />
        </p>
        <p>
            <input type="button" id="wpi_image_button_1" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
        </p>
        <label><?php _e( 'Column 1 Content', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <textarea name="wpi_works_content_1" id="wpi_works_content_1" rows="5"><?php if ( isset ( $wpi_homepage_stored_meta["wpi_works_content_1"] ) ) echo $wpi_homepage_stored_meta["wpi_works_content_1"][0]; ?></textarea>
        </p>
        <label><?php _e( 'Link to Mission Page', WPISSUES_THEME_NAME ); ?></label>
            <p>
                <select name="wpi_homepage_works_link" id="wpi_homepage_works_link">
                    <option value="none" disabled selected>Select A Page</option>
                    <?php foreach($wpi_all_links as $wpi_page){ ?>
                        <option value="<?php echo $wpi_page->ID; ?>" <?php if ( isset ( $wpi_homepage_stored_meta['wpi_homepage_works_link'] ) ) selected( $wpi_homepage_stored_meta['wpi_homepage_works_link'][0], $wpi_page->ID ); ?>><?php echo $wpi_page->post_title; ?></option>
                    <?php } ?>
                </select>
            </p>
    </div>
    <div class="wpi_admin_column_3">
        <h2>Column 2</h2>
        <label><?php _e( 'Column 2 Image', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <input type="text" name="wpi_works_image_2" id="wpi_works_image_2" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_works_image_2"] ) ) echo $wpi_homepage_stored_meta["wpi_works_image_2"][0]; ?>" />
        </p>
        <p>
            <input type="button" id="wpi_image_button_2" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
        </p>
        <label><?php _e( 'Column 2 Content', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <textarea name="wpi_works_content_2" id="wpi_works_content_2" rows="5"><?php if ( isset ( $wpi_homepage_stored_meta["wpi_works_content_2"] ) ) echo $wpi_homepage_stored_meta["wpi_works_content_2"][0]; ?></textarea>
        </p>
    </div>
    <div class="wpi_admin_column_3">
        <h2>Column 3</h2>
        <label><?php _e( 'Column 3 Image', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <input type="text" name="wpi_works_image_3" id="wpi_works_image_3" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_works_image_3"] ) ) echo $wpi_homepage_stored_meta["wpi_works_image_3"][0]; ?>" />
        </p>
        <p>
            <input type="button" id="wpi_image_button_3" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
        </p>
        <label><?php _e( 'Column 3 Content', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <textarea name="wpi_works_content_3" id="wpi_works_content_3" rows="5"><?php if ( isset ( $wpi_homepage_stored_meta["wpi_works_content_3"] ) ) echo $wpi_homepage_stored_meta["wpi_works_content_3"][0]; ?></textarea>
        </p>
    </div>
    <div class="wpi_admin_column_1">
        <h2>Section 2</h2>
        <label><?php _e( 'Section 2 Header', WPISSUES_THEME_NAME); ?></label>
        <p>
            <input type="text" name="wpi_section_2_header" id="wpi_section_2_header" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_section_2_header"] ) ) echo $wpi_homepage_stored_meta["wpi_section_2_header"][0]; ?>" />
        </p>
        <label><?php _e( 'Section 2 Image', WPISSUES_THEME_NAME); ?></label>
        <p>
            <input type="text" name="wpi_section_2_image" id="wpi_section_2_image" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_section_2_image"] ) ) echo $wpi_homepage_stored_meta["wpi_section_2_image"][0]; ?>" />
        </p>
        <p>
            <input type="button" id="wpi_section_2_image_upload" class="button" value="<?php _e( 'Choose or Upload an Image', WPISSUES_THEME_NAME )?>" />
        </p>
        <label><?php _e( 'Section 2 Content', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <textarea name="wpi_section_2_content" id="wpi_section_2_content" rows="5"><?php if ( isset ( $wpi_homepage_stored_meta["wpi_section_2_content"] ) ) echo $wpi_homepage_stored_meta["wpi_section_2_content"][0]; ?></textarea>
        </p>
    </div>
    <div class="wpi_admin_column_1">
        <h2>Call To Action</h2>
        <label><?php _e( 'Call To Action Message', WPISSUES_THEME_NAME); ?></label>
        <p>
            <input type="text" name="wpi_cta_message" id="wpi_cta_message" value="<?php if (isset( $wpi_homepage_stored_meta["wpi_cta_message"] ) ) echo $wpi_homepage_stored_meta["wpi_cta_message"][0]; ?>" />
        </p>
        <label><?php _e( 'Link to Mission Page', WPISSUES_THEME_NAME ); ?></label>
        <p>
            <select name="wpi_cta_link" id="wpi_cta_link">
                <option value="none" disabled selected>Select A Page</option>
                <?php foreach($wpi_all_links as $wpi_post){ ?>
                    <option value="<?php echo $wpi_post->ID; ?>" <?php if ( isset ( $wpi_homepage_stored_meta['wpi_cta_link'] ) ) selected( $wpi_homepage_stored_meta['wpi_cta_link'][0], $wpi_post->ID ); ?>><?php echo $wpi_post->post_title; ?></option>
                <?php } ?>
            </select>

    </div>
<?php
}

/**
 * Saves the custom meta input
 */
function wpi_homepage_meta_save( $post_id) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wpi_homepage_nonce' ] ) && wp_verify_nonce( $_POST[ 'wpi_homepage_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if (isset($_POST["wpi_works_title"])) {
        update_post_meta($post_id, "wpi_works_title", sanitize_text_field($_POST["wpi_works_title"]));
    }

    // Checks for input and sanitizes/saves if needed

    if ( isset( $_POST["wpi_works_image_1"])) {
        update_post_meta($post_id, "wpi_works_image_1", sanitize_text_field($_POST["wpi_works_image_1"]));
    }
    if (isset($_POST["wpi_works_image_2"])) {
        update_post_meta($post_id, "wpi_works_image_2", sanitize_text_field($_POST["wpi_works_image_2"]));
    }
    if (isset($_POST["wpi_works_image_3"])) {
        update_post_meta($post_id, "wpi_works_image_3", sanitize_text_field($_POST["wpi_works_image_3"]));
    }
    if (isset($_POST["wpi_works_content_1"])) {
        update_post_meta($post_id, "wpi_works_content_1", sanitize_text_field($_POST["wpi_works_content_1"]));
    }
    if (isset($_POST["wpi_works_content_2"])) {
        update_post_meta($post_id, "wpi_works_content_2", sanitize_text_field($_POST["wpi_works_content_2"]));
    }
    if (isset($_POST["wpi_works_content_3"])) {
        update_post_meta($post_id, "wpi_works_content_3", sanitize_text_field($_POST["wpi_works_content_3"]));
    }
    if( isset( $_POST[ 'wpi_homepage_works_link' ] ) ) {
        update_post_meta( $post_id, 'wpi_homepage_works_link', $_POST[ 'wpi_homepage_works_link' ] );
    }
    if (isset($_POST["wpi_section_2_header"])) {
        update_post_meta($post_id, "wpi_section_2_header", sanitize_text_field($_POST["wpi_section_2_header"]));
    }
    if (isset($_POST["wpi_section_2_image"])) {
        update_post_meta($post_id, "wpi_section_2_image", sanitize_text_field($_POST["wpi_section_2_image"]));
    }
    if (isset($_POST["wpi_section_2_content"])) {
        update_post_meta($post_id, "wpi_section_2_content", $_POST["wpi_section_2_content"]);
    }
    if (isset($_POST["wpi_cta_message"])) {
        update_post_meta($post_id, "wpi_cta_message", sanitize_text_field($_POST["wpi_cta_message"]));
    }
    if( isset( $_POST[ 'wpi_cta_link' ] ) ) {
        update_post_meta( $post_id, 'wpi_cta_link', $_POST[ 'wpi_cta_link' ] );
    }

}
add_action( 'save_post', 'wpi_homepage_meta_save' );

/**
 * Adds the meta box stylesheet when appropriate
 */
function wpi_homepage_admin_styles(){
    wp_enqueue_style( 'wpi_homepage_meta_box_styles', get_template_directory_uri() . '/includes/custom/homepage/homepage-meta.css' );

}
add_action( 'admin_print_styles', 'wpi_homepage_admin_styles' );

/**
 * Loads the image management javascript
 */
function wpi_homepage_image_enqueue(){
    wp_enqueue_media();

    // Registers and enqueues the required javascript.
    wp_register_script( 'home-meta-box-image', get_template_directory_uri() . '/includes/custom/homepage/homepage-meta.js', array( 'jquery' ) );
    wp_localize_script( 'home-meta-box-image', 'meta_image',
        array(
            'title' => __( 'Choose or Upload an Image', WPISSUES_THEME_NAME ),
            'button' => __( 'Use this image', WPISSUES_THEME_NAME ),
        )
    );
    wp_enqueue_script( 'home-meta-box-image' );
}