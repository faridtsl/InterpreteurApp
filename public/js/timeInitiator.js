$(function () {

    $("#dateEventFin").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    });

    $("#dateEventDeb").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    }).on('change', function(e, date) {
        $('#dateEventFin').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $("#dateEnvoiFin").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    });

    $("#dateEnvoiDeb").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    }).on('change', function(e, date) {
        $('#dateEnvoiFin').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $("#dateCreateFin").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    });

    $("#dateCreateDeb").bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    }).on('change', function(e, date) {
        $('#dateCreateFin').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#date-end').bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', lang : 'fr'
    });
    $('#date-start').bootstrapMaterialDatePicker
    ({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm:00', shortTime : true, lang : 'fr'
    }).on('change', function(e, date)
    {
        $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
    });
    $('#min-date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:00', minDate : new Date() });
    $.material.init();
});