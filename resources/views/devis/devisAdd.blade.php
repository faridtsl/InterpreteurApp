@extends('layouts.layout')

@section('title')
    Ajouter Devis
@endsection

@section('header')
    <style type="text/css">
        .table-sortable tbody tr {
            cursor: move;
        }
    </style>

    <style type="text/css">
        .modal-dialog {
            width: 100%;
            height: 100%;
            padding: 0;
        }

        #map {
            height: 80vh;
            width: 100%;

        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlkrHCrqBm3WLyMkykudHX02GKzMBFBR0" async defer></script>
    <script type="text/javascript">
        var markers = {};
        var infowindows = {};
    </script>

    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('/css/success.css')}}" />
@endsection

@section('content')
    <br/>
    <form method="POST" action="/devis/add">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                    Liste des interpreteurs
                                </a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <br><br>
                                <!--div class="container-fluid well span6">
                                    <div class="col-sm-2 col-md-2">
                                        <img src="/images/unknown.jpg" alt="" id="imgInterp" class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-sm-2 col-md-4">
                                        <blockquote>
                                            <p id="nomInterp">Aucun</p> <small><cite title="Source Title" id="adresseInterp">Aucun  <i class="glyphicon glyphicon-map-marker"></i></cite></small>
                                        </blockquote>
                                        <p> <i class="glyphicon glyphicon-envelope"></i> <span id="emailInterp">Aucun</span>
                                            <br
                                            /> <i class="glyphicon glyphicon-phone"></i> <span id="telInterp">Aucun</span>
                                    </div>
                                </div--->

                                <table class="table table-striped table-bordered table-hover" id="dynamicInterp" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Envoyer CV</th>
                                        <th>Supprimer</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Envoyer CV</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#" class="btn btn-default btn-block"  data-toggle="modal" data-target="#IntModal">Afficher le tableau des interpreteurs</a>
                                        <a href="#" class="btn btn-default btn-block"  data-toggle="modal" data-target="#MapModal">Afficher la carte des interpreteurs</a>
                                    </div>
                                    <div class="col-lg-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                    Créer un devis
                                </a>
                            </h4>
                        </div>
                        <div id="collapse1">
                            <div class="panel-body">
                                {!! csrf_field() !!}
                                <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                    <thead>
                                    <tr >
                                        <th class="text-center">
                                            Service
                                        </th>
                                        <th class="text-center">
                                            Designation
                                        </th>
                                        <th class="text-center">
                                            Qantité
                                        </th>
                                        <th class="text-center">
                                            Unité
                                        </th>
                                        <th class="text-center">
                                            Prix Unitaire(&euro;)
                                        </th>
                                        <th class="text-center">
                                            Total
                                        </th>
                                        <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>TVA:</th>
                                        <th>
                                            <input id="tva" name='tva' value="{{env('PERCENT_TAXES')}}" class="form-control"/>
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total:</th>
                                        <th>
                                            <div id="total">
                                                @if(Session::has('total'))
                                                    <strong>{{Session::get('total')}}&euro;</strong>
                                                    <script type="text/javascript">
                                                        $("#total").val({{Session::get('total')}});
                                                    </script>
                                                @endif
                                            </div>
                                        </th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if(Session::has('services'))
                                        @foreach(Session::get('services') as $index => $service)

                                            <tr id='addr{{$index}}' data-id="{{$index}}">
                                                <td data-name="service">
                                                    <input id="service{{$index}}" value="{{$service->service}}" type="text" name='service[]'  placeholder='Service' class="form-control"/>
                                                </td>
                                                <td data-name="designation">
                                                    <input id="designation{{$index}}" value="{{$service->designation}}" type="text" name='designation[]'  placeholder='designation' class="form-control"/>
                                                </td>
                                                <td data-name="qte">
                                                    <input id="qte{{$index}}" type="number" value="{{$service->qantite}}" onkeypress='validate(event)' name='qte[]' placeholder='Quantité' class="form-control"/>
                                                </td>
                                                <td data-name="unite">
                                                    <input id="unite{{$index}}" type="text" value="{{$service->Unite}}" name='unite[]' placeholder="unité" class="form-control"/>
                                                </td>
                                                <td data-name="prixUnitaire">
                                                    <input id="prixUnitaire{{$index}}" value="{{$service->prix}}" type="number" name='prixUnitaire[]' onkeypress='validate(event)' step="0.001" placeholder="prix unitaire" class="form-control"/>
                                                </td>
                                                <td data-name="total">
                                                    <div id="total{{$index}}" name="total{{$index}}"><strong>{{$service->total}}&euro;</strong></div>
                                                    <script type="text/javascript">
                                                    </script>
                                                    <script type="text/javascript">
                                                        $("#total{{$index}}").val({{$service->total}});
                                                    </script>
                                                </td>
                                                <td data-name="del">
                                                    <button id="del{{$index}}" name="del{{$index}}" class="btn btn-danger glyphicon glyphicon-remove row-remove"></button>
                                                </td>
                                            </tr>
                                            <script type="text/javascript">
                                                $('#qte{{$index}},#prixUnitaire{{$index}}').on('input', function() {
                                                    calculer({{$index}});
                                                });
                                            </script>
                                        @endforeach
                                    @else
                                        <tr id='addr0' data-id="0">
                                            <td data-name="service">
                                                <input id="service0" type="text" name='service[]'  placeholder='Service' class="form-control"/>
                                            </td>
                                            <td data-name="designation">
                                                <input id="designation0" type="text" name='designation[]'  placeholder='designation' class="form-control"/>
                                            </td>
                                            <td data-name="qte">
                                                <input id="qte0" type="number" onkeypress='validate(event)' name='qte[]' placeholder='Quantité' class="form-control"/>
                                            </td>
                                            <td data-name="unite">
                                                <input id="unite0" type="text" name='unite[]' placeholder="unité" class="form-control"/>
                                            </td>
                                            <td data-name="prixUnitaire">
                                                <input id="prixUnitaire0" type="number" name='prixUnitaire[]' onkeypress='validate(event)' step="0.001" placeholder="prix unitaire" class="form-control"/>
                                            </td>
                                            <td data-name="total">
                                                <div id="total0" value="0"></div>
                                            </td>
                                            <td data-name="del">
                                                <button id="del0" name="del0" class="btn btn-danger glyphicon glyphicon-remove row-remove"></button>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    <button id="add_row" type="button" class="btn btn-outline btn-default">Ajouter une ligne</button>
                                    <button type="submit" class="btn btn-outline btn-default">Valider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="interpreteur_id" value="" id="interpreteur"/>
                <input type="hidden" name="demande_id" value="{{$demande->id}}"/>
            </div>
        </div>
    </form>

