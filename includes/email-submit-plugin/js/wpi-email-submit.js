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
var create_mission = jQuery(".create_mission a");
create_mission.on("click", createMission);