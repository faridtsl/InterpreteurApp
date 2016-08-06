$(document).ready(function() {

    table = $('#example').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "columnDefs": [{"visible": false, "searchable": false, "targets": [0]}]
        }

    });


    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
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

    $('.resendButton').on('click',function (e) {
        e.preventDefault();
        $id = $(this).attr('data-id');

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

});