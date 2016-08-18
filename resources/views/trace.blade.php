@extends('layouts.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/success.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('title')
    Traces
@endsection

@section('content')
    <div class="row">
        <h1 class="center"> Traces </h1>
        <hr>
    </div>

    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#tracesPanel">
                        Liste des traces
                    </a>
                </h4>
            </div>
            <div id="tracesPanel" class="panel-collapse panel-body">

                <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Date</th>
                            <th>Operation</th>
                            <th>Type Concerné</th>
                            <th>id Concerné</th>
                            <th>Resultat</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Date</th>
                            <th>Operation</th>
                            <th>Type Concerné</th>
                            <th>id Concerné</th>
                            <th>Resultat</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($traces as $trace)
                            <tr>
                                <td>{{\App\Tools\UserTools::getUser($trace->user_id)->name}}</td>
                                <td>{{$trace->created_at->format('l j F Y H:i')}}</td>
                                <td>{{$trace->operation}}</td>
                                <td>{{$trace->type}}</td>
                                <td>{{$trace->concerned_id}}</td>
                                <td>@if($trace->resultat) Success @else Error @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/trace.js") }}"> </script>

@endsection