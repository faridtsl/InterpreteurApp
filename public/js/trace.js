/**
 * Created by root on 8/18/16.
 */
$(document).ready(function () {
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Action" && title!="") $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table1 = $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        "bSort": true
    } );


    // Apply the search
    table1.columns().every( function () {
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

});