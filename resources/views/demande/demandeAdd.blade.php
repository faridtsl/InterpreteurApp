@extends('layouts.layout')


@section('header')
    <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}" />
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
@endsection

@section('title')
Ajouter demande
@endsection

@section('content')

    <hr>
    <form role="form" method="POST" action="/demande/add">
                {!! csrf_field() !!}
                <div class="col-lg-12">
                    <div class="panel panel-info" id="demandePanel">
                        <div class="panel-heading" id="headDem">
                            Nouvelle demande
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Titre de la demande</label>
                                <input class="form-control" name="titre" value="{{ old('titre') }}" placeholder="Saisir l'objet de la demande.">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Date de debut</label>
                                        <div class="input-group date" >
                                            <input type="text" name="dateEvent" id="date-start" class="form-control floating-label" value="{{ old('dateEvent') }}" placeholder="Date de debut">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Date de fin</label>
                                        <div class="input-group date" >
                                            <input type="text" name="dateEndEvent" id="date-end" class="form-control floating-label" value="{{ old('dateEndEvent') }}" placeholder="Date de fin">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Langue initiale : </label>
                                            <select class="form-control" name="langue_src">
                                                <option value="" disabled selected>Langue source</option>
                                                @foreach($langues as $langue)
                                                    @if($langue->id == old('langue_src'))
                                                        <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                    @else
                                                        <option value="{{$langue->id}}">{{$langue->content}}</option>

                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Langue destination : </label>
                                            <select class="form-control" name="langue_dest">
                                                <option value="" disabled selected>Langue destination</option>
                                                @foreach($langues as $langue)
                                                    @if($langue->id == old('langue_dest'))
                                                        <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                    @else
                                                        <option value="{{$langue->id}}">{{$langue->content}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Contenu de la demande</label>
                                <textarea class="form-control ckeditor" id="content" rows="10" name="content">{{ old('content') }}</textarea>
                                <p class="help-block">Saisir le contenu de la demande.</p>
                            </div>
                            <button class="btn btn-outline btn-primary" id="toggleCli">Ajouter client</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-info" id="clientPanel">
                        <div class="panel-heading">
                            <h4 class="panel-title" id="headCli">
                                Liste des clients
                            </h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>E-MAIL</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>id</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>E-MAIL</th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->nom}}</td>
                                        <td>{{$client->prenom}}</td>
                                        <td>{{$client->email}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <input type="hidden" name="client" value="-1" id="client">
                            <button class="btn btn-outline btn-primary" id="toggleAdr">Ajouter adresse</button>
                            <button class="btn btn-warning" id="returnDem">Return</button>
                        </div>
                    </div>
                    <div class="panel panel-info" id="adrPanel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                L'adresse de la demande
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                @include('includes.adresseForm')
                            </div>
                            <button type="submit" class="btn btn-outline btn-primary">Ajouter</button>
                            <button class="btn btn-warning" id="returnCli">Return</button>
                            <button type="reset" class="btn btn-danger">Supprimer</button>
                        </div>
                    </div>
                </div>
    </form>

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
    <div class="modal fade" id="sucess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Nouvelle demande ajoutée</h4>
                </div>
                <div class="modal-body">

                    @if(isset($message))
                        <dl>
                            <dt>{{$message}}</dt>
                            <dd>{{$demande->created_at}}</dd>
                            <dt>Titre :</dt>
                            <dd>{{$demande->titre}}</dd>
                            <dt>Date de l'evenement :</dt>
                            <dd>{{$demande->dateEvent}}</dd>
                            <dt>Demandeur :</dt>
                            <dd>{{$client->nom}} {{$client->prenom}}</dd>
                            <dt><a href="/demande/edit/{{$demande->id}}">Edit</a></dt>
                        </dl>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('footer')

    <script src="{{ asset('js/tableTools.js')}}"></script>

    <script>
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

    </script>


    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#errorModal').modal('show');
        @endif
    </script>

    @if(isset($message))
        <script type="text/javascript">
            $('#sucess').modal('show');
        </script>
    @endif

    <script src="{{ asset("js/myScript.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS3tOh8NpT_5A_-P2-Oz2HqAhEf5h4uSs&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset("js/timeInitiator.js") }}"> </script>

@endsection


