<?php
add_action('add_meta_boxes',function(){
    add_meta_box('custom_order_option', 'Custom Order Option', 'custom_order_option_cb','shop_order');
});
function custom_order_option_cb($post){
    echo '<h3>Mission Information</h3>';
}