function emailSubmit() {
    var email = jQuery("#email").val();
    if(validateEmail(email)){
        data = {
            'action' : 'email_submit',
            'type' : 'email_submit',
            'email' : email
        };
        jQuery.post(ajax_object.ajax_url, data, function(response){
            //alert(response);
            window.location.replace(response);
        });
    } else {
        data = {
            'action' : 'email_submit',
            'type' : 'email_fail'
        };
        jQuery.post(ajax_object.ajax_url, data, function(response){
            alert(response);
        });
    }
}
function createMission() {
    data = {
        'action' : 'email_submit',
        'type' : 'create_mission'
    }
    jQuery.post(ajax_object.ajax_url, data, function(response){
        // alert(response);
        window.location.replace(response);
    });
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var create_mission = jQuery(".create_mission a");
create_mission.on("click", createMission);

var submit_mission = jQuery("#mission-cta");
submit_mission.on("click", createMission);