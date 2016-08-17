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
        <h1 class="center"> Liste des factures </h1>
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
                <th>Resend</th>
                <th>Show Devis</th>
                <th>Show</th>
                <th>Payer</th>
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
                        <a href="home" id="resend{{$facture->id}}" data-id="{{$facture->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                    </td>
                    <td>
                        <a href="/devis/view?id={{$facture->devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
                    <td>
                        <a href="/facture/view?id={{$facture->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
                    <td>@if(!$facture->fini)<a id="validate{{$facture->id}}" href="/facture/validate?id={{$facture->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a>@endif</td>
                </tr>


                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#validate{{$facture->id}}").popConfirm({
                            title: "Message de confirmation ?",
                            content: "Voulez vous Valider le devis en cours !",
                            placement: "bottom"
                        });
                    });
                </script>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('modals')
    @include('includes.popups')

    <div class="modal fade" id="resendModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" >Renvoi facture</h4>
                </div>
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir renvoyer la facture?</div>
                <div class="modal-footer ">
                    <input id="idResend" type="hidden" value="-1"/>
                    <button class="btn btn-success" id="resend" >Oui</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/factureShow.js") }}"> </script>
@endsection