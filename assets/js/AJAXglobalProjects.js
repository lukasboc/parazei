$(document).ready(function () {
    $('#globalProjectsSelect').change(function () {

        var globalProjectsSelectId = $(this).val();

        // Empty PMS dropdowns and Disable PMS Optiona
        $('#redmineProject').find('option').not(':first').remove();
        $('#redmineTicket').find('option').not(':first').remove();
        $('#redmineActivity').find('option').not(':first').remove();
        $('#troiClient').find('option').not(':first').remove();
        $('#troiCustomer').find('option').not(':first').remove();
        $('#troiProject').find('option').not(':first').remove();
        $('#troiBillingPosition').find('option').not(':first').remove();
        $('#jiraProject').find('option').not(':first').remove();
        $('#jiraTicket').find('option').not(':first').remove();

        $('#redmineHost').selectpicker('val', 'null');
        $('#jiraHost').selectpicker('val', 'null');
        $('#troiHost').selectpicker('val', 'null');
        $('#redmineHost').selectpicker('refresh');
        $('#jiraHost').selectpicker('refresh');
        $('#troiHost').selectpicker('refresh');

        $('#troiSwitch').prop("checked", false);
        $('#jiraSwitch').prop("checked", false);
        $('#redmineSwitch').prop("checked", false);

        $('.redmineSelect').prop('disabled', true);
        $('.redmineSelect').selectpicker('refresh');

        $('.jiraSelect').prop('disabled', true);
        $('.jiraSelect').selectpicker('refresh');

        $('.troiSelect').prop('disabled', true);
        $('.troiSelect').selectpicker('refresh');
        $('#troiPrefix').prop("disabled", true);

        $('#troiOptions').removeClass('selectedPMSOption');
        $('#jiraOptions').removeClass('selectedPMSOption');
        $('#redmineOptions').removeClass('selectedPMSOption');

        $('#jiraTicket').selectpicker('setStyle', 'btn-info', 'remove');
        $('#jiraTicket').selectpicker('setStyle', 'border', 'add');
        $('#redmineTicket').selectpicker('setStyle', 'btn-info', 'remove');
        $('#redmineTicket').selectpicker('setStyle', 'border', 'add');
        $('#troiBillingPosition').selectpicker('setStyle', 'btn-info', 'remove');
        $('#troiBillingPosition').selectpicker('setStyle', 'border', 'add');
        $('#troiBillingPosition').selectpicker('refresh');
        $('#jiraTicket').selectpicker('refresh');
        $('#redmineTicket').selectpicker('refresh');

        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileGlobalProjects.php',
            type: 'post',
            data: {request: 'globalProjects', globalProjectsSelectId: globalProjectsSelectId},
            dataType: 'json',
            success: function (response) {

                var jiraProject = response['jira'];
                var redmineProject = response['redmine'];
                var troiProject = response['troi'];

                if (jiraProject != null) {
                    $('#jiraOptions').addClass('selectedPMSOption');
                    $('.jiraSelect').prop('disabled', false);
                    $('.jiraSelect').selectpicker('refresh');
                    $('#jiraSwitch').prop("checked", true);
                    var jiraConnectionID = jiraProject['connectionId'];
                    var jiraProjectID = jiraProject['projectId'];

                    $('#jiraHost').selectpicker('val', jiraConnectionID);
                    $('#jiraHost').selectpicker('refresh');

                    $("#jiraHost option[value='" + jiraConnectionID + "']").attr('selected', true);
                    $.ajax({
                        url: '../scripts/ajaxfileJira.php',
                        type: 'post',
                        data: {request: 'jiraProjects', jiraHostId: jiraConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                if (id === jiraProjectID) {
                                    $("#jiraProject").append("<option selected value='" + id + "'>" + name + "</option>");
                                } else {
                                    $("#jiraProject").append("<option value='" + id + "'>" + name + "</option>");
                                }
                            }
                            $('#jiraProject').selectpicker('refresh');
                        }
                    });
                    $('#jiraTicket').find('option').not(':first').remove();
                    $.ajax({
                        url: '../scripts/ajaxfileJira.php',
                        type: 'post',
                        data: {request: 'jiraTickets', projectId: jiraProjectID, jiraHostId: jiraConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                var summary = response[i]['summary'];

                                $("#jiraTicket").append("<option value='" + id + "'>" + name + ": " + summary + "</option>");
                            }
                            $('#jiraTicket').selectpicker('setStyle', 'btn-info', 'add');
                            $('#jiraTicket').selectpicker('setStyle', 'border', 'remove');
                            $('#jiraTicket').selectpicker('val', 'null');
                            $('#jiraTicket').selectpicker('refresh');
                        }
                    });
                }
                if (redmineProject != null) {
                    $('#redmineOptions').addClass('selectedPMSOption');
                    $('.redmineSelect').prop('disabled', false);
                    $('.redmineSelect').selectpicker('refresh');
                    $('#redmineSwitch').prop("checked", true);
                    var redmineConnectionID = redmineProject['connectionId'];
                    var redmineProjectID = redmineProject['projectId'];
                    var redmineActivityID = redmineProject['activityId'];

                    $('#redmineHost').selectpicker('val', redmineConnectionID);
                    $('#redmineHost').selectpicker('refresh');

                    $("#redmineHost option[value='" + redmineConnectionID + "']").attr('selected', true);
                    $.ajax({
                        url: '../scripts/ajaxfileRedmine.php',
                        type: 'post',
                        data: {request: 'redmineProjects', redmineHostId: redmineConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var rId = response[i]['id'];
                                var rName = response[i]['name'];
                                if (rId == redmineProjectID) {
                                    $("#redmineProject").append("<option selected value='" + rId + "'>" + rName + "</option>");
                                } else {
                                    $("#redmineProject").append("<option value='" + rId + "'>" + rName + "</option>");
                                }
                            }
                            $('#redmineProject').selectpicker('refresh');
                        }
                    });
                    $('#redmineTicket').find('option').not(':first').remove();
                    // AJAX request
                    $.ajax({
                        url: '../scripts/ajaxfileRedmine.php',
                        type: 'post',
                        data: {
                            request: 'redmineTickets',
                            projectId: redmineProjectID,
                            redmineHostId: redmineConnectionID
                        },
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var subject = response[i]['subject'];
                                var author = response[i]['author'];

                                $("#redmineTicket").append("<option value='" + id + "'>" + id + ": " + subject + " (" + author + ")</option>");
                            }
                            $('#redmineTicket').selectpicker('setStyle', 'btn-info', 'add');
                            $('#redmineTicket').selectpicker('setStyle', 'border', 'remove');
                            $('#redmineTicket').selectpicker('val', 'null');
                            $('#redmineTicket').selectpicker('refresh');
                        }
                    });
                    $.ajax({
                        url: '../scripts/ajaxfileRedmine.php',
                        type: 'post',
                        data: {request: 'redmineActivities', redmineHostId: redmineConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var rId = response[i]['id'];
                                var rName = response[i]['name'];

                                if (rId == redmineActivityID) {
                                    $("#redmineActivity").append("<option selected value='" + rId + "'>" + rName + "</option>");
                                } else {
                                    $("#redmineActivity").append("<option value='" + rId + "'>" + rName + "</option>");
                                }
                            }
                            $('#redmineActivity').selectpicker('refresh');
                        }
                    });
                }
                if (troiProject != null) {
                    $('#troiOptions').addClass('selectedPMSOption');
                    $('.troiSelect').prop('disabled', false);
                    $('.troiSelect').selectpicker('refresh');
                    $('#troiPrefix').prop("disabled", false);
                    $('#troiSwitch').prop("checked", true);
                    var troiConnectionID = troiProject['connectionId'];
                    var troiClientID = troiProject['clientId'];
                    var troiCustomerID = troiProject['customerId'];
                    var troiProjectID = troiProject['projectId'];

                    $('#troiHost').selectpicker('val', troiConnectionID);
                    $('#troiHost').selectpicker('refresh');

                    $("#troiHost option[value='" + troiConnectionID + "']").attr('selected', true);
                    // Empty Dropdowns before appending
                    $('#troiClient').find('option').not(':first').remove();
                    $.ajax({
                        url: '../scripts/ajaxfileTroi.php',
                        type: 'post',
                        data: {request: 'troiClients', troiHostId: troiConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                if (id == troiClientID) {
                                    $("#troiClient").append("<option selected value='" + id + "'>" + name + "</option>");
                                } else {
                                    $("#troiClient").append("<option value='" + id + "'>" + name + "</option>");
                                }
                            }
                            $('#troiClient').selectpicker('refresh');
                        }
                    });
                    // Empty Dropdowns before appending
                    $('#troiCustomer').find('option').not(':first').remove();
                    $('#troiProject').find('option').not(':first').remove();
                    $('#troiBillingPosition').find('option').not(':first').remove();
                    $.ajax({
                        url: '../scripts/ajaxfileTroi.php',
                        type: 'post',
                        data: {request: 'troiCustomers', troiClient: troiClientID, troiHostId: troiConnectionID},
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                if (id == troiCustomerID) {
                                    $("#troiCustomer").append("<option selected value='" + id + "'>" + name + "</option>");
                                } else {
                                    $("#troiCustomer").append("<option value='" + id + "'>" + name + "</option>");
                                }
                            }
                            $('#troiCustomer').selectpicker('refresh');

                        }
                    });
                    // Empty Dropdowns before appending
                    $('#troiProject').find('option').not(':first').remove();
                    $('#troiBillingPosition').find('option').not(':first').remove();
                    $.ajax({
                        url: '../scripts/ajaxfileTroi.php',
                        type: 'post',
                        data: {
                            request: 'troiProjects',
                            troiClient: troiClientID,
                            troiHostId: troiConnectionID,
                            troiCustomer: troiCustomerID
                        },
                        dataType: 'json',
                        success: function (response) {
                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                if (id == troiProjectID) {
                                    $("#troiProject").append("<option selected value='" + id + "'>" + name + "</option>");
                                } else {
                                    $("#troiProject").append("<option value='" + id + "'>" + name + "</option>");
                                }
                            }
                            $('#troiProject').selectpicker('refresh');
                        }
                    });
                    // Empty troiBillingPosition dropdown
                    $('#troiBillingPosition').find('option').not(':first').remove();
                    // AJAX request
                    $.ajax({
                        url: '../scripts/ajaxfileTroi.php',
                        type: 'post',
                        data: {
                            request: 'calculationPositionsByProjectId',
                            troiClient: troiClientID,
                            troiHostId: troiConnectionID,
                            troiProject: troiProjectID
                        },
                        dataType: 'json',
                        success: function (response) {

                            var len = response.length;

                            for (var i = 0; i < len; i++) {
                                var id = response[i]['id'];
                                var name = response[i]['name'];

                                $("#troiBillingPosition").append("<option value='" + id + "'>K" + id + ": " + name + "</option>");
                            }
                            $('#troiBillingPosition').selectpicker('setStyle', 'btn-info', 'add');
                            $('#troiBillingPosition').selectpicker('setStyle', 'border', 'remove');
                            $('#troiBillingPosition').selectpicker('val', 'null');
                            $('#troiBillingPosition').selectpicker('refresh');
                        }
                    });
                }
            }
        });
    });
});