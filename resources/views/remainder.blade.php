@extends('layouts.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('title')
    Remainders
@endsection

@section('content')

    <div class="row">
        <h1 class="center"> Remainder </h1>
        <hr>
    </div>

    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#demandePanel">
                        Liste des demandes <cite class="text-danger">(evenement dans {{env('REMAINDER_DELAI_FACTURE','0')}} jours ou moins )</cite>  <span class="badge">{{count($demandes->filter(function($demande){return \App\Tools\DemandeTools::tempsRestant($demande)<=env('REMAINDER_DELAI_DEMANDE','0') && \App\Tools\DemandeTools::tempsRestant($demande)>=0;}))}}</span>
                    </a>
                </h4>
            </div>
            <div id="demandePanel" class="panel-collapse panel-body">
                <table id="example1" class="table table-striped table-bordered display responsive nowrap" cellspacing="0" width="100%">
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
                        @if(\App\Tools\DemandeTools::tempsRestant($demande)<=env('REMAINDER_DELAI_DEMANDE','0') && \App\Tools\DemandeTools::tempsRestant($demande)>=0)
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
                                <td width="100px">{{ \App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</td>
                                <td>
                                    <p>
                                        <a data-placement="top" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs" href="/demande/update?id={{$demande->id}}" >
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <button data-placement="top" data-toggle="tooltip" title="View" class="btn btn-success btn-xs seeButton" data-id="{{$demande->id}}" >
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                        <a data-placement="top" data-toggle="tooltip" title="Duplicate" class="btn btn-info btn-xs dupButton" href="/demande/duplicate?id={{$demande->id}}" >
                                            <span class="glyphicon glyphicon-copy"></span>
                                        </a>
                                        <a data-placement="top" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs delButtonDem"  data-toggle="modal" data-target="#delete" data-id="{{$demande->id}}" >
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
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#commandePanel">Commandes expirées <cite class="text-danger">(Commandes des événements expirés)</cite>  <span class="badge">{{count($devis->filter(function($devi) {return $devi->etat_id == 2 && \App\Tools\DevisTools::tempsRestantFinEvent($devi) <= 0;}))}}</span></a>
                </h4>
            </div>
            <div id="commandePanel"  class="panel-body panel-collapse">
                <table id="example2" class="table table-striped table-bordered display responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="never">id</th>
                        <th>Nom de l'interpreteur</th>
                        <th>Prix proposé</th>
                        <th>Demande</th>
                        <th>Client</th>
                        <th>Date creation du devis</th>
                        <th>Date modification du devis</th>
                        <th>Adresse de l'interpreteur</th>
                        <th>Resend</th>
                        <th>View</th>
                        <th>Edit/Delete</th>
                        <th>Reserver</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Nom de l'interpreteur</th>
                        <th>Prix proposé</th>
                        <th>Demande</th>
                        <th>Client</th>
                        <th>Date creation du devis</th>
                        <th>Date modification du devis</th>
                        <th>Adresse de l'interpreteur</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($devis as $devi)
                        @if($devi->etat_id == 2 && \App\Tools\DevisTools::tempsRestantFinEvent($devi) <= 0)
                            <tr>
                                <td>{{$devi->id}}</td>
                                <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                                <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                                <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                                <td><a href="/client/profile?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id}}">{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->nom}} {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->prenom}}</a></td>
                                <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                                <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
                                <td width="100px">{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                                <td>
                                    <a id="resend{{$devi->id}}" data-id="{{$devi->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                                </td>
                                <td>
                                    <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                                    /<a href="/devis/download?id={{$devi->id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>
                                </td>
                                <td>
                                    <a href="/devis/update?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    /
                                    <a id="delete{{$devi->id}}" data-id="{{$devi->id}}" class="editor_remove"><span class="glyphicon glyphicon-trash" ></span></a>
                                </td>
                                <td><a id="validate{{$devi->id}}" href="/devis/validate?id={{$devi->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                            </tr>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#delete{{$devi->id}}").popConfirm({
                                        title: "Message de confirmation ?",
                                        content: "Voulez vous supprimer l'objet !",
                                        placement: "bottom"
                                    });

                                    $("#validate{{$devi->id}}").popConfirm({
                                        title: "Message de confirmation ?",
                                        content: "Voulez vous Facturer la commande en cours !",
                                        placement: "bottom"
                                    });
                                });
                            </script>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#devisPanel">Devis en attente <cite class="text-danger">(reste {{env('REMAINDER_DELAI_DEVIS','0')}} jours ou moins)</cite>  <span class="badge">{{count($devis->filter(function($devi) {return $devi->etat_id == 1 && \App\Tools\DevisTools::tempsRestant($devi) <= env('REMAINDER_DELAI_DEVIS','0');}))}}</span></a>
                </h4>
            </div>
            <div id="devisPanel"  class="panel-body panel-collapse">
                <table id="example3" class="table table-striped table-bordered display responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="never">id</th>
                        <th>Nom de l'interpreteur</th>
                        <th>Prix proposé</th>
                        <th>Demande</th>
                        <th>Client</th>
                        <th>Date creation du devis</th>
                        <th>Date modification du devis</th>
                        <th>Adresse de l'interpreteur</th>
                        <th>Resend</th>
                        <th>View</th>
                        <th>Edit/Delete</th>
                        <th>Reserver</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Nom de l'interpreteur</th>
                        <th>Prix proposé</th>
                        <th>Demande</th>
                        <th>Client</th>
                        <th>Date creation du devis</th>
                        <th>Date modification du devis</th>
                        <th>Adresse de l'interpreteur</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($devis as $devi)
                        @if($devi->etat_id == 1 && \App\Tools\DevisTools::tempsRestant($devi) <= env('REMAINDER_DELAI_DEVIS','0'))
                            <tr>
                                <td>{{$devi->id}}</td>
                                <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                                <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                                <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                                <td><a href="/client/profile?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id}}">{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->nom}} {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->prenom}}</a></td>
                                <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                                <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
                                <td width="100px">{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                                <td>
                                    <a id="resend2{{$devi->id}}" data-id="{{$devi->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                                </td>
                                <td>
                                    <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                                    /<a href="/devis/download?id={{$devi->id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>
                                </td>
                                <td>
                                    <a href="/devis/update?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    /
                                    <a id="delete2{{$devi->id}}" data-id="{{$devi->id}}" class="editor_remove"><span class="glyphicon glyphicon-trash" ></span></a>
                                </td>
                                <td><a id="validate2{{$devi->id}}" href="/devis/validate?id={{$devi->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                            </tr>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#delete2{{$devi->id}}").popConfirm({
                                        title: "Message de confirmation ?",
                                        content: "Voulez vous supprimer l'objet !",
                                        placement: "bottom"
                                    });

                                    $("#validate2{{$devi->id}}").popConfirm({
                                        title: "Message de confirmation ?",
                                        content: "Voulez vous Reserver le devis en cours !",
                                        placement: "bottom"
                                    });
                                });
                            </script>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#facturePanel">Factures en attente de paiement <cite class="text-danger">(envoyées depuis {{env('REMAINDER_DELAI_FACTURE','0')}} jours ou plus )</cite> <span class="badge">{{count($factures)}}</span></a>
                </h4>
            </div>
            <div id="facturePanel"  class="panel-body panel-collapse">
                <table id="example4" class="table table-striped table-bordered display responsive nowrap" cellspacing="0" width="100%">
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
                            <a href="home" id="resend{{$facture->id}}" data-id="{{$facture->id}}" class="resendFact"> <span class="glyphicon glyphicon-refresh"></span> </a>
                            </td>
                            <td>
                                <a href="/devis/view?id={{$facture->devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                                /<a href="/facture/download?id={{$facture->devi_id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>
                            </td>
                            <td>
                                <a href="/facture/view?id={{$facture->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                                /<a href="/facture/download?id={{$facture->id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>
                            </td>
                            <td><a id="validate{{$facture->id}}" href="/facture/validate?id={{$facture->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                        </tr>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#validate{{$facture->id}}").popConfirm({
                                    title: "Message de confirmation ?",
                                    content: "Voulez-vous déclarer le paiement de la facture en cours ?!",
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
@endsection


@section('modals')
    @include('includes.popups')
    @include('includes.clientModals')

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

    <!--Resend popup-->
    <div class="modal fade" id="resendModalDevis" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" id="headRes"></h4>
                </div>
                <form id="deleteForm" action="resend" method="get" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="-1" id="idRes" name="id" />
                        </div>
                        <div class="alert alert-info"><span class="glyphicon glyphicon-refresh"></span> êtes-vous sur de vouloir renvoyer le devis?</div>
                    </div>
                    <div class="modal-footer ">
                        <input class="btn btn-success" value="Oui" id="resendDev" type="submit"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>


    <div class="modal fade" id="resendModalFact" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" >Renvoi facture</h4>
                </div>
                <div class="alert alert-info"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir renvoyer la facture?</div>
                <div class="modal-footer ">
                    <input id="idResendFact" type="hidden" value="-1"/>
                    <button class="btn btn-success" id="resendFact" >Oui</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')

    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/remainder.js") }}"> </script>

@endsection