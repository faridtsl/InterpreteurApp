$(document).ready(function () {

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

        // Setup - add a text input to each footer cell
    $('#example tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" />');
    });


    table = $('#example').DataTable();

    $('#archiveDevisTable').DataTable();
    $('#archiveFact').DataTable();

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

    $("#factPanel").addClass('collapse');
    $("#archFactPanel").addClass('collapse');

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

    $(document.body).on('click', '#modifTrad', function (e) {
        e.preventDefault();
        ajaxDemande();
    });

    function ajaxCall(data, d) {
        $langs = $("#oldLangs>tbody");
        $source = data[d]['source'];
        $idT = data[d]['id'];
        $cible = data[d]['cible'];
        $langsT = '';
        $langsT = $langsT.concat('<tr>');
        $langsT = $langsT.concat('<td style="padding:0 15px 0 15px;"><label id="id' + $idT + 'l' + $source + '">');
        $langsT = $langsT.concat('</label></td> <td style="padding:0 15px 0 15px;"> <span class="glyphicon glyphicon-arrow-right"></span> </td> <td style="padding:0 15px 0 15px;"><label id="id' + $idT + 'l' + $cible + '">');
        $langsT = $langsT.concat('</label></td></tr>');
        $langs.append($langsT);
        ajaxGetLangue($idT, $source);
        ajaxGetLangue($idT, $cible);
    }

    $(document.body).on('click', '.resendButton', function (e) {
        e.preventDefault();
        $("#idResend").val($(this).attr('data-id'));
        console.log($("#idResend").val());
        $("#resendModal").modal('show');
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

    function ajaxDemande() {
        $id = $("#id").val();
        $.ajax({
            url: '/traductions?idD=' + $id,
            type: "GET",
            success: function (data) {
                $langs = $("#oldLangs>tbody");
                $langs.html('');
                console.log(data);
                $.each(data, function (d) {
                    ajaxCall(data, d);
                });
            }, error: function () {
                alert("error!!!!");
            }
        });
    }

});
