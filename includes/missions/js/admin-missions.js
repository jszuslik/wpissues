jQuery(document).ready(function($) {

    console.log(agents);

    var posts = $('.type-mission');

    for(var i = 0; i < posts.length; i++){
        var post = posts[i];

        var row = $(post).find('.wpi_status');
        var status = $(row).text();
        status = status.toLowerCase();
        $(post).addClass("wpi_" + status);

        var assigned = $(post).find('.wpi_assigned');
        var agent = $(assigned).text();
        agaent = agent.toLowerCase();
        $(post).addClass("agent_" + agent);

    }
    var list = $("#the-list");

    var completed = $('.wpi_closed').length;
    var processing = $('.wpi_open').length;

    var logged_in_agent = agents.username;
    var my_missions = $('.agent_'+logged_in_agent).length;

    var view_completed = $('#view_completed');
    view_completed.append(" (" + completed + ")");

    var view_processing = $('#view_processing');
    view_processing.append(" (" + processing + ")");

    var view_my_missions = $('#view_my_missions');
    view_my_missions.append(" (" + my_missions + ")");

    view_completed.on('click', function() {
        var current = $(".subsubsub li .current");
        current.removeClass('current');
        $(this).addClass('current');
        list.isotope({
            filter: '.wpi_closed'
        });
    });
    view_processing.on('click', function() {
        var current = $(".subsubsub li .current");
        current.removeClass('current');
        $(this).addClass('current');
        list.isotope({
            filter: '.wpi_open'
        });
    });
    view_my_missions.on('click', function() {
        var current = $(".subsubsub li .current");
        current.removeClass('current');
        $(this).addClass('current');
        list.isotope({
            filter: '.agent_' + logged_in_agent
        });
    });

});