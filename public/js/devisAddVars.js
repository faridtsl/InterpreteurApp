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
        "processing": true,
        "serverSide": true,
        "ajax": "/interpreteur/query2",
        "columns": [
            {data: 'id', name: 'interpreteurs.id' , visible:false},
            {data: 'nom', name: 'interpreteurs.nom'},
            {data: 'email', name: 'interpreteurs.email'},
            {data: 'prestation', name: 'interpreteurs.prestation'},
            {data: 'traductions', name: 'l1.content'},
            {data: 'adresse', name: 'adresses.adresse'},
            {data: 'image', name: 'interpreteurs.image', visible:false, searchable:false},
            {data: 'tel_portable', name: 'interpreteurs.tel_portable', visible:false, searchable:false},
            {data: 'adresse', name: 'adresses.adresse', visible:false, searchable:false},
            {data: 'nomprenom', name: 'prenom', visible:false, searchable:false},
            {data: 'butts', name: 'l2.content'}
        ]
    });

    table2 = $('#dataTables-example2').DataTable({
        "lengthMenu": [[10, 100, 200, 500, -1], [10, 100, 200, 500, "All"]],
        "scrollY": "500px",
        "scrollCollapse": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/interpreteur/query1",
        "columns": [
            {data: 'id', name: 'interpreteurs.id' , visible:false},
            {data: 'nom', name: 'interpreteurs.nom'},
            {data: 'email', name: 'interpreteurs.email'},
            {data: 'prestation', name: 'interpreteurs.prestation'},
            {data: 'traductions', name: 'l1.content'},
            {data: 'image', name: 'interpreteurs.image', visible:false, searchable:false},
            {data: 'tel_portable', name: 'interpreteurs.tel_portable', visible:false, searchable:false},
            {data: 'adresse', name: 'adresses.adresse', visible:false, searchable:false},
            {data: 'butts', name: 'l2.content'},
            {data: 'lat', name: 'adresses.lat' , visible:false ,orderable: false, searchable: false},
            {data: 'long', name: 'adresses.long' , visible:false ,orderable: false, searchable: false}
        ]
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
        var row = null;
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var data = this.data();
            if(data['id'] == id) {
                console.log(id);
                row = $.map(data, function (value, index) {
                    return [value];
                });
            }
        } );
        console.log(row);
        $('#interpreteur').val(row[0]);
        addInterpreteur(row[0],row[12],row[3],row[9],row[7],row[6]);
    });


    $(document.body).on('click','.selectInterpTab1',function (e) {
        var id = $(this).attr('data-id');
        var row = null;
        table2.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var data = this.data();
            if(data['id'] == id) row = $.map(data, function(value, index) {
                return [value];
            });
        } );
        $('#interpreteur').val(row[0]);
        console.log(row);
        addInterpreteur(row[0],row[14] ,row[3],row[9],row[7],row[6]);
    });

    t = $('#dynamicInterp').DataTable({
        "pageLength": 10,
    });
    counter = 0;
});