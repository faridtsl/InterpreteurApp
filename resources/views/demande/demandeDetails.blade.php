@extends('layouts.layout')


@section('title')
    Details de la demande
@endsection

@section('header')
    <script type="text/javascript"
            src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}"/>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/success.css')}}"/>
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
    <meta name="_token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
    <style type="text/css">
        .pac-container {
            z-index: 1051 !important;
        }

        .modal-dialog {
            width: 80%;
            height: 100%;
            padding: 20px;
        }
    </style>

@endsection

@section('content')

    <div class="container-fluid" style="margin-top: 30px">
        <div class="col-lg-12">
            <div class="panel-group" id="accordion">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#demandePanel">Informations
                                demande</a>
                        </h4>
                    </div>
                    <div class="panel-body panel-collapse collapse" id="demandePanel">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3 lab">
                                            <label>Titre de la demande : </label>
                                        </div>
                                        <div class="col-lg-3 par">
                                            <span class="displayClass">{{$demande->titre}}</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <span class="label label-{{\App\Tools\EtatTools::getClassById($demande->etat_id)}} displayClass">{{\App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-lg-6 lab">
                                        <label>Date de debut : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        <span class="displayClass">{{\Carbon\Carbon::parse($demande->dateEvent)->format('l j F Y H:i')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-6 lab">
                                        <label>Date de fin : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        <span class="displayClass">{{\Carbon\Carbon::parse($demande->dateEndEvent)->format('l j F Y H:i')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-lg-6 lab">
                                        <label>Date de creation : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        <span class="displayClass">{{\Carbon\Carbon::parse($demande->created_at)->format('l j F Y H:i')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-6 lab">
                                        <label>Date d'archivage : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        <span class="displayClass">{{\Carbon\Carbon::parse($demande->deleted_at)->format('l j F Y H:i')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label>Contenu de la demande : </label>
                                <textarea class="form-control ckeditor" id="content" rows="10"
                                          name="content">{{ $demande->content }}</textarea>
                                <p class="help-block editClass">Saisir le contenu de la demande.</p>
                            </div>
                            <button class="btn btn-warning" id="modifTrad" data-title="Edit" data-toggle="modal"
                                    data-target="#editTraductions" data-id="{{$demande->id}}">
                                Voir Traductions <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#clientPanel">Demandeur</a>
                        </h4>
                    </div>
                    <div id="clientPanel" class="panel-body panel-collapse collapse">
                        <div class="row">
                            <div class="col-lg-2">
                                <img class="img-circle" src="/images/{{$client->image}}"
                                     style="width: 100px;height:100px;">
                            </div>
                            <div class="col-lg-9">
                                <h3>
                                    {{$client->nom}} {{$client->prenom}}
                                </h3>
                                <span class="glyphicon glyphicon-phone-alt"> {{$client->tel_portable}} </span><br/>
                                <span class="glyphicon glyphicon-earphone"> {{$client->tel_fixe}}</span><br/>
                                <span class="glyphicon glyphicon-globe"> {{$client->email}}</span><br/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#adrPanel">Adresse de
                                l'evenement</a>
                        </h4>
                    </div>
                    <div id="adrPanel" class="panel-body panel-collapse collapse">
                        <div class="container-fluid" id="formAdr">
                            @include('includes.adresseForm')
                        </div>
                    </div>
                </div>


                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#archDevisPanel">Liste des archives devis</a>
                        </h4>
                    </div>
                    <div id="archDevisPanel" class="panel-body panel-collapse collapse">
                        <table class="table table-striped table-bordered table-hover responsive" width="90%" id="archiveDevisTable"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th width="20px">Etat</th>
                                <th width="20px">Prix proposé</th>
                                <th width="40px">Show</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Etat</th>
                                <th>Prix proposé</th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach(\App\Tools\DevisTools::getArchiveDevisByDemander($demande->id) as $devi)
                                <tr>
                                    <td>{{\App\Tools\DevisEtatTools::getEtatById($devi->etat_id)->libelle}}</td>
                                    <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                                    <td>
                                        <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span
                                                    class="glyphicon glyphicon-eye-open"></span> </a>
                                        /<a href="/devis/download?id={{$devi->id}}" class="downloadButton"> <span
                                                    class="glyphicon glyphicon-download-alt"></span> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#archFactPanel">Archive Factures</a>
                        </h4>
                    </div>
                    <div id="archFactPanel" class="panel-body panel-collapse">
                        <table id="archiveFact" class="table table-striped table-bordered display responsive nowrap"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th class="never">id</th>
                                <th>Nom du client</th>
                                <th>Date d'envoi</th>
                                <th>Date de paiement</th>
                                <th>Total</th>
                                <th>Date d'archivage</th>
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
                                <th>Date d'archivage</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($archiveFactures as $facture)
                                <tr>
                                    <td>{{$facture->id}}</td>
                                    <td>{{\App\Tools\ClientTools::getClientByFacture($facture)->nom}} {{\App\Tools\ClientTools::getClientByFacture($facture)->prenom}}</td>
                                    <td>{{$facture->date_envoi_mail}}</td>
                                    <td>@if($facture->fini){{$facture->date_paiement}}@else Non Payée @endif</td>
                                    <td>{{\App\Tools\DevisTools::getDevisById($facture->devi_id)->total}} &euro;</td>
                                    <td>{{$facture->deleted_at}}</td>
                                    <td>
                                        <a href="/devis/view?id={{$facture->devi_id}}" class="viewButton"> <span
                                                    class="glyphicon glyphicon-eye-open"></span> </a>
                                        /<a href="/facture/download?id={{$facture->devi_id}}" class="downloadButton">
                                            <span class="glyphicon glyphicon-download-alt"></span> </a>
                                    </td>
                                    <td>
                                        <a href="/facture/view?id={{$facture->id}}" class="viewButton"> <span
                                                    class="glyphicon glyphicon-eye-open"></span> </a>
                                        /<a href="/facture/download?id={{$facture->id}}" class="downloadButton"> <span
                                                    class="glyphicon glyphicon-download-alt"></span> </a>
                                    </td>
                                </tr>


                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $("#validate{{$facture->id}}").popConfirm({
                                            title: "Message de confirmation ?",
                                            content: "Voulez-vous déclarer le paiement de la facture en cours ?",
                                            placement: "bottom"
                                        });
                                    });
                                </script>
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


    <div class="modal fade" id="editTraductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  modal-header-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Liste des Traductions</h4>
                </div>
                <input type="hidden" value="{{$demande->id}}" name="idD" id="id"/>
                <div class="modal-body">
                    <div class="container-fluid">
                        <h3> Traductions</h3>
                        <div class="row container-fluid">
                            <table id="oldLangs">
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('includes.popups')



    <div class="modal fade" id="resendModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span>
                    </button>
                    <h4 class="modal-title custom_align">Renvoi devis</h4>
                </div>
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de
                    vouloir renvoyer le devis?
                </div>
                <div class="modal-footer ">
                    <input id="idResend" type="hidden" value="-1"/>
                    <button class="btn btn-success" id="resend">Oui</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <script src="{{ asset("js/tableTools.js") }}"></script>
    <script src="{{ asset("js/demandeDetails.js") }}"></script>
    <script src="{{ asset("js/mapsJS.js") }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset("js/timeInitiator.js") }}"></script>

@endsection
