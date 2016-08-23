@extends('layouts.layout')

@section('header')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="{{ asset('/css/myStyle.css')}}" />
@endsection

@section('title')
    Ajout Client
@endsection

@section('content')
    <h3 class="page-header">Ajouter un nouveau client</h3>
    <form role="form" method="POST" action="/client/add" id="formID" enctype="multipart/form-data">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Nom du client</label>
                            <input class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <label>Prenom</label>
                            <input class="form-control" value="{{ old('prenom') }}"  name="prenom" placeholder="Prenom">
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input class="form-control" value="{{ old('email') }}"  name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>nationalite</label>
                            <input class="form-control" value="{{ old('nationalite') }}"  name="nationalite" placeholder="nationalite">
                        </div>
                        <div class="form-group">
                            <label>Image : </label>
                            <input type="file" name="image" value="{{ old('image') }}">
                        </div>
                        <div class="form-group">
                            <label>tel portable</label>
                            <input class="form-control" value="{{ old('tel_portable') }}"  name="tel_portable" placeholder="Telephone portable">
                        </div>
                        <div class="form-group">
                            <label>tel fixe</label>
                            <input class="form-control"  value="{{ old('tel_fixe') }}" name="tel_fixe" placeholder="Telephone fixe">
                        </div>
                        <div class="form-group">
                            <label>Commentaire</label>
                            <textarea class="form-control" name="commentaire" rows="3">{{ old('commentaire') }}</textarea>
                        </div>
                        <button id="send" type="submit" class="btn btn-outline btn-primary">Ajouter</button>
                        <button type="reset" class="btn btn-outline btn-primary">Supprimer</button>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            @include('includes.adresseForm')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection


@section('modals')

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

    @if(isset($message))
        <!-- Modal -->
        <div class="modal fade" id="sucess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-header-success">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">{{$message}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-2">

                                <img class="img-circle" src="/images/{{$img}}" style="width: 100px;height:100px;">
                            </div>
                            <div class="col-lg-9">
                                <h3>{{$client->nom}} {{$client->prenom}}</h3>
                                <span class="glyphicon glyphicon-phone-alt"> {{$client->tel_portable}} </span><br/>
                                <span class="glyphicon glyphicon-earphone"> {{$client->tel_fixe}}</span><br/>
                                <span class="glyphicon glyphicon-globe"> {{$client->email}}</span><br/>

                            </div>

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
    @endif

@endsection


@section('footer')
    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#errorModal').modal('show');
        @endif
    </script>

    @if(isset($message))
        <script type="text/javascript">
            $('#sucess').modal('show');
        </script>
    @endif


    <script src="{{ asset("js/myScript.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>

@endsection