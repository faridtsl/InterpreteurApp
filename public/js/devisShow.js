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

    $("#example").css("width","100%");

    table2 = $('#tableCommande').DataTable({
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
    $("#tableCommande").css("width","100%");


    $('#resend').on('click',function (e) {
        $id = $(this).parent().find('#idResend').val();
        $.ajax({
            url: '/devis/resend?id='+$id,
            type:"GET",
            success:function(data){
                $("#resendModal").modal('hide');
                $('#modalSuccess').find('.modal-body').html('Devis renvoyé au client');
                $('#modalSuccess').modal('toggle');
            },error:function(){
                alert("error!!!!");
            }
        });
    });

   /* $(document.body).on('click','.resendButton',function (e) {
        e.preventDefault();
        $("#idResend").val($(this).attr('data-id'));
        console.log($("#idResend").val());
        $("#resendModal").modal('show');
    });
*/
    $(document.body).on('click','.editor_remove', function (e) {
        e.preventDefault();
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $("#idDel").val($id);
        var msg = "Suppresion de devis";
        $("#headDelete").text(msg);
        $('#delete').modal("show");
    });


    $(document.body).on('click','.resendButton', function (e) {
        e.preventDefault();
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



    $("#collapse2").addClass('collapse');

});