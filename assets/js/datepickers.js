    $(function () {
        $('#worklogDate').datetimepicker({
            format: 'DD.MM.YYYY'
        });
    });
    $(function () {
        $('#worklogDuration').datetimepicker({
            defaultDate: moment({
                hour: 0,
                minute: 0
            }),
            format: 'HH:mm',
            stepping: 15
        });
    });
