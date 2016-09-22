function emailSubmit() {
    var email = jQuery("#email").val();
    data = {
        'action' : 'email_submit',
        'type' : 'email_submit',
        'email' : email
    };
    jQuery.post(ajax_object.ajax_url, data, function(response){
        //alert(response);
        window.location.replace(response);
    });

}
