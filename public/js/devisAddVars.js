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
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                var ttInstance = TableTools.fnGetInstance("dataTables-example");
                var row = ttInstance.fnGetSelectedData();
                $('#interpreteur').val(row[0][0]);
                addInterpreteur(row[0][0],row[0][1] + " " + row[0][2] ,row[0][3],row[0][6],row[0][7],row[0][8]);
            },

            fnRowDeselected: function ( node ) {
                $('#interpreteur').val("");
                addInterpreteur(null,"Aucun","Aucun",'unknown.jpg','Aucun','Aucun');
            }
        },"columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0,6,7,8] }]

    });

    table2 = $('#dataTables-example2').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                var ttInstance = TableTools.fnGetInstance("dataTables-example2");
                var row = ttInstance.fnGetSelectedData();
                $('#interpreteur').val(row[0][0]);
                addInterpreteur(row[0][0],row[0][1] + " " + row[0][2] ,row[0][3],row[0][5],row[0][6],row[0][7]);
            },

            fnRowDeselected: function ( node ) {
                $('#interpreteur').val("");
                addInterpreteur(null,"Aucun","Aucun");
            }
        },"columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0,4,5,6,7] }]

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
});