<!-- Modal -->
<div class="modal fade" id="IntModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Liste des interpreteurs</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success success-alert" id="success-alert2">
                    Interpret <strong class="nom"></strong> selectionné!
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>E-MAIL</th>
                        <th>Prestation</th>
                        <th>init=>dest</th>
                        <th>Adresse</th>
                        <th>image</th>
                        <th>tel_portable</th>
                        <th>adresse</th>
                        <th>nomprenom</th>
                        <th>Select</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>E-MAIL</th>
                        <th>Prestation</th>
                        <th>init=>dest</th>
                        <th>Adresse</th>
                        <th>image</th>
                        <th>tel_portable</th>
                        <th>adresse</th>
                        <th>nomprenom</th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="MapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Liste interpreteurs</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success success-alert" id="success-alert2">
                    Interpret <strong class="nom"></strong> selectionné!
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <table id="dataTables-example2" class="table table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nom</th>
                                <th>E-MAIL</th>
                                <th>Prestation</th>
                                <th>init=>dest</th>
                                <th>image</th>
                                <th>tel_portable</th>
                                <th>adresse</th>
                                <th>Select</th>
                                <th>lat</th>
                                <th>long</th>
                            </tr>
                            </thead>
                            <tbody class="searchable">

                            </tbody>
                        </table>
                        <button id="afficherTout" type="button" class="btn btn-danger">Dessiner</button>
                    </div>
                    <div class="col-lg-7">
                        <div id="map"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

    </div>

@include('includes.popups')

@endsection

@section('footer')

<script type="text/javascript">
    @if (count($errors) > 0)
        $('#errorModal').modal('show');
    @endif

    @if (isset($message))
        $("#modalSuccess").modal('toggle');
    @endif
</script>

