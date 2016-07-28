@extends('layouts.layout')


@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
@endsection

@section('title')
    Archive des Clients
@endsection


@section('content')

    <div class="row">
        <h1 class="center"> Liste des clients archivés</h1>
    </div>

    <div class="row">
        <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Telephone fixe</th>
                <th>Telephone portable</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Telephone fixe</th>
                <th>Telephone portable</th>
                <th></th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>
                        <img class="img-circle" src="/images/{{$client->image}}" style="width: 50px;height:50px;"/>
                        {{$client->nom}} {{$client->prenom}}
                    </td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->tel_fixe}}</td>
                    <td>{{$client->tel_portable}}</td>
                    <td>
                        <p data-placement="top" data-toggle="tooltip" title="Edit">
                            <button class="btn btn-success btn-xs restoreButton" data-title="Restore" data-toggle="modal" data-target="#restore" data-id="{{$client->id}}" >
                                <span class="glyphicon glyphicon-refresh"></span>
                            </button>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <!--Suppression popup-->
    <div class="modal fade" id="restore" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" id="headRestore"></h4>
                </div>
                <form id="restoreForm" action="restore" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="-1" id="idRestore" name="id" />
                        </div>
                        <div class="alert alert-success"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir restorer?</div>
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

@endsection


@section('footer')
    <script src="{{ asset("js/myScript.js") }}"> </script>
@endsection