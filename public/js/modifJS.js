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

    $('#edit').modalSteps({
        callbacks: {
          '2' : ajaxAdr
        },
        btnCancelHtml: 'Quitter',
        btnPreviousHtml: 'Precedent',
        btnNextHtml: 'Suivant',
        btnLastStepHtml: 'Modifier',
        completeCallback: ajaxSubmit
    });

});