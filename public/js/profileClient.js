$(document).ready(function() {

    table = $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        tableTools: {
            "columnDefs": [{"visible": false, "searchable": false, "targets": [0]}]
        }
    });

    // Setup - add a text input to each footer cell
    $('#tableFactures tfoot th').each( function () {
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


    table2 = $('#demandesTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        tableTools: {
            "columnDefs": [{"visible": false, "searchable": false, "targets": [0]}]
        }
    });

    // Setup - add a text input to each footer cell
    $('#demandesTable tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'"  style="width: 100%;" />' );
    } );

    // Apply the search
    table2.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );


    table3 = $('#tableCommande').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        tableTools: {
            "columnDefs": [{"visible": false, "searchable": false, "targets": [0]}]
        }
    });

    // Setup - add a text input to each footer cell
    $('#tableCommande tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'"  style="width: 100%;" />' );
    } );

    // Apply the search
    table3.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    $("#tableCommande").css("width","100%");
    $("#demandesTable").css("width","100%");
    $("#tableFactures").css("width","100%");


    $('#resendFact').on('click',function (e) {
        e.preventDefault();
        $id = $('#idResendFact').val();
        $("#resendModalFact").modal('hide');
        $.ajax({
            url: '/facture/resend?id='+$id,
            type:"GET",
            success:function(data){
                $('#modalSuccess').find('.modal-body').html('Facture renvoyé au client');
                $('#modalSuccess').modal('toggle');
            },error:function(d){
                console.log(d);
                alert("error!!!!");
            }
        });
    });

    $('.resendFact').on('click',function (e) {
        e.preventDefault();
        $("#idResendFact").val($(this).attr('data-id'));
        console.log($("#idResendFact").val());
        $("#resendModalFact").modal('show');
    });

    $(document.body).on('click','.editButton', function (e) {
        // Get the record's ID via attribute
        e.preventDefault();
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
                $("#nom").val(data['nom']);
                $("#prenom").val(data['prenom']);
                $("#devise").val(data['devise']);
                $("#adr").val(data['adresse_id']);
            },error:function(){
                alert("error!!!!");
            }
        });
    });


    $(document.body).on('click','.delButtonDem', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $.ajax({
            url: '/demande/get/'+$id,
            type: "GET",
            success: function (data) {
                $("#idDel").val(data['id']);
                var msg = "Suppresion de '";
                var m2 = msg.concat(data['titre']);
                m2 = m2.concat(' ');
                var m = m2.concat("'");
                $("#headDelete").text(m);
                $("#deleteForm").attr('action','/demande/delete');
                $('#delete').modal("show");
            }, error: function () {
                alert("error!!!!");
            }
        });
    });

    $(document.body).on('click','.editor_remove', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $("#idDel").val($id);
        var msg = "Suppresion de devis";
        $("#deleteForm").attr('action','/devis/delete');
        $("#headDelete").text(msg);
        $('#delete').modal("show");
    });


    $(document.body).on('click','.resendButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $("#idRes").val($id);
        var msg = "Renvoi de devis";
        $("#headRes").text(msg);
        $('#resendModalDevis').modal("show");
    });


    $('#resendDev').on('click',function (e) {
        e.preventDefault();
        $id = $('#idRes').val();
        $("#resendModalDevis").modal('hide');
        $.ajax({
            url: '/devis/resend?id='+$id,
            type:"GET",
            success:function(data){
                $('#modalSuccess').find('.modal-body').html('Devis renvoyé au client');
                $('#modalSuccess').modal('toggle');
            },error:function(){
                alert("error!!!!");
            }
        });
    });


    $("#factPanel").addClass('collapse');
    $("#demandePanel").addClass('collapse');
    $("#commandePanel").addClass('collapse');

});
