$(function () {

    function ajaxAdr() {
        // Get the record's ID via attribute
        $id = $("#adr").val();

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
    }

    function ajaxSubmit() {
        $("#updateForm").submit();
    }

    function ajaxGetLangue($idT,$id){
        var l = 'id'+$idT+'l'+$id;
        $.ajax({
            url: '/langue/'+$id,
            type:"GET",
            success:function(data){
                $langs = $('#'+l);
                $langs.html(data['content']);
            },error:function(){
                alert("error!!!!");
            }
        });
    }


    function ajaxCall(data,d) {
        $langs = $("#oldLangs>tbody");
        $source = data[d]['source'];
        $idT = data[d]['id'];
        $cible = data[d]['cible'];
        $csrf = $('meta[name="_token"]').attr('content');
        $csrfIn = '<input type="hidden" name="_token" value="'+$csrf+'">';
        $langsT = '';
        $langsT = $langsT.concat('<tr>');
        $langsT = $langsT.concat('<td style="padding:0 15px 0 15px;"><label id="id'+$idT+'l'+$source+'">');
        $langsT = $langsT.concat('</label></td> <td style="padding:0 15px 0 15px;"> <span class="glyphicon glyphicon-arrow-right"></span> </td> <td style="padding:0 15px 0 15px;"><label id="id'+$idT+'l'+$cible+'">');
        $langsT = $langsT.concat('</label></td>');
        $langsT = $langsT.concat('<td style="padding:0 15px 0 15px;"><form method="post" action="/traduction/delete"><input id="idT" name="idT" type="hidden" value="'+$idT+'"><input id="idI" name="idI" type="hidden" value="'+$id+'">'+$csrfIn+'<button class="btn btn-danger btn-xs tradDel" style="margin-left: 10px" ><span class="glyphicon glyphicon-trash"></span> </button></td></tr>');
        $langs.append($langsT);
        ajaxGetLangue($idT,$source);
        ajaxGetLangue($idT,$cible);
    }

    function ajaxInterp() {
        $id = $("#id").val();

        $.ajax({
            url: '/traductions?idI='+$id,
            type:"GET",
            success:function(data){
                $langs = $("#oldLangs>tbody");
                $langs.html('');
                $.each(data,function (d) {
                    ajaxCall(data,d);
                });
                var elt = $(document).find('.btn-add');
                alert(elt);
                console.log(elt);
                $(document.body).on('click', '.btn-add', function (e) {
                    e.preventDefault();
                    var teams = $(this).parents('#langs:first');
                    var controlForm = $('#updateForm'),
                        currentEntry = $(this).parents('.entry:first'),
                        newEntry = $(currentEntry.clone()).appendTo(teams);
                    newEntry.find('input').val('');
                    controlForm.find('.entry:not(:last) .btn-add')
                        .removeClass('btn-add').addClass('btn-remove')
                        .removeClass('btn-success').addClass('btn-danger')
                        .removeClass('glyphicon-plus').addClass('glyphicon-minus');
                }).on('click', '.btn-remove', function (e) {
                    $(this).parents('.entry:first').remove();
                    e.preventDefault();
                    return false;
                });
            },error:function(){
                alert("error!!!!");
            }
        });
    }

    $(document.body).on('click', '.tradDel',function (e) {
        e.preventDefault();
        $form = $(this).parent('form');

        $.ajax({
            url: '/traduction/delete',
            type:"POST",
            data:$form.serialize(),
            success:function(data){
                $langs = $("#oldLangs>tbody");
                $langs.html('');
                $.each(data,function (d) {
                    ajaxCall(data,d);
                });
            },error:function(){
                //alert("error!!!!");
            }
        });
    });


    $('#edit').modalSteps({
        callbacks: {
          '2' : ajaxAdr,
          '3' : ajaxInterp
        },
        btnCancelHtml: 'Quitter',
        btnPreviousHtml: 'Precedent',
        btnNextHtml: 'Suivant',
        btnLastStepHtml: 'Modifier',
        completeCallback: ajaxSubmit
    });

});