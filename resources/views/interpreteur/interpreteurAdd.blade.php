@extends('layouts.layout')

@section('header')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
@endsection

@section('title')
    Ajout Interpreteur
@endsection

@section('content')

<div class="controls">
    <form role="form" method="POST" action="/interpreteur/add" id="formID" enctype="multipart/form-data">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    {!! csrf_field() !!}
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Nom de l'interpreteur</label>
                                <input class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Nom" >
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
                                <label>Image : </label>
                                <input type="file" name="image">
                            </div>
                            <div class="form-group">
                                <label>CV : </label>
                                <input type="file" name="cv">
                            </div>
                            <div class="form-group">
                                <label>CV Anonyme : </label>
                                <input type="file" name="cv_anonyme">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Prix préstation</label>
                                        <input class="form-control" value="{{ old('prestation') }}"  name="prestation" placeholder="Prestation">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Devise</label>
                                        <select name="devise" class="form-control">
                                            <option value="Dollar">Dollar</option>
                                            <option value="Euro">Euro</option>
                                            <option value="DH">DH</option>
                                        </select>
                                    </div>
                                </div>
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
                                <textarea class="form-control ckeditor" name="commentaire" rows="3">{{ old('commentaire') }}</textarea>
                            </div>
                            <!--<input id="hiddenfield" name="langues" hidden="true"></input>-->
                            <button id="send" type="submit" class="btn btn-outline btn-primary">Ajouter</button>
                            <button type="reset" class="btn btn-outline btn-primary">Supprimer</button>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="langs">
                                <div class="entry input-group">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <label>Langue initiale</label>
                                                <select class="form-control col-lg-3" name="langue_src[]">
                                                    <option value="" disabled selected>Langue initiale</option>
                                                    @foreach($langues as $langue)
                                                        @if($langue->id == old('langue_ini'))
                                                            <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                        @else
                                                            <option value="{{$langue->id}}">{{$langue->content}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <label>Langue destination</label>
                                                <select class="form-control col-lg-3" name="langue_dest[]" >
                                                    <option value="" disabled selected>Langue destination</option>
                                                    @foreach($langues as $langue)
                                                        @if($langue->id == old('langue_dest'))
                                                            <option value="{{$langue->id}}" selected>{{$langue->content}}</option>
                                                        @else
                                                            <option value="{{$langue->id}}">{{$langue->content}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label></label>
                                                <span class="input-group-btn">
                                                  <button class="btn btn-success btn-add" type="button">
                                                      <span class="glyphicon glyphicon-plus"></span>
                                                  </button>
                                              </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @include('includes.adresseForm')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
                                <h3>{{$interpreteur->nom}} {{$interpreteur->prenom}}</h3>
                                <span class="glyphicon glyphicon-phone-alt"> {{$interpreteur->tel_portable}} </span><br/>
                                <span class="glyphicon glyphicon-earphone"> {{$interpreteur->tel_fixe}}</span><br/>
                                <span class="glyphicon glyphicon-globe"> {{$interpreteur->email}}</span><br/>
                                <span class="glyphicon glyphicon-home"> {{$interpreteur->adresse->adresse}}</span><br/>

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
