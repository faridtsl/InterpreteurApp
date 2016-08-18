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
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>
@endsection

@section('content')


    <div class="row">
        <h1 class="center"> Archive des devis </h1>
    </div>

    <div class="row">
        <table id="example" class="table table-striped table-bordered display responsive nowrap" cellspacing="0">
            <thead>
            <tr>
                <th class="never">id</th>
                <th>Nom de l'interpreteur</th>
                <th>Etat</th>
                <th>Prix proposé</th>
                <th>Date creation du devis</th>
                <th>Date modification du devis</th>
                <th>Date suppression du devis</th>
                <th>Restorer</th>
                <th>Show</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>id</th>
                <th>Nom de l'interpreteur</th>
                <th>Etat</th>
                <th>Prix proposé</th>
                <th>Date creation du devis</th>
                <th>Date modification du devis</th>
                <th>Date suppression du devis</th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($devis as $devi)
                <tr>
                    <td>{{$devi->id}}</td>
                    <td>{{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->nom}} {{\App\Tools\InterpreteurTools::getInterpreteur($devi->interpreteur_id)->prenom}}</td>
                    <td>{{\App\Tools\DevisEtatTools::getEtatById($devi->etat_id)->libelle}}</td>
                    <td>{{\App\Tools\DevisTools::getTotal($devi->id)}} &euro;</td>
                    <td>{{$devi->created_at->format('l j F Y H:i')}}</td>
                    <td>{{$devi->updated_at->format('l j F Y H:i')}}</td>
                    <td>{{$devi->deleted_at->format('l j F Y H:i')}}</td>
                    <td>
                        <a href="/devis/restore?id={{$devi->id}}"> <span class="glyphicon glyphicon-refresh"></span> </a>
                    </td>
                    <td>
                        <a href="/devis/view?id={{$devi->id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        /<a href="/devis/download?id={{$devi->id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('modals')
    @include('includes.popups')
@endsection

@section('footer')

    <script>
        @if (count($errors) > 0)
            $('#errorModal').modal('show');
            $('#titleError').html('Ce devis ne peut pas être restauré');
        @endif

        @if (isset($message))
            $("#modalSuccess").modal('toggle');
        @endif
    </script>
    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/devisShow.js") }}"> </script>
@endsection