$(document).ready(function () {
    $('#jiraHost').change(function () {

        var jiraHostId = $(this).val();

        // Empty Project and Ticket dropdown
        $('#jiraProject').find('option').not(':first').remove();
        $('#jiraTicket').find('option').not(':first').remove();
        resetJiraProject();
        resetJiraTicket();

        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileJira.php',
            type: 'post',
            data: {request: 'jiraProjects', jiraHostId: jiraHostId},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];

                    $("#jiraProject").append("<option value='" + id + "'>" + name + "</option>");

                }
                resetJiraProject();
                resetJiraTicket();
            }
        });

    });

        // State
    $('#jiraProject').change(function () {
        var projectId = $(this).val();
        var jiraHostId = $('#jiraHost').val();

        // Empty Ticket dropdown
        $('#jiraTicket').find('option').not(':first').remove();

            // AJAX request
            $.ajax({
                url: '../scripts/ajaxfileJira.php',
                type: 'post',
                data: {request: 'jiraTickets', projectId: projectId, jiraHostId: jiraHostId},
                dataType: 'json',
                success: function(response){

                    var len = response.length;

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        var summary = response[i]['summary'];

                        $("#jiraTicket").append("<option value='" + id + "'>" + name + ": " + summary + "</option>");
                    }
                    $('#jiraProject').selectpicker('refresh');
                    resetJiraTicket();
                }
            });
    });
    $('#jiraTicket').change(function () {
        var jiraTicket = $("#jiraTicket option:selected").text();

        // write Ticketname into hidden field in case a prefix is wanted in troi
        var ticketName = jiraTicket.split(':')[0];
        $("#jiraTicketName").val(ticketName);

    });
});

function resetJiraTicket() {
    $('#jiraTicket').selectpicker('val', 'null');
    $('#jiraTicket').selectpicker('refresh');
}

function resetJiraProject() {
    $('#jiraProject').selectpicker('val', 'null');
    $('#jiraProject').selectpicker('refresh');
}