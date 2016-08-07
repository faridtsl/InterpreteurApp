@extends('layouts.layout')

@section('title')
    La liste des devis
@endsection

@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <script type="text/javascript" src="{{{ asset('js/jquery.popconfirm.js')}}}"></script>
@endsection

@section('content')


<div class="row">
    <h1 class="center"> Liste des devis </h1>
</div>

<div class="row">
    <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
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
                        <a href="/devis/edit?id={{$devi->id}}" class="editor_edit"><span class="glyphicon glyphicon-pencil"></span></a>
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
                    <h4 class="modal-title custom_align" >Renvoyer le devis ?</h4>
                </div>
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
    <script src="{{ asset("js/devisShow.js") }}"> </script>
@endsection