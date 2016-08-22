/**
 * Created by root on 8/4/16.
 */

var table;
var table2;
var map;
var mapDiv;


$(document).ready(function() {
    $("#draw").on("click", function() {
        drawFiltredRows();
    });

    table = $('#dataTables-example').DataTable({
        "pageLength": 10,
        "columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0,6,7,8,9] }]

    });

    table2 = $('#dataTables-example2').DataTable({
        "pageLength": 10,
        "columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0,5,6,7] }]

    });

    // Setup - add a text input to each footer cell
    $('#dataTables-example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );

    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    $('.success-alert').hide();


    $(document.body).on('click','.selectInterp',function (e) {
        var id = $(this).attr('data-id');
        console.log(id);
        var row = table2.rows(id).data();
        console.log(row[0]);
        $('#interpreteur').val(row[0][0]);
        addInterpreteur(row[0][0],row[0][1] + " " + row[0][2] ,row[0][3],row[0][5],row[0][6],row[0][7]);
    });


    $(document.body).on('click','.selectInterpTab1',function (e) {
        var id = $(this).attr('data-id');
        console.log(id);
        var row = table.rows(id).data();
        console.log(row[0]);
        $('#interpreteur').val(row[0][0]);
        addInterpreteur(row[0][0],row[0][9] ,row[0][2],row[0][6],row[0][7],row[0][8]);
    });

    t = $('#dynamicInterp').DataTable({
        "pageLength": 10,
    });
    counter = 0;
});