$(function () {

    table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/interpreteur/archive/query",
        "columns": [
            {data: 'nom', name: 'interpreteurs.nom'},
            {data: 'email', name: 'interpreteurs.email'},
            {data: 'prestation', name: 'interpreteurs.prestation'},
            {data: 'tel_portable', name: 'interpreteurs.tel_portable'},
            {data: 'adresse', name: 'adresses.adresse'},
            {data: 'butts', name: 'butts' ,orderable: false, searchable: false}
        ]});

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%;" />' );
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


    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });


    $(document.body).on('click','.restoreButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $.ajax({
            url: "infos?id="+$id,
            type: "GET",
            success: function (data) {
                $("#idRestore").val(data['id']);
                var msg = "Restoration de '";
                var m2 = msg.concat(data['nom']);
                m2 = m2.concat(' ');
                m2 = m2.concat(data['prenom']);
                var m = m2.concat("'");
                $("#headRestore").text(m);
            }, error: function () {
                alert("error!!!!");
            }
        });
    });


});
