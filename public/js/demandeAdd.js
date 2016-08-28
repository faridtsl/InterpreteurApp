
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        "pageLength": 10,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
            fnRowSelected: function(nodes) {
                var ttInstance = TableTools.fnGetInstance("dataTables-example");
                var row = ttInstance.fnGetSelectedData();
                $('#client').val(row[0]['id']);
            },

            fnRowDeselected: function ( node ) {
                $('#client').val("-1");
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

    $('#clientPanel').hide();
    $('#adrPanel').hide();

    $('#toggleCli').on('click',function (e) {
        e.preventDefault();
        var isGood = 'panel-success';
        $('input,textarea,select', $('#demandePanel')).each(function () {
            if($(this).is('textarea')){
                if(CKEDITOR.instances.content.getData()=='') isGood='panel-danger';
            }else {
                if($(this).val() == null || $(this).val() == '') isGood='panel-danger';
            }
        });
        if(isGood=='panel-danger') $('#headDem').html('Nouvelle demande <strong id="demInc">-Incomplet-</strong>');
        else $('#demInc').html("");
        $('#demandePanel').removeClass('panel-info').addClass(isGood).addClass('panel-collapsed').find('.panel-body').slideUp();
        $('#clientPanel').show();
    });

    $('#toggleAdr').on('click',function (e) {
        e.preventDefault();
        var isGood = 'panel-success';
        if($('#client').val() == -1) isGood = 'panel-danger';
        if(isGood=='panel-danger') $('#headCli').html('Liste des clients <strong id="cliInc">-Incomplet-</strong>');
        else $('#cliInc').html("");
        $('#clientPanel').removeClass('panel-info').addClass(isGood).addClass('panel-collapsed').find('.panel-body').slideUp();
        $('#adrPanel').show();
    });

    $('#returnCli').on('click',function(e){
        e.preventDefault();
        $('#adrPanel').hide();
        $('#clientPanel').addClass('panel-info').removeClass('panel-danger').removeClass('panel-success').removeClass('panel-collapsed').find('.panel-body').slideDown();
    });

    $('#returnDem').on('click',function(e){
        e.preventDefault();
        $('#clientPanel').hide();
        $('#demandePanel').addClass('panel-info').removeClass('panel-danger').removeClass('panel-success').removeClass('panel-collapsed').find('.panel-body').slideDown();
    });

    $('#submitButton').on('click', function (e) {
        e.preventDefault();
        $('#confirmMail').modal('show');
    });

    $(document.body).on('click','#yesMail',function (e) {
        e.preventDefault();
        $('#sendMail').val(1);
        $('#formID').submit();
    });

    $(document.body).on('click','#nonMail',function (e) {
        e.preventDefault();
        $('#sendMail').val(0);
        $('#formID').submit();
    });

});