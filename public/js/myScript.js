
$(function () {

    table = $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]});

    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!="" && title != 'Action') $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%;" />' );
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

    $(document.body).on('click','.editButton', function () {
        // Get the record's ID via attribute
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

    $(document.body).on('click','.deleteButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: "infos?id="+$id,
            type: "GET",
            success: function (data) {
                $("#idDel").val(data['id']);
                var msg = "Suppresion de '";
                var m2 = msg.concat(data['nom']);
                m2 = m2.concat(' ');
                m2 = m2.concat(data['prenom']);
                var m = m2.concat("'");
                $("#headDelete").text(m);
            }, error: function () {
                alert("error!!!!");
            }
        });
    });

    $(document.body).on('click','.restoreButton', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $.ajax({
            url: "infos?id="+$id,
            type: "GET",
            success: function (data) {
                $("#idRestore").val(data['id']);
                var msg = "Restoration de '";
                var m2 = msg.concat(data['nom']);
                m2 = m2.concat(' ');
                m2 = m2.concat(data['prenom']);
                var m = m2.concat("'");
                $("#headRestore").text(m);
            }, error: function () {
                alert("error!!!!");
            }
        });
    });


});
