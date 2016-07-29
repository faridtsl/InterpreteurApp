@extends('layouts.layout')

@section('header')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS3tOh8NpT_5A_-P2-Oz2HqAhEf5h4uSs&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script src="{{ asset("js/myScript.js") }}"> </script>
@endsection

@section('title')
    Update Adresse
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Modifier Adresse de : {{$interpreteur->nom}} {{$interpreteur->prenom}}</h3>
            <form role="form" method="POST" action="/adresse/update" id="formID" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">
                {!! csrf_field() !!}
                <input type="hidden" id="adr" name="adresse_id" value="{{$id}}" />
                @include('includes.adresseForm')
                <input type="submit" value="Modifier" class="btn btn-warning"/>
            </form>
        </div>
    </div>
@endsection
