jQuery(document).ready( function($) {

    var queries = getUrlVars();

    // alert(queries.wpi_submitted_email);
    var billing_email = queries.wpi_submitted_email;

    if(billing_email != null){
        $('#billing_email').val(queries.wpi_submitted_email);
    }
    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
});
