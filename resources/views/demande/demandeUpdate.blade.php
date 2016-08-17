@extends('layouts.layout')


@section('title')
    Modifier la demande
@endsection

@section('header')
    <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}" />
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <script src="http://cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
    <style type="text/css">
        .pac-container { z-index: 1051 !important; }
        .modal-dialog { width: 80%; height: 100%; padding: 20px; }
    </style>

@endsection

@section('content')

<div class="container-fluid" style="margin-top: 30px">
    <div class="col-lg-12">
        <div class="panel-group" id="accordion">

            <div class="panel panel-info">
                <div class="panel-heading">
		<h4 class="panel-title">
                    	<a data-toggle="collapse" data-parent="#accordion" href="#demandePanel">Informations demande</a>
		</h4>
                </div>
                <div class="panel-body panel-collapse collapse" id="demandePanel">
                    <form role="form" method="POST" action="/demande/update">
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{$demande->id}}" name="id"/>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-3 lab">
                                    <label>Titre de la demande : </label>
                                </div>
                                <div class="col-lg-3 par">
                                    <span class="displayClass">{{$demande->titre}}</span>
                                    <input class="form-control editClass" name="titre" value="{{ $demande->titre }}" placeholder="Saisir l'objet de la demande.">
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
                                    <div class="input-group date editClass" >
                                        <input type="text" name="dateEvent" id="date-start" class="form-control" value="{{ $demande->dateEvent }}" placeholder="Date de debut">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-6 lab">
                                    <label>Date de fin : </label>
                                </div>
                                <div class="col-lg-6 par">
                                    <span class="displayClass">{{\Carbon\Carbon::parse($demande->dateEndEvent)->format('l j F Y H:i')}}</span>
                                    <div class="input-group date editClass" >
                                        <input type="text" name="dateEndEvent" id="date-end" class="form-control" value="{{ $demande->dateEndEvent }}" placeholder="Date de fin">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="col-lg-6 lab">
                                        <label>Langue initiale : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        @foreach($langues as $langue)
                                            @if($langue->id == $traduction->source)
                                                <span class="displayClass">{{$langue->content}}</span>
                                            @endif
                                        @endforeach
                                        <select class="form-control editClass" name="langue_src">
                                            <option value="" disabled selected>Langue source</option>
                                            @foreach($langues as $langue)
                                                @if($langue->id == $traduction->source)
                                                    <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                @else
                                                    <option value="{{$langue->id}}">{{$langue->content}}</option>

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group lab">
                                    <div class="col-lg-6">
                                        <label>Langue destination : </label>
                                    </div>
                                    <div class="col-lg-6 par">
                                        @foreach($langues as $langue)
                                            @if($langue->id == $traduction->cible)
                                                <span class="displayClass">{{$langue->content}}</span>
                                            @endif
                                        @endforeach
                                        <select class="form-control editClass" name="langue_dest">
                                            <option value="" disabled selected>Langue destination</option>
                                            @foreach($langues as $langue)
                                                @if($langue->id == $traduction->cible)
                                                    <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                @else
                                                    <option value="{{$langue->id}}">{{$langue->content}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Contenu de la demande : </label>
                        <textarea class="form-control ckeditor" id="content" rows="10" name="content">{{ $demande->content }}</textarea>
                        <p class="help-block editClass">Saisir le contenu de la demande.</p>
                    </div>
                    <button class="btn btn-outline btn-primary" type="submit">Enregistrer les modifications</button>
                    <a href="#" class="editChamps btn btn-danger">Modifier</a>
                    </form>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#clientPanel">Demandeur</a>
                    </h4>
                </div>
                <div id="clientPanel"  class="panel-body panel-collapse collapse">
                    <div class="row">
                        <div class="col-lg-2">
                            <img class="img-circle" src="/images/{{$client->image}}" style="width: 100px;height:100px;">
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
                    <div class="row" style="margin-top: 20px;margin-left: 10px">
                        <form method="post" action="/demande/update">
                        {!! csrf_field() !!}
                            <input type="hidden" value="{{$demande->id}}" name="id"/>
                            <input type="hidden" value="{{$demande->client_id}}" id="client" name="client"/>
                            <button class="btn btn-outline btn-primary" id="clientConfirm" type="submit">Enregister les modfications</button>
                            <a href="#" class="toggle btn btn-danger" data-title="client" data-toggle="modal" data-target="#clientModal" data-id="{{$demande->client_id}}">Modifier</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#adrPanel">Adresse de l'evenement</a>
                    </h4>
                </div>
                <div id="adrPanel"  class="panel-body panel-collapse collapse">
                    <form method="post" id="adrForm" action="/adresse/update">
                        <input type="hidden" value="{{$demande->adresse_id}}" id="idAdr" name="adresse_id">
                        <div class="container-fluid" id="formAdr">
                            @include('includes.adresseForm')
                        </div>
                        {!! csrf_field() !!}
                        <button class="btn btn-outline btn-primary" id="adrConfirm" type="submit">Enregister les modfications</button>
                        <a href="#" class="btn btn-danger" id="modAdr">Modifier</a>
                    </form>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#devisPanel">Liste des devis</a>
                    </h4>
                </div>
                <div id="devisPanel"  class="panel-body panel-collapse collapse">
                    <div class="list-group">

                        @foreach(array_slice(\App\Tools\DevisTools::getDevis($demande->id)->all(),0,4) as $devis)
                            <a href="/devis/edit/{{$devis->id}}" class="list-group-item">
                                <i class="fa fa fa-money fa-fw"></i> Interpreteur : <strong>{{\App\Tools\InterpreteurTools::getInterpreteur($devis->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devis->interpreteur_id)->prenom}}</strong><br/>
                                Crée le : <strong>{{date('D d M Y h:m:s',strtotime($devis->created_at))}}</strong>
                                <span class="pull-right text-muted small"><em>Prix : <strong>{{ \App\Tools\DevisTools::getTotal($devis->id)}} &euro;</strong></em>
										</span>
                            </a>
                        @endforeach
                    </div>
                    <!-- /.list-group -->

                    <div class="row">
                        <div class="col-lg-6">
                            <a href="#" class="btn btn-default btn-block"  data-toggle="modal" data-target="#devisModal">Afficher tous les devis</a>
                        </div>
                        <div class="col-lg-6">
                            <a href="/devis/add?id={{$demande->id}}" class="btn btn-default btn-block">Ajouter un devis</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#factPanel">Facturation</a>
                    </h4>
                </div>
                <div id="factPanel"  class="panel-body panel-collapse">
                    <table id="exampleFact" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
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

<div class="modal fade" id="devisModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Liste des devis en cours</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover responsive" width="90%" id="example" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Nom de l'interpreteur</th>
                        <th>Adresse de l'interpreteur</th>
                        <th width="20px">Prix proposé</th>
                        <th width="40px">Resend/Edit/Delete</th>
                        <th width="20px">Valider</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Nom de l'interpreteur</th>
                        <th>Adresse de l'interpreteur</th>
                        <th>Prix proposé</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach(\App\Tools\DevisTools::getDevis($demande->id) as $devi)
                        <tr>
                            <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                            <td>{{\App\Tools\AdresseTools::getAdresse(\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->adresse_id)->adresse}}</td>
                            <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                            <td><a href="home" data-id="{{$devi->id}}" class="resendButton"> <span class="glyphicon glyphicon-refresh"></span> </a> / <a href="/devis/update/{{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a> / <a id="delete{{$devi->id}}" href="/devis/delete?id={{$devi->id}}" class="editor_remove"><span class="glyphicon glyphicon-trash" ></span></a></td>
                            <td><a id="validate{{$devi->id}}" href="/devis/validate?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-ok"></span></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  modal-header-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Liste des Clients</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover" id="clients" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom Client</th>
                        <th>E-MAIL</th>
                        <th>Telephone portable</th>
                        <th>Telephone fixe</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Nom Client</th>
                        <th>E-MAIL</th>
                        <th>Telephone portable</th>
                        <th>Telephone fixe</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{$client->id}}</td>
                            <td>
                                <img class="img-circle" src="/images/{{$client->image}}" style="width: 50px;height:50px;"/>
                                {{$client->nom}} {{$client->prenom}}
                            </td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->tel_portable}}</td>
                            <td>{{$client->tel_fixe}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('includes.popups')



<div class="modal fade" id="resendModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                <h4 class="modal-title custom_align" >Renvoi devis</h4>
            </div>
            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir renvoyer le devis?</div>
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
    <script src="{{ asset("js/demandeUpdate.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset("js/timeInitiator.js") }}"> </script>

@endsection