<script src="{{ asset('js/tableTools.js')}}"></script>
<script src="{{ asset('js/devisAddVars.js')}}"></script>


    <script type="text/javascript">

        function addInterpreteur(id,nom,email,img,tel,adr){
            $col1 = '<img class="img-circle" src="/images/'+img+'" style="width: 50px;height:50px;"/>' + nom;
            $col2 = email;
            $col3 = '<input type="hidden" name="idInterp[]" value="'+id+'" />\
            <select name="sendMail[]">\
                    <option class="radio" value="cv"> CV</option> \
                    <option class="radio" value="cv_anonyme"> CV anonyme</option>\
                    <option class="radio" selected value="non"> rien</option>\
            <select>';
            $col4 = '<button class="btn btn-danger" id="deselect'+counter+'">Supprimer</button>';
            $(document.body).on('click','#deselect'+counter,function (e) {
                e.preventDefault();
                var row = t.row( $(this).parents('tr') );
                row.remove();
                t.draw();

            });
            if(nom != "Aucun" && $('#dynamicInterp tr > td:contains('+email+')').length == 0){
                t.row.add([
                    $col1,
                    $col2,
                    $col3,
                    $col4
                ]).draw( false );
                counter++;
                $('.success-alert').find('.nom').text(nom);
                $('.success-alert').alert();
                $(".success-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".success-alert").slideUp(500);
                });
            }
        }

        function initMarkersAndWindows(){
            $('#afficherTout').on('click',function (e) {
                e.preventDefault();
                for(id in markers)
                    markers[id].setVisible(false);
                markers = [];
                var cnt = 0;
                table2.rows().eq(0).each( function ( index ) {
                    var row = table2.row( index );
                    row = $.map(row.data(), function(value, index) {
                        return [value];
                    });
                    var npr = row[15].split(' ');
                    markersNewPage(row[0],cnt,npr[0],npr[1],row[3],row[9],row[7],row[8],row[6],parseFloat(row[13]),parseFloat(row[14]));
                    cnt++;
                } );
               console.log(cnt);
            });

            google.maps.event.addListenerOnce(map, 'idle', function() {
                google.maps.event.trigger(map, 'resize');
            });
        }

        function markersNewPage(id,idx,nom,prenom,email,image,tel_portable,tel_fixe,adresse,lt,lng){
            markers[idx] = new google.maps.Marker({
                position: {lat: lt, lng: lng},
                map: map,
                title: nom + ' ' + prenom
            });
            infowindows[idx] = new google.maps.InfoWindow({
                content:
                        '\
                        <div class="container" style="width:300px">\
                          <div class="row">\
                            <img class="img-circle" src="/images/'+image+'" style="width: 50px;height:50px;">\
                          </div>\
                          <div class="row">\
                            <div class="col-lg-3"><strong>Nom</strong></div>\
                            <div class="col-lg-9">'+nom+'</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Prenom</strong></div>\
  <div class="col-lg-9">'+prenom +'</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>email</strong></div>\
  <div class="col-lg-9">'+email +'</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Portable</strong></div>\
  <div class="col-lg-9">'+tel_portable +'</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Fixe</strong></div>\
  <div class="col-lg-9">'+tel_fixe +'</div>\
</div>\
<div class="row">\
  <div class="col-lg-8"></div>\
  <div class="col-lg-4"><button type="button" onclick="addInterpreteur('+ id +',\''+nom+' '+prenom+'\',\''+email+'\',\''+image+'\',\''+tel_portable+'\',\''+adresse+'\')" class="btn btn-primary">Select</button></div>\
</div>\
</div>'
            });

            console.log(lt+' '+lng);
            markers[idx].setVisible(true);

            markers[idx].addListener('click', function() {
                infowindows[idx].open(map, markers[idx]);
            });
        }

        function createMap(){
            var demandeLG = {lat: {{$demande->adresse->lat}}, lng: {{$demande->adresse->long}} };
            mapDiv = document.getElementById('map');
            map = new google.maps.Map(mapDiv, {
                center: demandeLG,
                zoom: 18
            });
            var image = "{{ asset('images/marker.png') }}";
            var marker1 = new google.maps.Marker({
                position: {lat: {{ $demande->adresse->lat }}, lng: {{ $demande->adresse->long }} },
                map: map,
                title:  '{{ $demande->client->nom }} {{ $demande->client->prenom }}',
                icon: image
            });
        }

        function drawFiltredRows(){
            createMap();
            var filteredRows = table2.rows({filter:'applied'});
            filteredRows.every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                markers[data[0]].setMap(map);
            });
        }

        function calculer(newid)   // declaration de la fonction avec un argument
        {
            var AncienneVal  = $("#total"+newid).val();
            console.log("AncienneVal"+AncienneVal);
            var quantite = $("#qte"+newid).val();
            console.log("quantite"+quantite);
            var prixUnitaire = $("#prixUnitaire"+newid).val();
            console.log("prixUnitaire"+prixUnitaire);
            var valeur = quantite*prixUnitaire;
            $("#total"+newid).html("<strong>"+quantite*prixUnitaire+"&euro;</strong>");
            $("#total"+newid).val(valeur);
            var total = +$("#total").val() - +AncienneVal;
            var somme = +valeur + +total;
            $("#total").html("<strong>"+somme+"&euro;</strong>");
            $("#total").val(somme);
        }


        $(document).ready(function() {

            $('#MapModal').on('show.bs.modal', function(){
                createMap();
                initMarkersAndWindows();
            });


            $("#add_row").on("click", function() {
                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("#tab_logic tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "addr"+newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                    var cur_td = $(this);

                    var children = cur_td.children();

                    // add new td and element if it has a nane
                    if ($(this).data("name") != undefined) {
                        var td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });


                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("").text("");
                        c.attr("id", $(cur_td).data("name") + newid);
                        c.attr("name", $(cur_td).data("name")+"[]");
                        c.prop('disabled', false);
                        c.val("");
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        var td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }


                });

                // add the new row
                $(tr).appendTo($('#tab_logic'));
                $('#qte'+newid+",#prixUnitaire"+newid).on('input', function() {
                    calculer(newid);
                });

                $(tr).find("td button.row-remove").on("click", function() {
                    $("#qte"+newid).val(0);
                    $("#prixUnitaire"+newid).val(0);
                    calculer(newid);
                    $(this).closest("tr").remove();
                });
            });

// Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });

                return $helper;
            };



//$("#add_row").trigger("click");
        });


        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key)  && theEvent.keyCode != 8) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        $('#qte0,#prixUnitaire0').on('input', function() {
            calculer(0);
        });
    </script>



@endsection