@extends('layouts.layout')

@section('title')
    Ajout Langues
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h2>Ajout Langue</h2>
        </div>
        <div class="row">
            @if(isset($message))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{$message}}
                </div>
            @endif
            <form role="form" method="POST" action="/langue/add" id="formID" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">
                {!! csrf_field() !!}
                <div class="panel">
                    <div class="form-group">
                        <label>Abreviation Langue</label>
                        <input class="form-control" name="abreviation" required="true" value="{{ old('abreviation') }}" />
                    </div>
                    <div class="form-group">
                        <label>Nom Langue</label>
                        <input class="form-control" name="nom" required="true" value="{{ old('nom') }}" />
                    </div>

                    <button id="send" type="submit" class="btn btn-primary">Ajouter</button>
                    <button type="reset" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>

@endsection