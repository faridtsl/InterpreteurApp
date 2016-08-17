@extends('layouts.layout')

@section('title')
    La liste des factures
@endsection

@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('content')


    <div class="row">
        <h1 class="center"> Archive des factures </h1>
    </div>

    <div class="row">
        <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
            <thead>
            <tr>
                <th class="never">id</th>
                <th>Nom du client</th>
                <th>Date d'envoi</th>
                <th>Date de paiement</th>
                <th>Total</th>
                <th>Show Devis</th>
                <th>Show</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th class="never">id</th>
                <th>Nom du client</th>
                <th>Date d'envoi</th>
                <th>Date de paiement</th>
                <th>Total</th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($factures as $facture)

                <tr>
                    <td>{{$facture->id}}</td>
                    <td>{{\App\Tools\ClientTools::getClientByFacture($facture)->nom}} {{\App\Tools\ClientTools::getClientByFacture($facture)->prenom}}</td>
                    <td>{{$facture->date_envoi_mail}}</td>
                    <td>@if($facture->fini){{$facture->date_paiement}}@else Non Payée @endif</td>
                    <td>{{\App\Tools\DevisTools::getDevisById($facture->devi_id)->total}} &euro;</td>
                    <td>
                        <a href="/devis/view?id={{$facture->devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
                    <td>
                        <a href="/facture/view?id={{$facture->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
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
    <script src="{{ asset("js/factureShow.js") }}"> </script>
@endsection