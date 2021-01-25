$(document).ready(function () {

    // Fetch Clients By given HostID
    $('#troiHost').change(function () {

        var troiHostId = $(this).val();

        // Empty Client and Customer dropdown
        $('#troiClient').find('option').not(':first').remove();
        $('#troiCustomer').find('option').not(':first').remove();
        $('#troiProject').find('option').not(':first').remove();
        $('#troiBillingPosition').find('option').not(':first').remove();
        resetTroiClient();
        resetTroiCustomer();
        resetTroiProject();
        resetTroiBillingPosition()
        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileTroi.php',
            type: 'post',
            data: {request: 'troiClients', troiHostId: troiHostId},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#troiClient").append("<option value='" + id + "'>" + name + "</option>");
                }
                $('#troiHost').selectpicker('refresh');
                resetTroiClient();
                resetTroiCustomer();
                resetTroiProject();
                resetTroiBillingPosition();
            }
        });

    });

    // Fetch Customers By given HostID and ClientID AND Fetch Calculation Positions by ClientID
    $('#troiClient').change(function () {
        var troiHostId = $('#troiHost').val();
        var troiClient = $(this).val();

        // Empty Customer dropdown
        $('#troiCustomer').find('option').not(':first').remove();
        $('#troiProject').find('option').not(':first').remove();
        $('#troiBillingPosition').find('option').not(':first').remove();
        resetTroiCustomer();
        resetTroiProject();
        resetTroiBillingPosition();

        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileTroi.php',
            type: 'post',
            data: {request: 'troiCustomers', troiClient: troiClient, troiHostId: troiHostId},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#troiCustomer").append("<option value='" + id + "'>" + name + "</option>");
                }
                $('#troiClient').selectpicker('refresh');
                resetTroiCustomer();
                resetTroiProject();
                resetTroiBillingPosition();
            }
        });
        $.ajax({
            url: '../scripts/ajaxfileTroi.php',
            type: 'post',
            data: {request: 'calculationPositionsByClientId', troiClient: troiClient, troiHostId: troiHostId},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#troiBillingPosition").append("<option value='" + id + "'>K" + id + ": " + name + "</option>");
                }
                $('#troiBillingPosition').selectpicker('refresh');
            }
        });
    });

    // Fetch Projects by given HostID, ClientID and CustomerID
    $('#troiCustomer').change(function () {
        var troiHostId = $('#troiHost').val();
        var troiClient = $('#troiClient').val();
        var troiCustomer = $(this).val();

        // Empty Project dropdown
        $('#troiProject').find('option').not(':first').remove();
        $('#troiBillingPosition').find('option').not(':first').remove();
        resetTroiProject();
        resetTroiBillingPosition();

        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileTroi.php',
            type: 'post',
            data: {request: 'troiProjects', troiClient: troiClient, troiHostId: troiHostId, troiCustomer: troiCustomer},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#troiProject").append("<option value='" + id + "'>" + name + "</option>");
                }
                $('#troiProject').selectpicker('refresh');
                resetTroiProject();
                resetTroiBillingPosition();
            }
        });
    });
    // Fetch Calculation Positions by given HostID, ClientID and ProjectId
    $('#troiProject').change(function () {
        var troiHostId = $('#troiHost').val();
        var troiClient = $('#troiClient').val();
        var troiProject = $(this).val();
        // Empty Project dropdown
        $('#troiBillingPosition').find('option').not(':first').remove();
        resetTroiBillingPosition();
        // AJAX request
        $.ajax({
            url: '../scripts/ajaxfileTroi.php',
            type: 'post',
            data: {
                request: 'calculationPositionsByProjectId',
                troiClient: troiClient,
                troiHostId: troiHostId,
                troiProject: troiProject
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#troiBillingPosition").append("<option value='" + id + "'>K" + id + ": " + name + "</option>");
                }
                resetTroiBillingPosition();
            }
        });
    });
});

function resetTroiClient() {
    $('#troiClient').selectpicker('val', 'null');
    $('#troiClient').selectpicker('refresh');
}

function resetTroiBillingPosition() {
    $('#troiBillingPosition').selectpicker('val', 'null');
    $('#troiBillingPosition').selectpicker('refresh');
}

function resetTroiProject() {
    $('#troiProject').selectpicker('val', 'null');
    $('#troiProject').selectpicker('refresh');
}

function resetTroiCustomer() {
    $('#troiCustomer').selectpicker('val', 'null');
    $('#troiCustomer').selectpicker('refresh');
}