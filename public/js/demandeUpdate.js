$(document).ready(function() {

    $('#dataTables-example').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                var ttInstance = TableTools.fnGetInstance("dataTables-example");
                var row = ttInstance.fnGetSelectedData();
                $('#client').val(row[0][0]);
                console.log(row[0][0]);
            },

            fnRowDeselected: function ( node ) {
                $('#client').val("");
            }
        },"columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0] }]

    });

    $('.editClass').hide();

    $('.editChamps').on('click',function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        parent.removeClass('col-lg-3');
        parent.removeClass('col-lg-6');
        var ed = parent.find('.editClass').show();
        parent.find('.displayClass').hide();
        parent = parent.parent();
        parent.find('.lab').removeClass('col-lg-6');
        parent.find('.lab').removeClass('col-lg-3');
        $(this).hide();
    });

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

});