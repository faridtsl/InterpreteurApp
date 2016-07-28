@extends('layouts.layout')


@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
@endsection

@section('title')
    Liste Interpreteurs
@endsection


@section('content')

    <div class="row">
        <h1 class="center"> Liste des interpreteurs </h1>
    </div>

    <div class="row">
        <table id="example" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Prestation</th>
                <th>Adresse</th>
                <th>Action</th>
                <th>Telephone portable</th>
                <th>Telephone fixe</th>
                <th>Traductions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Prestation</th>
                <th>Adresse</th>
                <th></th>
                <th>Telephone portable</th>
                <th>Telephone fixe</th>
                <th>Traductions</th>
            </tr>
            </tfoot>
            <tbody>
                @foreach($interpreteurs as $interpreteur)
                    <tr>
                        <td>
                            <img class="img-circle" src="/images/{{$interpreteur->image}}" style="width: 50px;height:50px;"/>
                            {{$interpreteur->nom}} {{$interpreteur->prenom}}
                        </td>
                        <td>{{$interpreteur->email}}</td>
                        <td>{{$interpreteur->prestation}} {{$interpreteur->devise}}</td>
                        <td>{{\App\Tools\AdresseTools::getAdresse($interpreteur->adresse_id)->adresse}}</td>

                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                                <button class="btn btn-warning btn-xs editButton" data-title="Edit" data-toggle="modal" data-target="#edit" data-id="{{$interpreteur->id}}" >
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                            </p>
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                <button class="btn btn-danger btn-xs deleteButton" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="{{$interpreteur->id}}" >
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </p>
                        </td>
                        <td>{{$interpreteur->tel_portable}}</td>
                        <td>{{$interpreteur->tel_fixe}}</td>
                        <td>
                            @foreach(\App\Tools\TraductionTools::getTraductionsByInterpreteur($interpreteur->id) as $traduction)
                                {{\App\Tools\LangueTools::getLangue($traduction->source)->content}} -> {{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}
                                ;
                            @endforeach
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
                        <div class="form-group">
                            <label>Identifiant: </label>
                            <input type="text" value="-1" readonly="readonly" id="id" name="id" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Email: </label>
                            <input type="text" value="-1" id="email" name="email" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Prestation: </label>
                            <input type="text" value="-1" id="prestation" name="prestation" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Tel fixe: </label>
                            <input type="text" value="-1" id="tel_fixe" name="tel_fixe" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Tel portable: </label>
                            <input type="text" value="-1" id="tel_portable" name="tel_portable" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <input value="Modifier" type="submit" class="btn btn-warning btn-lg" style="width: 100%;" />
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

@endsection


@section('footer')
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"> </script>
    <script src="{{ asset("js/myScript.js") }}"> </script>
@endsection