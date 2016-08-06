
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
        if(isGood=='panel-danger') $('#headDem').html('Nouvelle demande <strong>-Incomplet-</strong>');
        $('#demandePanel').removeClass('panel-info').addClass(isGood).addClass('panel-collapsed').find('.panel-body').slideUp();
        $('#clientPanel').show();
    });

    $('#toggleAdr').on('click',function (e) {
        e.preventDefault();
        var isGood = 'panel-success';
        if($('#client').val() == -1) isGood = 'panel-danger';
        if(isGood=='panel-danger') $('#headCli').html('Liste des clients <strong>-Incomplet-</strong>');
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

});