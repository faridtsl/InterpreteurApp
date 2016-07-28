$(function () {
    $('#date-end').bootstrapMaterialDatePicker
    ({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:ss'
    });
    $('#date-start').bootstrapMaterialDatePicker
    ({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:ss', shortTime : true
    }).on('change', function(e, date)
    {
        $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
    });
    $('#min-date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss', minDate : new Date() });
    $.material.init()
});