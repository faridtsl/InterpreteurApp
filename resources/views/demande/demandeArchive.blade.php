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

        <div class="row">
            <h1 class="center"> Archive des demandes </h1>
        </div>

        <div class="row">
            <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Etat</th>
                    <th>Date Creation</th>
                    <th>Date de Modification</th>
                    <th>Date de Suppression</th>
                    <th>Date Debut</th>
                    <th>Date Fin</th>
                    <th>Adresse de l'evenement</th>
                    <th>Traductions</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Titre</th>
                    <th>Etat</th>
                    <th>Date Creation</th>
                    <th>Date de Modification</th>
                    <th>Date de Suppression</th>
                    <th>Date Debut</th>
                    <th>Date Fin</th>
                    <th>Adresse de l'evenement</th>
                    <th>Traductions</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('modals')
    @include('includes.popups')
@endsection


@section('footer')

    <script>
        @if (count($errors) > 0)
            $('#errorModal').modal('show');
        @endif

        @if (isset($message))
            $("#modalSuccess").modal('toggle');
        @endif
    </script>
    <script src="{{ asset("js/demandeArchive.js") }}"> </script>
    <script src="{{ asset("js/timeInitiator.js") }}"> </script>

@endsection