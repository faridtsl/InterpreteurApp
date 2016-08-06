@extends('layouts.layout')

@section('title')
    La liste des devis
@endsection

@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
@endsection

@section('content')


<div class="row">
    <h1 class="center"> Liste des devis </h1>
</div>

<div class="row">
    <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="never">id</th>
                <th>Nom de l'interpreteur</th>
                <th>Adresse de l'interpreteur</th>
                <th>Prix proposé</th>
                <th>Resend</th>
                <th>View</th>
                <th>Edit/Delete</th>
                <th>Valider</th>
                <th>Demande</th>
                <th>Client</th>
                <th>Date creation du devis</th>
                <th>Date modification du devis</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>id</th>
                <th>Nom de l'interpreteur</th>
                <th>Adresse de l'interpreteur</th>
                <th>Prix proposé</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Demande</th>
                <th>Client</th>
                <th>Date creation du devis</th>
                <th>Date modification du devis</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach($devis as $devi)
                <tr>
                    <td>{{$devi->id}}</td>
                    <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                    <td>{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                    <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                    <td>
                        <a href="home" data-id="{{$devi->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                    </td>
                    <td>
                        <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
                    <td>
                        <a href="/devis/edit?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a>
                        /
                        <a id="delete{{$devi->id}}" href="/devis/remove?id={{$devi->id}}" class="editor_remove"><span class="glyphicon glyphicon-trash" ></span></a>
                    </td>
                    <td><a id="validate{{$devi->id}}" href="/devis/validate?id={{$devi->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                    <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                    <td><a href="/client/profile?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id}}">{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->nom}} {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->prenom}}</a></td>
                    <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                    <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('modals')
    @include('includes.popups')
@endsection

@section('footer')
    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/devisShow.js") }}"> </script>
@endsection