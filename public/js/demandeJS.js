
$(function () {

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title!="Action") $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "bSort": true
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


    $('#tableExpire tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    });


    var table = $('#tableExpire').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "bSort": true
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


    $('.editButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: $id,
            type:"GET",
            success:function(data){

            },error:function(){
                alert("error!!!!");
            }
        });
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

    $(document.body).on('click','.delButton', function () {
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
                $('#delete').modal("show");
            }, error: function () {
                alert("error!!!!");
            }
        });
    });


    $("#collapse2").addClass('collapse');


});
