@extends('layouts.layout')


@section('title')
    Modifier la demande
@endsection

@section('header')

    <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}" />
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>

@endsection

@section('content')

<div class="container-fluid" style="margin-top: 30px">
    <form role="form" method="POST" action="/demande/update">
        {!! csrf_field() !!}
        <input type="hidden" value="{{$demande->id}}" name="id"/>
        <input type="hidden" value="{{$demande->client_id}}" id="client" name="client"/>
        <div class="col-lg-12">
            <div class="panel panel-info" id="demandePanel">
                <div class="panel-heading">
                    Informations demande
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 lab">
                                <label>Titre de la demande : </label>
                            </div>
                            <div class="col-lg-3">
                                <span class="displayClass">{{$demande->titre}}</span>
                                <a href="#" class="editChamps"><span class="glyphicon glyphicon-pencil"></span></a>
                                <input class="form-control editClass" name="titre" value="{{ $demande->titre }}" placeholder="Saisir l'objet de la demande.">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="col-lg-6 lab">
                                    <label>Date de debut : </label>
                                </div>
                                <div class="col-lg-6">
                                    <span class="displayClass">{{$demande->dateEvent}}</span>
                                    <a href="#" class="editChamps"><span class="glyphicon glyphicon-pencil"></span></a>

                                    <div class="input-group date editClass" >
                                        <input type="text" name="dateEvent" id="date-start" class="form-control" value="{{ $demande->dateEvent }}" placeholder="Date de debut">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-6 lab">
                                    <label>Date de fin : </label>
                                </div>
                                <div class="col-lg-6">
                                    <span class="displayClass">{{$demande->dateEndEvent}}</span>
                                    <a href="#" class="editChamps"><span class="glyphicon glyphicon-pencil"></span></a>

                                    <div class="input-group date editClass" >
                                        <input type="text" name="dateEndEvent" id="date-end" class="form-control" value="{{ $demande->dateEndEvent }}" placeholder="Date de fin">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="col-lg-6 lab">
                                        <label>Langue initiale : </label>
                                    </div>
                                    <div class="col-lg-6">
                                        @foreach($langues as $langue)
                                            @if($langue->id == $traduction->source)
                                                <span class="displayClass">{{$langue->content}}</span>
                                                <a href="#" class="editChamps"><span class="glyphicon glyphicon-pencil"></span></a>
                                            @endif
                                        @endforeach
                                        <select class="form-control editClass" name="langue_src">
                                            <option value="" disabled selected>Langue source</option>
                                            @foreach($langues as $langue)
                                                @if($langue->id == $traduction->source)
                                                    <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                @else
                                                    <option value="{{$langue->id}}">{{$langue->content}}</option>

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group lab">
                                    <div class="col-lg-6">
                                        <label>Langue destination : </label>
                                    </div>
                                    <div class="col-lg-6">
                                        @foreach($langues as $langue)
                                            @if($langue->id == $traduction->cible)
                                                <span class="displayClass">{{$langue->content}}</span>
                                                <a href="#" class="editChamps"><span class="glyphicon glyphicon-pencil"></span></a>
                                            @endif
                                        @endforeach
                                        <select class="form-control editClass" name="langue_dest">
                                            <option value="" disabled selected>Langue destination</option>
                                            @foreach($langues as $langue)
                                                @if($langue->id == $traduction->cible)
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
                    </div>
                    <div class="form-group">
                        <label>Contenu de la demande : </label>
                        <textarea class="form-control ckeditor editClass" id="content" rows="10" name="content">{{ $demande->content }}</textarea>
                        <p class="help-block editClass">Saisir le contenu de la demande.</p>
                    </div>
                    <button class="btn btn-outline btn-primary" id="toggleCli">Enregistrer les modifications</button>
                </div>
            </div>
        </div>

        <div class="col-lg-12">

            <div class="panel panel-info" id="devisPanel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Demandeur
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-lg-2">

                                <img class="img-circle" src="/images/{{$client->image}}" style="width: 100px;height:100px;">
                            </div>
                            <div class="col-lg-9">
                                <h3>
                                    {{$client->nom}} {{$client->prenom}}
                                    <a href="#" class="toggle" data-title="client" data-toggle="modal" data-target="#clientModal" data-id="{{$demande->client_id}}" ><span class="glyphicon glyphicon-pencil"></span></a>
                                </h3>
                                <span class="glyphicon glyphicon-phone-alt"> {{$client->tel_portable}} </span><br/>
                                <span class="glyphicon glyphicon-earphone"> {{$client->tel_fixe}}</span><br/>
                                <span class="glyphicon glyphicon-globe"> {{$client->email}}</span><br/>
                                <a href="#" class="toggle" data-title="client" data-toggle="modal" data-target="#clientModal" data-id="{{$demande->client_id}}" >
                                    <span class="glyphicon glyphicon-map-marker"> {{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}} </span>
                                </a><br/>
                            </div>
                        </div>
                </div>
            </div>

            <div class="panel panel-info" id="devisPanel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Liste des devis
                    </h4>
                </div>
                <div class="panel-body">

                </div>
            </div>
            <div class="panel panel-info" id="factPanel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Facturation
                    </h4>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </form>
</div>
@endsection


@section('modals')

    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header  modal-header-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Liste des Clients</h4>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header  modal-header-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Liste des Clients</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <h3> Adresse</h3>
                        @include('includes.adresseForm')
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
@endsection

@section('footer')

    <script src="{{ asset("js/demandeUpdate.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS3tOh8NpT_5A_-P2-Oz2HqAhEf5h4uSs&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset("js/timeInitiator.js") }}"> </script>

@endsection