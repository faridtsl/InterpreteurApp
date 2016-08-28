$(document).ready(function() {

    table = $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "processing": true,
        "serverSide": true,
        "ajax": "/facture/archive/query",
        "columns": [
            {data: 'id', name: 'id', visible:false},
            {data: 'nom', name: 'nom',  searchable: false, orderable:false},
            {data: 'date_envoi_mail', name: 'date_envoi_mail'},
            {data: 'pay', name: 'pay', searchable: false, orderable:false},
            {data: 'total', name: 'total', searchable: false, orderable:false},
            {data: 'butts', name: 'butts' ,orderable: false, searchable: false},
            {data: 'fact', name: 'fact' ,orderable: false, searchable: false}
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


});/**
 * Created by root on 8/10/16.
 */
