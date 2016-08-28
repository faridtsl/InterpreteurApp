
$(function () {

    // DataTable
    var table = $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "bSort": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/demande/archive/query",
        "columns": [
            {data: 'titre', name: 'demandes.titre'},
            {data: 'etat_id', name: 'demandes.etat_id', searchable: false, orderable:false},
            {data: 'created_at', name: 'demandes.created_at'},
            {data: 'updated_at', name: 'demandes.updated_at'},
            {data: 'deleted_at', name: 'demandes.deleted_at'},
            {data: 'dateEvent', name: 'demandes.dateEvent'},
            {data: 'dateEndEvent', name: 'demandes.dateEndEvent'},
            {data: 'adresse', name: 'adresses.adresse'},
            {data: 'trads', name: 'trads' ,orderable: false, searchable: false},
            {data: 'butts', name: 'butts' ,orderable: false, searchable: false}
        ]
    } );

    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title!="Action") $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

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


    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

    $('.seeButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $.ajax({
            url: $id,
            type: "GET",
            success: function (data) {

            }, error: function () {
                alert("error!!!!");
            }
        });
    });

});
