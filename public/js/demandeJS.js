
$(function () {

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
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

    $('.deleteButton').on('click', function () {
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

    $('.restoreButton').on('click', function () {
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
