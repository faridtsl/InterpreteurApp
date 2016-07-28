
$(function () {

    function ajaxAdr() {
        // Get the record's ID via attribute
        $id = $("#adr").val();

        $.ajax({
            url: '/adresse/'+$id,
            type:"GET",
            success:function(data){
                $("#adresse").val(data['adresse']);
                $("#pays").val(data['pays']);
                $("#ville").val(data['ville']);
                $("#departement").val(data['departement']);
                $("#code_postal").val(data['code_postal']);
                $("#numero").val(data['numero']);
                $("#route").val(data['route']);
                $("#lat").val(data['lat']);
                $("#long").val(data['long']);
            },error:function(){
                alert("error!!!!");
            }
        });
    }

    function ajaxSubmit() {
        $.ajax({
            type: "POST",
            url: '/interpreteur/update',
            data: $("#updateForm").serialize(), // serializes the form's elements.
            success: function(data){
                location.reload();
                alert(data); // show response from the php script.
            },error:function (data) {
                console.log(data);
            }
        });
    }

    $('#edit').modalSteps({
        callbacks: {
            '2': ajaxAdr
        },
        btnCancelHtml: 'Quitter',
        btnPreviousHtml: 'Precedent',
        btnNextHtml: 'Suivant',
        btnLastStepHtml: 'Modifier',
        completeCallback: ajaxSubmit
    });

    $('#example').DataTable();

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

    $(document).on('click', '.btn-add', function(e){
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
    }).on('click', '.btn-remove', function(e){
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $('.editButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: $id,
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

    $('.deleteButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: $id,
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

    $('.restoreButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');
        $.ajax({
            url: $id,
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
