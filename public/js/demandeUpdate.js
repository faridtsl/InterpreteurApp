$(document).ready(function() {

    $('#dataTables-example').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                var ttInstance = TableTools.fnGetInstance("dataTables-example");
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
        parent.removeClass('col-lg-3');
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

});