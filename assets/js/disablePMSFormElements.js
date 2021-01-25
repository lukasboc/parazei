/* initial states */
document.getElementById('troiPrefix')
    .setAttribute('disabled', 'disabled');
$('select').prop('disabled', true);
$('#globalProjectsSelect').prop('disabled', false);
$('select').selectpicker('refresh');

/* Enable Elements if PMS is Saved For Global Project */
$(document).ready(function () {
    if ($("#troiProjectId").filter(function () {
        return $(this).val();
    }).length > 0) {
        $('.troiSelect').prop('disabled', false);
        $('.troiSelect').selectpicker('refresh');
        document.getElementById('troiPrefix')
            .removeAttribute('disabled');
        document.getElementById('troiOptions')
            .classList.add('selectedPMSOption');
    } else {
        //todo remove btn class
        $('.troiSelect').prop('disabled', true);
        $('.troiSelect').selectpicker('refresh');
        document.getElementById('troiPrefix')
            .setAttribute('disabled', 'disabled');
        document.getElementById('troiOptions')
            .classList.remove('selectedPMSOption');
    }
});

$(document).ready(function () {
    if ($("#jiraProjectId").filter(function () {
        return $(this).val();
    }).length > 0) {
        $('.jiraSelect').prop('disabled', false);
        $('.jiraSelect').selectpicker('refresh');
        document.getElementById('jiraOptions')
            .classList.add('selectedPMSOption');

    } else {
        $('.jiraSelect').prop('disabled', true);
        $('.jiraSelect').selectpicker('refresh');
        document.getElementById('jiraOptions')
            .classList.remove('selectedPMSOption');
    }
});

$(document).ready(function () {
    if ($("#redmineProjectId").filter(function () {
        return $(this).val();
    }).length > 0) {
        $('.redmineSelect').prop('disabled', false);
        $('.redmineSelect').selectpicker('refresh');
        document.getElementById('redmineOptions')
            .classList.add('selectedPMSOption');
    } else {
        $('.redmineSelect').prop('disabled', true);
        $('.redmineSelect').selectpicker('refresh');
        document.getElementById('redmineOptions')
            .classList.remove('selectedPMSOption');
    }

});

/* Troi disable/enable elements */
$("#troiSwitch").click(function () {
    if (this.checked) {
        $('.troiSelect').prop('disabled', false);
        $('.troiSelect').selectpicker('refresh');
        document.getElementById('troiPrefix')
            .removeAttribute('disabled');
        document.getElementById('troiOptions')
            .classList.add('selectedPMSOption');
    }
    else {
        $('.troiSelect').prop('disabled', true);
        $('.troiSelect').selectpicker('refresh');
        document.getElementById('troiPrefix')
            .setAttribute('disabled', 'disabled');
        document.getElementById('troiOptions')
            .classList.remove('selectedPMSOption');
        $('#troiBillingPosition').selectpicker('setStyle', 'btn-info', 'remove');
        $('#troiBillingPosition').selectpicker('setStyle', 'border', 'add');
        $('#troiBillingPosition').selectpicker('refresh');
    }
});

/* Jira disable/enable elements */
$("#jiraSwitch").click(function () {
    if (this.checked) {
        $('.jiraSelect').prop('disabled', false);
        $('.jiraSelect').selectpicker('refresh');
        document.getElementById('jiraOptions')
            .classList.add('selectedPMSOption');

    }
    else {
        $('.jiraSelect').prop('disabled', true);
        $('.jiraSelect').selectpicker('refresh');
        document.getElementById('jiraOptions')
            .classList.remove('selectedPMSOption');
        $('#jiraTicket').selectpicker('setStyle', 'btn-info', 'remove');
        $('#jiraTicket').selectpicker('setStyle', 'border', 'add');
        $('#jiraTicket').selectpicker('refresh');
    }
});

/* Redmine disable/enable elements */
$("#redmineSwitch").click(function () {
    if (this.checked) {
        $('.redmineSelect').prop('disabled', false);
        $('.redmineSelect').selectpicker('refresh');
        document.getElementById('redmineOptions')
            .classList.add('selectedPMSOption');
    }
    else {
        $('.redmineSelect').prop('disabled', true);
        $('.redmineSelect').selectpicker('refresh');
        document.getElementById('redmineOptions')
            .classList.remove('selectedPMSOption');
        $('#redmineTicket').selectpicker('setStyle', 'btn-info', 'remove');
        $('#redmineTicket').selectpicker('setStyle', 'border', 'add');
        $('#redmineTicket').selectpicker('refresh');
    }

});