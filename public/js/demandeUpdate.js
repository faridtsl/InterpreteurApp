$(document).ready(function () {

    $('#clients').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function (nodes) {
                var ttInstance = TableTools.fnGetInstance("clients");
                var row = ttInstance.fnGetSelectedData();
                $('#client').val(row[0]['id']);
                $id = row[0]['id'];

                $.ajax({
                    url: "/client/infos?id="+$id,
                    type:"GET",
                    success:function(data){
                        console.log(data);
                        $("#emailCli").html(data['email']);
                        $("#fixeCli").html(data['tel_fixe']);
                        $("#portCli").html(data['tel_portable']);
                        $("#nomCli").html(data['nom']+ ' ' + data['prenom']);
                        $("#imgCli").html('<img class="img-circle" src="/images/'+data['image']+'"\
                        style="width: 100px;height:100px;">');
                    },error:function(){
                        alert("error!!!!");
                    }
                });
            },

            fnRowDeselected: function (node) {
                $('#client').val("");
            }
        },
        "processing": true,
        "serverSide": true,
        "ajax": "/client/query",
        "columns": [
            {data: 'id', name: 'clients.id', visible:false},
            {data: 'nom', name: 'clients.nom'},
            {data: 'email', name: 'clients.email'},
            {data: 'tel_portable', name: 'clients.tel_portable'},
            {data: 'tel_fixe', name: 'clients.tel_fixe'}
        ]

    });

    $('.editClass').hide();

    $('.editChamps').on('click', function (e) {
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

    $('#showAdrModal').on('click', function () {

        $id = $(this).attr('data-id');

        $.ajax({
            url: '/adresse/' + $id,
            type: "GET",
            success: function (data) {
                $("#adresse").val(data['adresse']);
                $("#country").val(data['pays']);
                $("#locality").val(data['ville']);
                $("#administrative_area_level_1").val(data['departement']);
                $("#postal_code").val(data['code_postal']);
                $("#street_number").val(data['numero']);
                $("#route").val(data['route']);
                $("#lat").val(data['lat']);
                $("#long").val(data['long']);
            }, error: function () {
                alert("error!!!!");
            }
        });
    });

    $('#toggleCli').on('click', function (e) {
        e.preventDefault();
        $('#demandePanel').removeClass('in');
        $('#clientPanel').addClass('in');
    });

    $('#adrConfirm').on('click', function (e) {
        e.preventDefault();
        $form = $('#adrForm');
        $.ajax({
            url: '/adresse/update',
            type: "POST",
            data: $form.serialize(),
            success: function (data) {
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
            }, error: function (data) {
                alert("erreur ressayé");
            }
        });
    });

    $('#modAdr').on('click', function () {
        $('.enab').removeAttr('readonly');
        $(this).hide();
    });

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" />');
    });


    table = $('#example').DataTable();

    // Apply the search
    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });


    $('#resend').on('click', function (e) {
        $id = $(this).parent().find('#idResend').val();

        $.ajax({
            url: '/devis/resend?id=' + $id,
            type: "GET",
            success: function (data) {
                $("#resendModal").modal('hide');
                $('#modalSuccess').find('.modal-body').html('Devis renvoyé au client');
                $('#modalSuccess').modal('toggle');
            }, error: function () {
                alert("error!!!!");
            }
        });
    });

    $(document.body).on('click', '.resendButton', function (e) {
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
    $('#exampleFact tfoot th').each(function () {
        var title = $(this).text();
        if (title != "" && title != 'Action') $(this).html('<input type="text" placeholder="' + title + '"  style="width: 100%;" />');
    });

    // Apply the search
    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });

    $("#exampleFact").css("width", "100%");


    $("#devisModal").on('shown.bs.modal', function () {
        //Get the datatable which has previously been initialized
        var dataTable = $('#example').DataTable();
        //recalculate the dimensions
        dataTable.columns.adjust().responsive.recalc();

    });
    //myTable.responsive.recalc();


    $("#factPanel").addClass('collapse');

    function ajaxGetLangue($idT, $id) {
        var l = 'id' + $idT + 'l' + $id;
        $.ajax({
            url: '/langue/' + $id,
            type: "GET",
            success: function (data) {
                $langs = $('#' + l);
                $langs.html(data['content']);
            }, error: function () {
                alert("error!!!!");
            }
        });
    }


    function ajaxCall(data, d) {
        $langs = $("#oldLangs>tbody");
        $source = data[d]['source'];
        $idT = data[d]['id'];
        $cible = data[d]['cible'];
        $csrf = $('meta[name="_token"]').attr('content');
        console.log($csrf);
        $csrfIn = '<input type="hidden" name="_token" value="' + $csrf + '">';
        $langsT = '';
        $langsT = $langsT.concat('<tr>');
        $langsT = $langsT.concat('<td style="padding:0 15px 0 15px;"><label id="id' + $idT + 'l' + $source + '">');
        $langsT = $langsT.concat('</label></td> <td style="padding:0 15px 0 15px;"> <span class="glyphicon glyphicon-arrow-right"></span> </td> <td style="padding:0 15px 0 15px;"><label id="id' + $idT + 'l' + $cible + '">');
        $langsT = $langsT.concat('</label></td>');
        $langsT = $langsT.concat('<td style="padding:0 15px 0 15px;"><form method="post" action="/traduction/delete"><input id="idT" name="idT" type="hidden" value="' + $idT + '"><input id="idD" name="idD" type="hidden" value="' + $id + '">' + $csrfIn + '<button class="btn btn-danger btn-xs tradDel" style="margin-left: 10px" ><span class="glyphicon glyphicon-trash"></span> </button></td></tr>');
        $langs.append($langsT);
        ajaxGetLangue($idT, $source);
        ajaxGetLangue($idT, $cible);
    }

    function ajaxDemande() {
        $id = $("#id").val();

        $.ajax({
            url: '/traductions?idD=' + $id,
            type: "GET",
            success: function (data) {
                $langs = $("#oldLangs>tbody");
                $langs.html('');
                $.each(data, function (d) {
                    ajaxCall(data, d);
                });
            }, error: function () {
                alert("error!!!!");
            }
        });
    }

    $(document.body).on('click', '.tradDel', function (e) {
        e.preventDefault();
        $form = $(this).parent('form');

        $.ajax({
            url: '/traduction/delete',
            type: "POST",
            data: $form.serialize(),
            success: function (data) {
                $langs = $("#oldLangs>tbody");
                $langs.html('');
                $.each(data, function (d) {
                    ajaxCall(data, d);
                });
            }, error: function () {
                alert("error!!!!");
            }
        });
    });


    $(document.body).on('click', '#modifTrad', function (e) {
        e.preventDefault();
        ajaxDemande();
    });

    $(document).on('click', '.btn-add', function (e) {
        e.preventDefault();
        var teams = $(this).parents('#langs:first');
        var controlForm = $('#formID'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(teams);
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.entry:first').remove();
        e.preventDefault();
        return false;
    });


    $("#archFactPanel").addClass('collapse');
    $('#archiveDevisTable').DataTable();
    $('#archiveFact').DataTable();

});
