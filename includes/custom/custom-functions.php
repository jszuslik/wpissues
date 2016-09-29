<?php
function wpi_get_att_id_from_image_url( $attachment_url = '' ) {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ( '' == $attachment_url )
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

    }

    return $attachment_id;
}

function wpi_switch_img_url_to_data_string($url, $image_size = '', $alt_tag = '', $is_inline = false, $width = '', $height = ''){
    $image_id = wpi_get_att_id_from_image_url($url);
    // p($image_id);
    $image_src = wp_get_attachment_image_src($image_id, $image_size);
    // p($image_src);
    $image_data_str = base64_encode(file_get_contents($image_src[0]));
    // p($image_data_str);
    $image_file_type = image_type_to_mime_type(exif_imagetype($image_src[0]));
    $image_src_string = 'data:';
    $image_src_string .= $image_file_type.';base64,';
    $image_src_string .= $image_data_str;
    $image_tag = '';

    if($is_inline){
        $image_tag .= $image_src_string;
    } else {
        $image_tag .= '<img src="';
        $image_tag .= $image_src_string;
        $image_tag .= '" alt="';
        $image_tag .= $alt_tag;
        $image_tag .= '" class="img-responsive" width="';
        if($image_src[1]){
            $width = $image_src[1];
        }
        $image_tag .= $width;
        $image_tag .= '" height="';
        if($image_src[2]){
            $height = $image_src[2];
        }
        $image_tag .= $height;
        $image_tag .= '">';
    }


    echo $image_tag;

}


