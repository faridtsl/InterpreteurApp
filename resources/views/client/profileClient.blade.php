@extends('layouts.layout')

@section('title')
    {{$client->nom}} {{$client->prenom}}
@endsection

@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/cardProfiles.css')}}" />
    <link rel="stylesheet" href="{{ asset('/css/success.css')}}" />
    <style type="text/css"> .pac-container { z-index: 1051 !important; } </style>
    <meta name="_token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('content')
<br/>
<!--div class="row">
    <!--div class="col-lg-12">
        <div class="container-fluid well span6">
            <div class="col-sm-2 col-md-1">
                <img src="/images/{{$client->image}}" style="width: 80px;height:80px;" class="img-circle" />
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
</div-->

<!--div class="row text-center">
    <div class="col-lg-12 col-sm-12 col-xs-12 text-center">

        <div class="card hovercard">
            <div class="cardheader">

            </div>
            <div class="avatar">
                <img alt="" src="/images/{{$client->image}}">
            </div>
            <div class="info">
                <div class="title">
                    <span>{{$client->nom}} {{$client->prenom}}</span>
                </div>
                <div class="desc"> <i class="glyphicon glyphicon-envelope"></i>  {{$client->email}}</div>
                <div class="desc"> <i class="glyphicon glyphicon-phone"></i> {{$client->tel_portable}}</div>
                <div class="desc">  <i class="glyphicon glyphicon-home"></i> {{$client->tel_fixe}}</div>
            </div>
            <div class="bottom">
                @if($client->trashed())<small><cite title="Source Title" id="adresseInterp"><span class="label label-danger displayClass">Archivé</span></cite></small>@endif
            </div>
        </div>

    </div>

</div-->


