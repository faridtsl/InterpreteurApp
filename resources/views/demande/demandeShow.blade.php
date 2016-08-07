@extends('layouts.layout')


@section('header')
    <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}" />
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style type="text/css"> .pac-container { z-index: 1051 !important; } </style>
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Liste des demandes
@endsection


@section('content')
    <div class="container-fluid">
        <div class="searchDiv row" style="margin-bottom: 30px;margin-top: 20px">
            <a href="#search" data-toggle="collapse">+ Recherche avancée</a>
            <div id="search" class="row collapse">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <h3 class="col-lg-4">Recherche avancée</h3>
                        </div>
                    </div>
                    <form role="form" method="POST" action="/demande/list" id="formID" enctype="multipart/form-data" class="col-lg-10 col-lg-offset-1">
                        {!! csrf_field() !!}
                        <div class="container-fluid">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="row"></div>
                                        <label>Date de l'evenement:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Debut:</label>
                                        <div class="input-group date" >
                                            <input class="form-control" name="dateEventDeb" id="dateEventDeb" placeholder="Date min">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fin:</label>
                                        <div class="input-group date" >
                                            <input class="form-control" name="dateEventFin" id="dateEventFin" placeholder="Date max">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <span></span>
                                        <label>Date de la creation:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Debut:</label>
                                        <div class="input-group date" >
                                            <input class="form-control" name="dateCreateDeb" id="dateCreateDeb" placeholder="Date min">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fin:</label>
                                        <div class="input-group date" >
                                            <input class="form-control" name="dateCreateFin" id="dateCreateFin" placeholder="Date max">
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
                                <input type="submit" value="Recherche" class="btn btn-info"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">
                            Liste des demandes
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse">
                    <div class="panel-body">
                        <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Etat</th>
                                    <th>Client</th>
                                    <th>Date Creation</th>
                                    <th>Date de Modification</th>
                                    <th>Date Debut</th>
                                    <th>Date Fin</th>
                                    <th>Langue Initiale</th>
                                    <th>Langue Destination</th>
                                    <th>Adresse de l'evenement</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Titre</th>
                                    <th>Etat</th>
                                    <th>Client</th>
                                    <th>Date Creation</th>
                                    <th>Date de Modification</th>
                                    <th>Date Debut</th>
                                    <th>Date Fin</th>
                                    <th>Langue Initiale</th>
                                    <th>Langue Destination</th>
                                    <th>Adresse de l'evenement</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @foreach($demandes as $demande)
                                @if(\App\Tools\DemandeTools::tempsRestant($demande)>=0)
                                <tr class="@if(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_DANGER_DELAI','0')) danger @elseif(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_WAR_DELAI','0')) warning @endif">
                                    <td>{{$demande->titre}}</td>
                                    <td>{{\App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</td>
                                    <td>{{\App\Tools\ClientTools::getClient($demande->client_id)->nom}} {{\App\Tools\ClientTools::getClient($demande->client_id)->prenom}}</td>
                                    <td>{{\Carbon\Carbon::parse($demande->created_at)->format('l j F Y H:i')}}</td>
                                    <td>{{\Carbon\Carbon::parse($demande->updated_at)->format('l j F Y H:i')}}</td>
                                    <td>{{\Carbon\Carbon::parse($demande->dateEvent)->format('l j F Y H:i')}}</td>
                                    <td>{{\Carbon\Carbon::parse($demande->dateEndEvent)->format('l j F Y H:i')}}</td>
                                    <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->source)->content}}</td>
                                    <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->cible)->content}}</td>
                                    <td>{{ \App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</td>
                                    <td>
                                        <p>
                                            <a data-placement="top" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs editButton" href="/demande/update?id={{$demande->id}}" >
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <button data-placement="top" data-toggle="tooltip" title="View" class="btn btn-success btn-xs seeButton" data-id="{{$demande->id}}" >
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                            <a data-placement="top" data-toggle="tooltip" title="Duplicate" class="btn btn-info btn-xs dupButton" href="/demande/duplicate?id={{$demande->id}}" >
                                                <span class="glyphicon glyphicon-copy"></span>
                                            </a>
                                            <a data-placement="top" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs delButton"  data-toggle="modal" data-target="#delete" data-id="{{$demande->id}}" >
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse2">
                            Demandes expirées
                        </a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse">
                    <div class="panel-body">
                        <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Etat</th>
                                <th>Client</th>
                                <th>Date Creation</th>
                                <th>Date de Modification</th>
                                <th>Date Debut</th>
                                <th>Date Fin</th>
                                <th>Langue Initiale</th>
                                <th>Langue Destination</th>
                                <th>Adresse de l'evenement</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Titre</th>
                                <th>Etat</th>
                                <th>Client</th>
                                <th>Date Creation</th>
                                <th>Date de Modification</th>
                                <th>Date Debut</th>
                                <th>Date Fin</th>
                                <th>Langue Initiale</th>
                                <th>Langue Destination</th>
                                <th>Adresse de l'evenement</th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($demandes as $demande)
                                @if(\App\Tools\DemandeTools::tempsRestant($demande)<0)
                                    <tr class="@if(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_DANGER_DELAI','0')) danger @elseif(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_WAR_DELAI','0')) warning @endif">
                                        <td>{{$demande->titre}}</td>
                                        <td>{{\App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</td>
                                        <td>{{\App\Tools\ClientTools::getClient($demande->client_id)->nom}} {{\App\Tools\ClientTools::getClient($demande->client_id)->prenom}}</td>
                                        <td>{{\Carbon\Carbon::parse($demande->created_at)->format('l j F Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::parse($demande->updated_at)->format('l j F Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::parse($demande->dateEvent)->format('l j F Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::parse($demande->dateEndEvent)->format('l j F Y H:i')}}</td>
                                        <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->source)->content}}</td>
                                        <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->cible)->content}}</td>
                                        <td>{{ \App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</td>
                                        <td>
                                            <p>
                                                <a data-placement="top" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs editButton" href="/demande/update?id={{$demande->id}}" >
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                                <button data-placement="top" data-toggle="tooltip" title="View" class="btn btn-success btn-xs seeButton" data-id="{{$demande->id}}" >
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                                <a data-placement="top" data-toggle="tooltip" title="Duplicate" class="btn btn-info btn-xs dupButton" href="/demande/duplicate?id={{$demande->id}}" >
                                                    <span class="glyphicon glyphicon-copy"></span>
                                                </a>
                                                <a data-placement="top" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs delButton"  data-toggle="modal" data-target="#delete" data-id="{{$demande->id}}" >
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('modals')
    @include('includes.popups')

    <!--Suppression popup-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" id="headDelete"></h4>
                </div>
                <form id="deleteForm" action="delete" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="-1" id="idDel" name="id" />
                        </div>
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir supprimer?</div>
                    </div>
                    <div class="modal-footer ">
                        <input class="btn btn-success" value="Oui" type="submit"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection


@section('footer')

    <script>
        @if (count($errors) > 0)
            $('#errorModal').modal('show');
        @endif

        @if(session()->has('message') != null)
                $("#modalSuccess").modal('toggle');
        @endif
        </script>
        <script src="{{ asset("js/demandeJS.js") }}"> </script>
        <script src="{{ asset("js/timeInitiator.js") }}"> </script>

    @endsection