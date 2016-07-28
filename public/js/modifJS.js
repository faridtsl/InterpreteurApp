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

});