<h3 class="page-header">{{$client->nom}} {{$client->prenom}} @if($client->trashed())<small><cite title="Source Title" id="adresseInterp"><span class="label label-danger displayClass">Archivé</span></cite></small>@endif</h3>
<div class="row">
    <!-- left column -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="text-center">
            <img src="/images/{{$client->image}}" style="height: 200px;width:200px;margin-bottom: 10px;" class="avatar img-circle img-thumbnail" alt="avatar">
        </div>
    </div>
    <!-- edit form column -->
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
        <div class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-lg-3 control-label">Adresse</label>
                <div class="col-lg-8">
                    <input class="form-control" value="{{ \App\Tools\AdresseTools::getAdresse($client->adresse_id)->adresse}}" type="text" disabled="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">tel fixe</label>
                <div class="col-lg-8">
                    <input class="form-control" value="{{$client->tel_fixe}}" type="text" disabled="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">tel portable</label>
                <div class="col-lg-8">
                    <input class="form-control" value="{{$client->tel_portable}}" type="text" disabled="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Email:</label>
                <div class="col-lg-8">
                    <input class="form-control" value="{{$client->email}}" type="text" disabled="true">
                </div>
            </div>
        </div>
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
            <table id="tableFactures" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
                <thead>
                <tr>
                    <th class="never">id</th>
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
                    <th>Etat</th>
                    <th>Prix proposé</th>
                    <th>Demande</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                    <th>Resend</th>
                    <th>Show</th>
                    <th>Edit/Delete</th>
                    <th>Valider</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>Etat</th>
                    <th>Prix proposé</th>
                    <th>Demande</th>
                    <th>Date creation du devis</th>
                    <th>Date modification du devis</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($devis as $devi)
                    @if($devi->etat_id == 2 || $devi->etat_id == 1)
                        <tr>
                            <td>{{$devi->id}}</td>
                            <td>{{\App\Tools\DevisEtatTools::getEtatById($devi->etat_id)->libelle }}</td>
                            <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                            <td><a href="/demande/update?id={{\App\Tools\DemandeTools::getDemande($devi->demande_id)->id}}">{{\App\Tools\DemandeTools::getDemande($devi->demande_id)->titre}}</a></td>
                            <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                            <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
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
                    <th>Date Creation</th>
                    <th>Date de Modification</th>
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
                    <th>Date Debut</th>
                    <th>Date Fin</th>
                    <th>Adresse de l'evenement</th>
                    <th>Traductions</th>
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
                            <td width="100px">{{ \App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</td>
                            <td>
                                |
                                @foreach(\App\Tools\TraductionTools::getTraductionsByDemande($demande->id) as $traduction)
                                    {{\App\Tools\LangueTools::getLangue($traduction->source)->content}} <span class="glyphicon glyphicon-arrow-right"></span> {{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}
                                    |
                                @endforeach
                            </td>
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

    <form action="/client/delete" method="post">
        {!! csrf_field() !!}
        <a class="btn btn-default" href="/client/profile/archive?id={{$client->id}}">
            <span class="glyphicon glyphicon-clock"></span>Archives
        </a>
        <a class="btn btn-primary" href="/client/profile/statistiques?id={{$client->id}}">
            <span class="fa fa-bar-chart-o fa-fw"></span> Statistiques
        </a>
        <button class="btn btn-warning editButton" data-title="Edit" data-toggle="modal" data-target="#edit" data-id="{{$client->id}}" >
            <span class="glyphicon glyphicon-pencil"></span> Modifier
        </button>
        <input type="hidden" name="id" value="{{$client->id}}"/>
        <button class="btn btn-danger" id="supprimerClient" type="submit"><span class="glyphicon glyphicon-trash"></span>Supprimer</button>
        <script>
            $(document).ready(function () {
                $("#supprimerClient").popConfirm({
                    title: "Message de confirmation ?",
                    content: "Voulez vous supprimer le client !",
                    placement: "top"
                });
            });

        </script>
    </form>
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
    <script src="{{ asset("js/profileClient.js") }}"> </script>
    <script src="{{ asset("js/steps.js") }}"> </script>
    <script src="{{ asset("js/myScript.js") }}"> </script>
    <script src="{{ asset("js/modifJS.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#statButt").on('click',function (e) {
                e.preventDefault();
                $("#statModal").modal('show');
            });

            function getCumule (y,pred) {
                $.ajax({
                    url: '/facture/year/cumul?y=' + y + '&pred=' + pred + '&id={{$client->id}}',
                    type: "GET",
                    success: function (data) {
                        var options1 = {
                            title: {
                                text: "Revenue cumule de l'annee " + y,
                                fontSize : 14
                            },
                            animationEnabled: true,
                            data: [
                                {
                                    type: "spline", //change it to line, area, bar, pie, etc
                                    dataPoints: data
                                }
                            ],
                            axisX: {
                                labelFontSize: 14
                            },
                            axisY: {
                                labelFontSize: 14
                            }
                        };
                        $("#chartContainer2").CanvasJSChart(options1);
                    }, error: function () {
                        alert("error!!!!");
                    }
                });
            }

            function getRevenuFacts (y,pred) {
                $.ajax({
                    url: '/facture/year?y=' + y + '&pred=' + pred + '&id={{$client->id}}',
                    type: "GET",
                    success: function (data) {
                        var options1 = {
                            title: {
                                text: "Revenue de l'annee " + y,
                                fontSize : 14
                            },
                            animationEnabled: true,
                            data: [
                                {
                                    type: "spline", //change it to line, area, bar, pie, etc
                                    dataPoints: data
                                }
                            ],
                            axisX: {
                                labelFontSize: 14
                            },
                            axisY: {
                                labelFontSize: 14
                            }
                        };
                        $("#chartContainer1").CanvasJSChart(options1);
                    }, error: function () {
                        alert("error!!!!");
                    }
                });
            }

            function getRevenuFactsPred (y) {
                $.ajax({
                    url: '/facture/year?y=' + y + '&pred=1' + '&id={{$client->id}}',
                    type: "GET",
                    success: function (data) {
                        var options1 = {
                            title: {
                                text: "Prediction du revenue de l'annee " + y,
                                fontSize : 14
                            },
                            animationEnabled: true,
                            data: [
                                {
                                    type: "spline", //change it to line, area, bar, pie, etc
                                    dataPoints: data
                                }
                            ],
                            axisX: {
                                labelFontSize: 14
                            },
                            axisY: {
                                labelFontSize: 14
                            }
                        };
                        $("#chartContainer4").CanvasJSChart(options1);
                    }, error: function () {
                        alert("error!!!!");
                    }
                });
            }


            function getDemandes (y) {
                $.ajax({
                    url: '/demande/year?y=' + y + '&id={{$client->id}}',
                    type: "GET",
                    success: function (data) {
                        var chart = new CanvasJS.Chart("chartContainer3",
                                {
                                    title: {
                                        text: "Nombre des demandes "+y,
                                        fontSize : 14
                                    },
                                    animationEnabled: true,
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function (e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                e.dataSeries.visible = false;
                                            }
                                            else {
                                                e.dataSeries.visible = true;
                                            }
                                            chart.render();
                                        }
                                    },
                                    axisY: {
                                        title: "Demandes"
                                    },
                                    toolTip: {
                                        shared: true,
                                        content: function (e) {
                                            var str = '';
                                            var total = 0;
                                            var str3;
                                            var str2;
                                            for (var i = 0; i < e.entries.length; i++) {
                                                var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                                                total = e.entries[i].dataPoint.y + total;
                                                str = str.concat(str1);
                                            }
                                            str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";
                                            str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";

                                            return (str2.concat(str)).concat(str3);
                                        }

                                    },
                                    data: [
                                        {
                                            type: "bar",
                                            showInLegend: true,
                                            name: "Finalisee",
                                            color: "silver",
                                            dataPoints: data['F']
                                        },
                                        {
                                            type: "bar",
                                            showInLegend: true,
                                            name: "Non finalisees",
                                            color: "#A57164",
                                            dataPoints: data['T']
                                        }

                                    ]
                                });
                        chart.render();
                    }
                });
            }

            $('.changeYear').on('click',function (e) {
                e.preventDefault();
                var y = $(this).attr('data-id');
                getDemandes(y);
                getRevenuFacts(y,0);
                getRevenuFactsPred(y);
                getCumule(y,0);
            });


            getDemandes(new Date().getFullYear());
            getRevenuFacts(new Date().getFullYear(),0);
            getRevenuFactsPred(new Date().getFullYear());
            getCumule(new Date().getFullYear(),0);
        });
    </script>
@endsection