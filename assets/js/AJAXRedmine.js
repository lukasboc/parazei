$(document).ready(function () {
    $('#redmineHost').change(function () {

        var redmineHostId = $(this).val();

        // Empty Project and Ticket dropdown
        $('#redmineProject').find('option').not(':first').remove();
        $('#redmineTicket').find('option').not(':first').remove();
        $('#redmineActivity').find('option').not(':first').remove();
        resetRedmineProject();
        resetRedmineActivity();
        resetRedmineTicket();
        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileRedmine.php',
            type: 'post',
            data: {request: 'redmineProjects', redmineHostId: redmineHostId},
            dataType: 'json',
            success: function (response) {

                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];

                    $("#redmineProject").append("<option value='" + id + "'>" + name + "</option>");

                }
                resetRedmineProject();
                resetRedmineActivity();
                resetRedmineTicket();
            }
        });

        //Aktivitäten fetchen
        $.ajax({
            url: '../scripts/ajaxfileRedmine.php',
            type: 'post',
            data: {request: 'redmineActivities', redmineHostId: redmineHostId},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];

                    $("#redmineActivity").append("<option value='" + id + "'>" + name + "</option>");
                }
                resetRedmineActivity();
            }
        });
    });

    // Tickets fetchen
    $('#redmineProject').change(function () {
        var projectId = $(this).val();
        var redmineHostId = $('#redmineHost').val();

        // Empty Ticket dropdown
        $('#redmineTicket').find('option').not(':first').remove();
        resetRedmineTicket();
        resetRedmineActivity();
        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileRedmine.php',
            type: 'post',
            data: {request: 'redmineTickets', projectId: projectId, redmineHostId: redmineHostId},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var subject = response[i]['subject'];
                    var author = response[i]['author'];

                    $("#redmineTicket").append("<option value='" + id + "'>" + id + ": " + subject + " (" + author + ")</option>");
                }
                resetRedmineTicket();
            }
        });
    });
});

function resetRedmineProject() {
    $('#redmineProject').selectpicker('val', 'null');
    $('#redmineProject').selectpicker('refresh');
}

function resetRedmineTicket() {
    $('#redmineTicket').selectpicker('val', 'null');
    $('#redmineTicket').selectpicker('refresh');
}

function resetRedmineActivity() {
    $('#redmineActivity').selectpicker('val', 'null');
    $('#redmineActivity').selectpicker('refresh');
}