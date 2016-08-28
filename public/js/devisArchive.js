$(document).ready(function() {

    table = $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "processing": true,
        "serverSide": true,
        "ajax": "/devis/archive/query",
        "columns": [
            {data: 'etat_id', name: 'devis.etat_id', searchable: false, orderable:false},
            {data: 'total', name: 'total', searchable: false, orderable:false},
            {data: 'created_at', name: 'devis.created_at'},
            {data: 'updated_at', name: 'devis.updated_at'},
            {data: 'deleted_at', name: 'devis.deleted_at'},
            {data: 'restore', name: 'restore' ,orderable: false, searchable: false},
            {data: 'butts', name: 'butts' ,orderable: false, searchable: false}
        ]
    });

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'"  style="width: 100%;" />' );
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


});