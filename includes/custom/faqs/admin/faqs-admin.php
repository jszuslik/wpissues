<?php
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
$faqspgname = get_the_title($post_id);

function wpi_faqs_remove_editor(){
    remove_post_type_support('page', 'editor');
}

if($faqspgname == 'FAQs'){
    add_action( 'add_meta_boxes', 'dynamic_add_custom_box' );
    add_action('init', 'wpi_faqs_remove_editor');
}



/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_custom_box() {
    add_meta_box( 'dynamic_sectionid', __( 'Frequently Asked Questions', 'myplugin_textdomain' ), 'dynamic_inner_custom_box', 'page');
}

/* Prints the box content */
function dynamic_inner_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <style>
        input[name^="questions"],
        textarea[name^="questions"] {
            width: 100%;
        }
    </style>
    <div id="meta_inner">
    <?php

    //get the saved meta as an arry
    $questions = get_post_meta($post->ID,'questions',true);

    $c = 0;
    if ( count( $questions ) > 0 ) {
        foreach( $questions as $question ) {
            if ( isset( $question['title'] ) || isset( $question['question'] ) ) {
                printf( '<label>Question: </label><p><input type="text" name="questions[%1$s][question]" value="%2$s" /></p><label>Answer: </label><p><textarea rows="6" name="questions[%1$s][answer]">%3$s</textarea><span class="remove">%4$s</span></p><hr>', $c, $question['question'], $question['answer'], __( 'Remove Question' ) );
                $c = $c +1;
            }
        }
    }

    ?>
    <span id="here"></span>
    <span class="add"><?php _e('Add Question'); ?></span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
            var count = <?php echo $c; ?>;
            $(".add").click(function() {
                count = count + 1;

                $('#here').append('<label>Question: <p><input type="text" name="questions['+count+'][question]" value="" /></p><label>Answer: </label><p><textarea rows="6" name="questions['+count+'][answer]"></textarea><span class="remove">Remove Question</span></p><hr>' );
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php

}

/* When the post is saved, saves our custom data */
function dynamic_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $questions = $_POST['questions'];

    update_post_meta($post_id,'questions',$questions);
}