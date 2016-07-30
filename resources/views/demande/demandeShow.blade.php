@extends('layouts.layout')


@section('header')
    <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}" />
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <style type="text/css"> .pac-container { z-index: 1051 !important; } </style>
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
                    <form role="form" method="POST" action="/demande/show" id="formID" enctype="multipart/form-data" class="col-lg-10 col-lg-offset-1">
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
            <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Etat</th>
                        <th>Client</th>
                        <th>Date Creation</th>
                        <th>Langue Initiale</th>
                        <th>Langue Destination</th>
                        <th>Action</th>
                        <th>Contenu</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Titre</th>
                        <th>Etat</th>
                        <th>Client</th>
                        <th>Date Creation</th>
                        <th>Langue Initiale</th>
                        <th>Langue Destination</th>
                        <th>Action</th>
                        <th>Contenu</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($demandes as $demande)
                    <tr>
                        <th>{{$demande->titre}}</th>
                        <th>{{\App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</th>
                        <th>{{\App\Tools\ClientTools::getClient($demande->client_id)->nom}}</th>
                        <th>{{$demande->created_at}}</th>
                        <th>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->source)->content}}</th>
                        <th>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->cible)->content}}</th>
                        <th>Action</th>
                        <th>{{$demande->content}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection




@section('footer')
    <script src="{{ asset("js/demandeJS.js") }}"> </script>
    <script src="{{ asset("js/timeInitiator.js") }}"> </script>
@endsection