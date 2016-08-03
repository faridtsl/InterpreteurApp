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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlkrHCrqBm3WLyMkykudHX02GKzMBFBR0" async defer>
    </script>
    <script type="text/javascript">
        var markers = {};
        var infowindows = {};
    </script>

    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
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
                                <div class="row">
                                    <div class="col-lg-2">
                                    </div>
                                    <div  class="col-lg-10">
                                        <h4>Interpreteur selectionné</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-3">
                                        <strong>Nom de l'interpreteur</strong>
                                    </div>
                                    <div class="col-lg-6" id="nomInter">
                                        Aucun
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-3">
                                        <strong>email</strong>
                                    </div>
                                    <div class="col-lg-6" id="emailInter">
                                        Aucun
                                    </div>
                                </div>
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
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>E-MAIL</th>
                            <th>init=>dest</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>E-MAIL</th>
                            <th>init=>dest</th>
                            <th>Edit</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($interpreteurs as $interpreteur)
                            <tr>
                                <td>{{$interpreteur->id}}</td>
                                <td>{{$interpreteur->nom}}</td>
                                <td>{{$interpreteur->prenom}}</td>
                                <td>{{$interpreteur->email}}</td>
                                <td>
                                    <select class="form-control" name="langue_ini">
                                        @foreach(\App\Tools\TraductionTools::getTraductionsByInterpreteur($interpreteur->id) as $traduction)
                                            <option><strong>{{\App\Tools\LangueTools::getLangue($traduction->source)->content}}→{{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}</strong></option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><a href="/interpreteur/edit/{{$interpreteur->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="MapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Liste interpreteurs</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <table id="dataTables-example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nom</th>
                                    <th>prenom</th>
                                    <th>email</th>
                                    <th>init=>dest</th>
                                </tr>
                                </thead>
                                <tbody class="searchable">
                                @foreach($interpreteurs as $interpreteur)
                                    <tr>
                                        <td>{{$interpreteur->id}}</td>
                                        <td>{{$interpreteur->nom}}</td>
                                        <td>{{$interpreteur->prenom}}</td>
                                        <td>{{$interpreteur->email}}</td>
                                        <td>
                                            <select class="form-control" name="langue_ini">
                                                @foreach(\App\Tools\TraductionTools::getTraductionsByInterpreteur($interpreteur->id) as $traduction)
                                                    <option><strong>{{\App\Tools\LangueTools::getLangue($traduction->source)->content}}→{{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}</strong></option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button id="draw" type="button" class="btn btn-primary">Dessiner</button>
                        </div>
                        <div class="col-lg-8">
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
        <!-- /.modal -->


@endsection

@section('modals')

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  modal-header-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Liste d'erreurs</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Erreurs : </strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <i class="fa fa fa-times fa-fw"></i> {{$error}} <br/>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@if(isset($message))
    <div id="modal-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="glyphicon glyphicon-check"></i>
                </div>
                <div class="modal-title">Success</div>
                <div class="modal-body">{{$message}}</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
@endif

@endsection

@section('footer')

    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#errorModal').modal('show');
        @endif
        @if (isset($message))$('#modal-success').modal('show');@endif
        var table2;
        var table;
    </script>

    <script src="{{ asset('js/tableTools.js')}}"></script>

    <script>
        $(document).ready(function() {
            $("#draw").on("click", function() {
                drawFiltredRows();
            });

            table = $('#dataTables-example').DataTable({
                "pageLength": 10,
                dom: 'T<"clear">lfrtip',
                tableTools: {
                    "sRowSelect": "single",
                    fnRowSelected: function(nodes) {
                        var ttInstance = TableTools.fnGetInstance("dataTables-example");
                        var row = ttInstance.fnGetSelectedData();
                        $('#interpreteur').val(row[0][0]);
                        addInterpreteur(row[0][0],row[0][1] + row[0][2] ,row[0][3]);
                    },

                    fnRowDeselected: function ( node ) {
                        $('#interpreteur').val("");
                        addInterpreteur(null,"Aucun","Aucun");
                    }
                },"columnDefs":
                        [ { "visible": false, "searchable": false, "targets":0 }]

            });

            table2 = $('#dataTables-example2').DataTable({
                "pageLength": 10,
                dom: 'T<"clear">lfrtip',
                tableTools: {
                    "sRowSelect": "single",
                    fnRowSelected: function(nodes) {
                        var ttInstance = TableTools.fnGetInstance("dataTables-example2");
                        var row = ttInstance.fnGetSelectedData();
                        $('#interpreteur').val(row[0][0]);
                        addInterpreteur(row[0][0],row[0][1] + row[0][2] ,row[0][3]);
                    },

                    fnRowDeselected: function ( node ) {
                        $('#interpreteur').val("");
                        addInterpreteur(null,"Aucun","Aucun");
                    }
                },"columnDefs":
                        [ { "visible": false, "searchable": false, "targets":0 }]

            });

            // Setup - add a text input to each footer cell
            $('#dataTables-example tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
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
        });

    </script>

    <script>
        var map;
        var mapDiv;
    </script>

    <script type="text/javascript">

        function addInterpreteur(id,nom,email){
            $("#interpreteur").val(id);
            $("#nomInter").text(nom);
            $("#emailInter").text(email);
            if(nom != "Aucun"){
                alert("Interpreteur ajouté avec sucess");
            }
        }

        function initMarkersAndWindows(){
            @foreach($interpreteurs as $interpreteur)
                    markers[{{$interpreteur->id}}] = new google.maps.Marker({
                position: {lat: {{ $interpreteur->adresse->lat }}, lng: {{ $interpreteur->adresse->long }} },
                map: map,
                title:  '{{ $interpreteur->nom }} {{ $interpreteur->prenom }}'
            });
            infowindows[{{$interpreteur->id}}] = new google.maps.InfoWindow({
                content:
                        '\
                        <div class="container" style="width:300px">\
                          <div class="row">\
                            <img class="img-circle" src="/images/{{$interpreteur->image}}" style="width: 50px;height:50px;">\
                          </div>\
                          <div class="row">\
                            <div class="col-lg-3"><strong>Nom</strong></div>\
                            <div class="col-lg-9">{{ $interpreteur->nom }}</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Prenom</strong></div>\
  <div class="col-lg-9">{{ $interpreteur->prenom }}</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>email</strong></div>\
  <div class="col-lg-9">{{ $interpreteur->email }}</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Portable</strong></div>\
  <div class="col-lg-9">{{ $interpreteur->tel_portable }}</div>\
</div>\
<div class="row">\
  <div class="col-lg-3"><strong>Fixe</strong></div>\
  <div class="col-lg-9">{{ $interpreteur->tel_fixe }}</div>\
</div>\
<div class="row">\
  <div class="col-lg-8"></div>\
  <div class="col-lg-4"><button type="button" onclick="addInterpreteur({{ $interpreteur->id }},\'{{$interpreteur->nom}} {{$interpreteur->prenom}}\',\'{{$interpreteur->email}}\')" class="btn btn-primary">Select</button></div>\
</div>\
</div>'
            });


            markers[{{$interpreteur->id}}].addListener('click', function() {
                infowindows[{{$interpreteur->id}}].open(map, markers[{{$interpreteur->id}}]);
            });
            @endforeach


            google.maps.event.addListenerOnce(map, 'idle', function() {
                google.maps.event.trigger(map, 'resize');
            });

            $('#dataTables-example2').on('search.dt',function(){

                table2.rows().eq(0).each( function ( index ) {
                    var row = table.row( index );
                    markers[row.data()[0]].setVisible(false);
                } );

                table2.rows({filter:'applied'}).eq(0).each( function ( index ) {
                    var row = table.row( index );
                    markers[row.data()[0]].setVisible(true);
                } );
            });
        }

        function createMap(){
            var demandeLG = {lat: {{$demande->adresse->lat}}, lng: {{$demande->adresse->long}} };
            mapDiv = document.getElementById('map');
            map = new google.maps.Map(mapDiv, {
                center: demandeLG,
                zoom: 8
            });
            var image = "{{{ asset('images/marker.png') }}}";
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