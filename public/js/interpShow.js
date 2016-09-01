$(document).ready(function() {
    oTable = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/interpreteur/query",
        "columns": [
            {data: 'nom', name: 'interpreteurs.nom'},
            {data: 'email', name: 'interpreteurs.email'},
            {data: 'prestation', name: 'interpreteurs.prestation'},
            {data: 'tel_portable', name: 'interpreteurs.tel_portable'},
            {data: 'tel_fixe', name: 'interpreteurs.tel_fixe'},
            {data: 'adresse', name: 'adresses.adresse'},
            {data: 'created_at', name: 'interpreteurs.created_at'},
            {data: 'updated_at', name: 'interpreteurs.updated_at'},
            {data: 'traductions', name: 'l1.content'},
            {data: 'prenom', name: 'interpreteurs.prenom', visible:false},
            {data: 'butts', name: 'l2.content' ,orderable: false}
        ]
    });

    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%;" />' );
    } );

    // Apply the search
    oTable.columns().every( function () {
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

    $(document.body).on('click','.editButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: "infos?id="+$id,
            type:"GET",
            success:function(data){
                $("#id").val(data['id']);
                $("#email").val(data['email']);
                $("#prestation").val(data['prestation']);
                $("#tel_fixe").val(data['tel_fixe']);
                $("#tel_portable").val(data['tel_portable']);
                $("#nationalite").val(data['nationalite']);
                $("#nom").val(data['nom']);
                $("#prenom").val(data['prenom']);
                $("#devise").val(data['devise']);
                $("#adr").val(data['adresse_id']);
            },error:function(){
                alert("error!!!!");
            }
        });
    });

    $(document.body).on('click','.deleteButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: "infos?id="+$id,
            type: "GET",
            success: function (data) {
                $("#idDel").val(data['id']);
                var msg = "Suppresion de '";
                var m2 = msg.concat(data['nom']);
                m2 = m2.concat(' ');
                m2 = m2.concat(data['prenom']);
                var m = m2.concat("'");
                $("#headDelete").text(m);
            }, error: function () {
                alert("error!!!!");
            }
        });
    });

});