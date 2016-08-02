@extends('layouts.layout')


@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
@endsection

@section('title')
    Liste Clients
@endsection


@section('content')

    <div class="row">
        <h1 class="center"> Liste des clients </h1>
    </div>

    <div class="row">
        <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Telephone portable</th>
                <th>Telephone fixe</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Telephone portable</th>
                <th>Telephone fixe</th>
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
                    <td>{{$client->tel_portable}}</td>
                    <td>{{$client->tel_fixe}}</td>
                    <td>
                        <p data-placement="top" data-toggle="tooltip" title="Edit">
                            <button class="btn btn-warning btn-xs editButton" data-title="Edit" data-toggle="modal" data-target="#edit" data-id="{{$client->id}}" >
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button class="btn btn-danger btn-xs deleteButton" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="{{$client->id}}" >
                                <span class="glyphicon glyphicon-trash"></span>
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

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    <h4 class="modal-title custom_align" id="Heading">Modifier</h4>
                </div>

                <form role="form" method="post" id="updateForm" action="update" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <h3> Informations personnelles</h3>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Nom</label>
                                        <input class="form-control" value="{{ old('nom') }}" name="nom" id="nom" placeholder="Nom">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Prenom</label>
                                        <input class="form-control" value="{{ old('prenom') }}" name="prenom" id="prenom" placeholder="Prenom">
                                    </div>
                                </div>
                                <input type="hidden" value="-1" readonly="readonly" id="id" name="id" class="form-control"/>
                                <input type="hidden" value="-1" readonly="readonly" id="adr" name="adresse_id" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input type="text" value="-1" id="email" name="email" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Image : </label>
                                <input type="file" name="image" />
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label>Tel fixe: </label>
                                    <input type="text" value="-1" id="tel_fixe" name="tel_fixe" class="form-control"/>
                                </div>
                                <div class="col-lg-6">
                                    <label>Tel portable: </label>
                                    <input type="text" value="-1" id="tel_portable" name="tel_portable" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" class="btn btn-success js-btn-step"> Modifier </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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

    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header  modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Liste d'erreurs</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Erreurs : </strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <i class="fa fa fa-times fa-fw"></i> {{$error}} <br/>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection


@section('footer')
    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#errorModal').modal('show');
        @endif
    </script>

    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"> </script>
    <script src="{{ asset("js/myScript.js") }}"> </script>
@endsection