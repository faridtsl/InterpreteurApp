@extends('layouts.layout')

@section('title')
{{$client->nom}} {{$client->prenom}}
@endsection

@section('header')
<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}"/>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css"/>
<link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
<link rel="stylesheet" href="{{ asset('/css/success.css')}}" />
<script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('content')

<div class="container-fluid">
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="container-fluid well span6">
            <div class="col-sm-2 col-md-2">
                <img src="/images/{{$client->image}}" alt="" id="imgInterp" class="img-circle img-responsive" />
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
                <a data-toggle="collapse" href="#factPanel">Archive des Factures</a>
            </h4>
        </div>
        <div id="factPanel"  class="panel-body panel-collapse">
            <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
                <thead>
                <tr>
                    <th class="never">id</th>
                    <th>Date d'envoi</th>
                    <th>Date de paiement</th>
                    <th>Total</th>
                    <th>View</th>
                    <th>View Devis</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="never">id</th>
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
                    <td>{{$facture->date_envoi_mail}}</td>
                    <td>@if($facture->fini){{$facture->date_paiement}}@else Non Payée @endif</td>
                    <td>{{\App\Tools\DevisTools::getDevisById($facture->devi_id)->total}} &euro;</td>
                    <td>{{\App\Tools\ClientTools::getClientByFacture($facture)->nom}} {{\App\Tools\ClientTools::getClientByFacture($facture)->prenom}}</td>
                    <td>
                        <a href="/facture/view?id={{$facture->devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                    </td>
                    <td>
                        <a href="/devis/view?id={{$facture->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
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
                <a data-toggle="collapse" href="#commandePanel">Archive des Devis</a>
            </h4>
        </div>
        <div id="commandePanel"  class="panel-body panel-collapse">
            <table id="tableCommande" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
                <thead>
                <tr>
                    <th class="never">id</th>
                    <th>Nom de l'interpreteur</th>
                    <th>Etat</th>
                    <th>Prix proposé</th>
                    <th>Demande</th>
                    <th>Adresse de l'interpreteur</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                    <th>View</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>Nom de l'interpreteur</th>
                    <th>Etat</th>
                    <th>Prix proposé</th>
                    <th>Demande</th>
                    <th>Adresse de l'interpreteur</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($devis as $devi)
                <tr>
                    <td>{{$devi->id}}</td>
                    <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                    <td>{{\App\Tools\DevisEtatTools::getEtatById($devi->etat_id)->libelle }}</td>
                    <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                    <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                    <td>{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                    <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                    <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
                    <td>
                        <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
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
                <a data-toggle="collapse" href="#demandePanel">Archive des Demandes</a>
            </h4>
        </div>
        <div id="demandePanel"  class="panel-body panel-collapse">
            <table id="demandesTable" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Etat</th>
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
                    <td>{{\Carbon\Carbon::parse($demande->created_at)->format('l j F Y H:i')}}</td>
                    <td>{{\Carbon\Carbon::parse($demande->updated_at)->format('l j F Y H:i')}}</td>
                    <td>{{\Carbon\Carbon::parse($demande->dateEvent)->format('l j F Y H:i')}}</td>
                    <td>{{\Carbon\Carbon::parse($demande->dateEndEvent)->format('l j F Y H:i')}}</td>
                    <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->source)->content}}</td>
                    <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->cible)->content}}</td>
                    <td>{{ \App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</td>
                    <td>
                        <p>
                            <a data-placement="top" data-toggle="tooltip" title="Restore" class="btn btn-success btn-xs restoreButton" href="/demande/restore?id={{$demande->id}}" >
                                <span class="glyphicon glyphicon-refresh"></span>
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
    <a class="btn btn-default" href="/client/profile?id={{$client->id}}">
        <span class="glyphicon glyphicon-arrow-left"></span>Retour
    </a>
</div>
</div>
@endsection


@section('modals')
@include('includes.popups')
@include('includes.clientModals')
@endsection

@section('footer')
<script src="{{ asset("js/profileClient.js") }}"> </script>
@endsection