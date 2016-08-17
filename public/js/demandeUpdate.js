$(document).ready(function() {

    $('#clients').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                console.log("here");
                var ttInstance = TableTools.fnGetInstance("clients");
                var row = ttInstance.fnGetSelectedData();
                $('#client').val(row[0][0]);
                console.log(row[0][0]);
            },

            fnRowDeselected: function ( node ) {
                $('#client').val("");
            }
        },"columnDefs":
            [ { "visible": false, "searchable": false, "targets":[0] }]

    });

    $('.editClass').hide();

    $('.editChamps').on('click',function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        $('.par').removeClass('col-lg-3');
        $('.par').removeClass('col-lg-6');
        var ed = $('.editClass').show();
        $('.displayClass').hide();
        $('.lab').removeClass('col-lg-6');
        $('.lab').removeClass('col-lg-3');
        $(this).hide();
    });

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

    $('#showAdrModal').on('click',function () {

        $id = $(this).attr('data-id');

        $.ajax({
            url: '/adresse/'+$id,
            type:"GET",
            success:function(data){
                $("#adresse").val(data['adresse']);
                $("#country").val(data['pays']);
                $("#locality").val(data['ville']);
                $("#administrative_area_level_1").val(data['departement']);
                $("#postal_code").val(data['code_postal']);
                $("#street_number").val(data['numero']);
                $("#route").val(data['route']);
                $("#lat").val(data['lat']);
                $("#long").val(data['long']);
            },error:function(){
                alert("error!!!!");
            }
        });
    });

    $('#toggleCli').on('click',function (e) {
        e.preventDefault();
        $('#demandePanel').removeClass('in');
        $('#clientPanel').addClass('in');
    });

    $('#adrConfirm').on('click',function (e) {
        e.preventDefault();
        $form = $('#adrForm');
        $.ajax({
            url: '/adresse/update',
            type:"POST",
            data:$form.serialize(),
            success:function(data){
                $("#adresse").val(data['adresse']);
                $("#country").val(data['pays']);
                $("#locality").val(data['ville']);
                $("#administrative_area_level_1").val(data['departement']);
                $("#postal_code").val(data['code_postal']);
                $("#street_number").val(data['numero']);
                $("#route").val(data['route']);
                $("#lat").val(data['lat']);
                $("#long").val(data['long']);
                $("#modalSuccess").find('.modal-body').html('Adresse changée avec success');
                $("#modalSuccess").modal('toggle');
            },error:function(data){
                alert("erreur ressayé");
            }
        });
    });

    $('#modAdr').on('click',function () {
        $('.enab').removeAttr('readonly');
        $(this).hide();
    });

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );


    table = $('#example').DataTable();

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

    $(document.body).on('click','.resendButton',function (e) {
        e.preventDefault();
        $("#idResend").val($(this).attr('data-id'));
        console.log($("#idResend").val());
        $("#resendModal").modal('show');
    });




    table = $('#exampleFact').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        tableTools: {
            "columnDefs": [{"visible": false, "searchable": false, "targets": [0]}]
        }
    });

    // Setup - add a text input to each footer cell
    $('#exampleFact tfoot th').each( function () {
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

    $("#exampleFact").css("width","100%");


    $("#devisModal").on('shown.bs.modal', function() {
        //Get the datatable which has previously been initialized
        var dataTable= $('#example').DataTable();
        //recalculate the dimensions
        dataTable.columns.adjust().responsive.recalc();

    });
    //myTable.responsive.recalc();


    $("#factPanel").addClass('collapse');

});
