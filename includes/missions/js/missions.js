function contactEmail() {
    var frmgp = "<div class='form-group'></div>";
    var lbl = "<label for='contact_info' class='control-label'>E-mail Address</label>";
    var data = {
        user_email:      globals.userEmail,
        type_to_load: 'billing',
        action:       'woocommerce_get_customer_details',
        security:     globals.get_customer_details_nonce
    };
    var ipt = "<input type='email' name='contact_info' class='form-control' id='contact_info' value='"+data.user_email+"'>";

    jQuery("#contact_checks").append(frmgp);
    jQuery("#contact_checks .form-group").append(lbl, ipt);
}
function clearContactInfo() {
    jQuery("#contact_checks").empty();
}
function contactPhone() {
    var frmgp = "<div class='form-group'></div>";
    var lbl = "<label for='contact_info' class='control-label'>Phone Number</label>";
    var data = {
        user_phone:      globals.userPhone,
        type_to_load: 'billing',
        action:       'woocommerce_get_customer_details',
        security:     globals.get_customer_details_nonce
    };
    var ipt = "<input type='text' class='form-control' name='contact_info' id='contact_info' value='"+data.user_phone+"'>";
    jQuery("#contact_checks").append(frmgp);
    jQuery("#contact_checks .form-group").append(lbl, ipt);
}
function phoneFormat() {
    var phones = [{ "mask": "(###) ###-####"}, { "mask": "(###) ###-##############"}];
    jQuery("#contact_info").inputmask({
        mask: phones,
        greedy: false,
        definitions: { '#': { validator: "[0-9]", cardinality: 1}} });
}
function contactSkype() {
    var frmgp = "<div class='form-group'></div>";
    var lbl = "<label for='contact_info' class='control-label'>Skype Name</label>";
    var ipt = "<input type='text' class='form-control' name='contact_info' id='contact_info'>";
    jQuery("#contact_checks").append(frmgp);
    jQuery("#contact_checks .form-group").append(lbl, ipt);
}

jQuery("input.contact-check").on('change', function() {
    var chk = jQuery("input.contact-check");
    chk.not(this).prop('checked', false);
});
jQuery("input[value='email']").on('change', function() {
    if (jQuery(this).is(":checked")) {
        clearContactInfo();
        contactEmail();

    } else {
        clearContactInfo()
    }
});
jQuery("input[value='phone']").on('change', function() {
    if (jQuery(this).is(":checked")) {
        clearContactInfo();
        contactPhone();
        phoneFormat();
    } else {
        clearContactInfo()
    }
});
jQuery("input[value='skype']").on('change', function() {
    if (jQuery(this).is(":checked")) {
        clearContactInfo();
        contactSkype();
    } else {
        clearContactInfo()
    }
});

function addMission() {
    var user_id = jQuery("#user_id").val();
    var order_title = jQuery("#order_title").val();
    var user_role = jQuery("#user_role").val();
    var order_id = jQuery("#order_id").val();
    var contact_method;
    if(jQuery("input[value='phone']").is(":checked")){
        contact_method = "phone";
    } else if (jQuery("input[value='email']").is(":checked")){
        contact_method = "email";
    } else if (jQuery("input[value='skype']").is(":checked")){
        contact_method = "skype";
    }
    var contact_info = jQuery("#contact_info").val();
    var website_url = jQuery("#website_url").val();
    var admin_url = jQuery("#admin_url").val();
    var username = jQuery("#username").val();
    var admin_pw = jQuery("#admin_pw").val();
    var details = jQuery("#details").val();

    var data = {
        'action' : 'mission_submit',
        'type' : 'mission',
        'user_id' : user_id,
        'order_title' : order_title,
        'user_role' : user_role,
        'order_id' : order_id,
        'contact_method' : contact_method,
        'contact_info' : contact_info,
        'website_url' : website_url,
        'admin_url' : admin_url,
        'username' : username,
        'admin_pw' : admin_pw,
        'details' : details
    };

    jQuery.post(ajax_object.ajax_url, data, function(response){
        // alert(response);
        window.location.replace(response);
    });
}