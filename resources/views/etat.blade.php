@extends('layouts.layout')

@section('title')
    Ajout Etats
@endsection

@section('content')
    @if(isset($message))
        <div class="alert alert-success">
            <strong>Success!</strong> {{$message}}
        </div>
    @endif
    <form role="form" method="POST" action="/etat/add" id="formID" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">
        {!! csrf_field() !!}
        <div class="panel panel-default">
            <div class="form-group">
                <label>Nom Etat</label>
                <input class="form-control" name="lib" required="true" value="{{ old('lib') }}" />
            </div>
            <button id="send" type="submit" class="btn btn-primary">Ajouter</button>
            <button type="reset" class="btn btn-danger">Supprimer</button>
        </div>
    </form>

@endsection