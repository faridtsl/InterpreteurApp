@extends('layouts.layout')

@section('title')
    {{$client->nom}} {{$client->prenom}}
@endsection

@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('/css/success.css')}}" />
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('content')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="container-fluid well span6">
            <div class="col-sm-2 col-md-2">
                <img src="/images/{{$client->image}}" alt="" id="imgInterp" class="img-rounded img-responsive" />
            </div>
            <div class="col-sm-2 col-md-4">
                <blockquote>
                    <p id="nomInterp">{{$client->nom}} {{$client->prenom}}</p>@if($client->trashed())<small><cite title="Source Title" id="adresseInterp"><span class="label label-danger displayClass">Archivé</span></cite></small>@endif

                </blockquote>
                <p> <i class="glyphicon glyphicon-envelope"></i> <span id="emailInterp">{{$client->email}}</span>
                    <br/> <i class="glyphicon glyphicon-phone"></i> <span id="telInterp">{{$client->tel_portable}}</span>
                    <br/> <i class="glyphicon glyphicon-home"></i> <span id="telFixInterp">{{$client->tel_fixe}}</span>
                </p>
            </div>
        </div>
        <hr>
    </div>
</div>

<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#factPanel">Factures</a>
            </h4>
        </div>
        <div id="factPanel"  class="panel-body panel-collapse">
            <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
                <thead>
                <tr>
                    <th class="never">id</th>
                    <th>Nom du client</th>
                    <th>Resend</th>
                    <th>View</th>
                    <th>View Devis</th>
                    <th>Valider</th>
                    <th>Date d'envoi</th>
                    <th>Date de paiement</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="never">id</th>
                    <th>Nom du client</th>
                    <th>Resend</th>
                    <th>View</th>
                    <th>View Devis</th>
                    <th>Valider</th>
                    <th>Date d'envoi</th>
                    <th>Date de paiement</th>
                    <th>Total</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($factures as $facture)

                    <tr>
                        <td>{{$facture->id}}</td>
                        <td>{{\App\Tools\ClientTools::getClientByFacture($facture)->nom}} {{\App\Tools\ClientTools::getClientByFacture($facture)->prenom}}</td>
                        <td>
                            <a href="home" id="resend{{$facture->id}}" data-id="{{$facture->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                        </td>
                        <td>
                            <a href="/facture/view?id={{$facture->devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        </td>
                        <td>
                            <a href="/devis/view?id={{$facture->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        </td>
                        <td><a id="validate{{$facture->id}}" href="/facture/validate?id={{$facture->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                        <td>{{$facture->date_envoi_mail}}</td>
                        <td>@if($facture->fini){{$facture->date_paiement}}@else Non Payée @endif</td>
                        <td>{{\App\Tools\DevisTools::getDevisById($facture->devi_id)->total}} &euro;</td>
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
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#commandePanel">Devis</a>
            </h4>
        </div>
        <div id="commandePanel"  class="panel-body panel-collapse">
            <table id="tableCommande" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
                <thead>
                <tr>
                    <th class="never">id</th>
                    <th>Nom de l'interpreteur</th>
                    <th>Prix proposé</th>
                    <th>Resend</th>
                    <th>View</th>
                    <th>Edit/Delete</th>
                    <th>Valider</th>
                    <th>Demande</th>
                    <th>Client</th>
                    <th>Adresse de l'interpreteur</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>Nom de l'interpreteur</th>
                    <th>Prix proposé</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Demande</th>
                    <th>Client</th>
                    <th>Adresse de l'interpreteur</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($devis as $devi)
                    @if(\App\Tools\DevisEtatTools::getEtatById($devi->etat_id)->libelle != "Validé")
                        <tr>
                            <td>{{$devi->id}}</td>
                            <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                            <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                            <td>
                                <a href="home" id="resend{{$devi->id}}" data-id="{{$devi->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a>
                            </td>
                            <td>
                                <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                            </td>
                            <td>
                                <a href="/devis/update?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                /
                                <a id="delete{{$devi->id}}" href="/devis/delete?id={{$devi->id}}" class="editor_remove"><span class="glyphicon glyphicon-trash" ></span></a>
                            </td>
                            <td><a id="validate{{$devi->id}}" href="/devis/validate?id={{$devi->id}}" class="validateButton"><span class="glyphicon glyphicon-ok"></span></a></td>
                            <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                            <td><a href="/client/profile?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id}}">{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->nom}} {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande($devi->demande_id)->client_id)->prenom}}</a></td>
                            <td>{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                            <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                            <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
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
                                    content: "Voulez vous Valider le devis en cours !",
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

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#demandePanel">Demandes</a>
            </h4>
        </div>
        <div id="demandePanel"  class="panel-body panel-collapse">
            <table id="demandesTable" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
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

<div class="row">
    <form action="/client/delete" method="post">
        {!! csrf_field() !!}
        <a class="btn btn-warning" href="/client/profile/archive?id={{$client->id}}">Archives</a>
        <input type="hidden" name="id" value="{{$client->id}}"/>
        <button class="btn btn-danger" id="supprimerClient" type="submit">Supprimer</button>
        <script>
            $(document).ready(function () {
                $("#supprimerClient").popConfirm({
                    title: "Message de confirmation ?",
                    content: "Voulez vous supprimer le client !",
                    placement: "bottom"
                });
            });

        </script>
    </form>
</div>

@endsection


@section('modals')
    @include('includes.popups')
@endsection

@section('footer')
    <script src="{{ asset("js/profileClient.js") }}"> </script>
@endsection