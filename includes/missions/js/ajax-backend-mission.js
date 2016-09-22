function adminQuestion() {
    var question = jQuery("#chat_input").val();
    var order_id = jQuery("#order_id").val();
    var post_id = jQuery("#post_id").val();
    var order_title = jQuery("#order_title").val();
    var user_id = jQuery("#user_id").val();
    var user_role = jQuery("#user_role").val();

    var data = {
        'action' : 'question_submit',
        'type' : 'ask_question',
        'order_id' : order_id,
        'post_id' : post_id,
        'order_title' : order_title,
        'user_id' : user_id,
        'user_role' : user_role,
        'question' : question
    };
    var oldscrollHeight = document.getElementById("chat_inner").scrollHeight;
    // console.log(oldscrollHeight);
    jQuery.post(ajaxurl, data, function(response){
        // alert(response);
        jQuery('#chat_content').html(response);
        var newscrollHeight = document.getElementById("chat_inner").scrollHeight;
        if(newscrollHeight > oldscrollHeight){
            jQuery("#chat_inner").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
        }
    });
}
function adminReloadQuestions(){
    var order_title = jQuery("#order_title").val();
    var post_id = jQuery("#post_id").val();


    var data = {
        'action' : 'reload_questions',
        'type' : 'reload',
        'order_title' : order_title,
        'post_id' : post_id
    };
    var oldscrollHeight = document.getElementById("chat_inner").scrollHeight;
    // console.log(oldscrollHeight);
    jQuery.post(ajaxurl, data, function(response){
        // alert(response);
        jQuery('#chat_content').html(response);
        var newscrollHeight = document.getElementById("chat_inner").scrollHeight;
        if(newscrollHeight > oldscrollHeight){
            jQuery("#chat_inner").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
        }
    });
}
jQuery(document).ready(function() {
    var newscrollHeight = document.getElementById("chat_inner").scrollHeight;
    jQuery("#chat_inner").animate({ scrollTop: newscrollHeight }, 'normal');
    setInterval (adminReloadQuestions, 10000);
});
