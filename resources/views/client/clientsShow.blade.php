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
                    <th>Date creation</th>
                    <th>Date Modfication</th>
                    <th>Adresse</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone portable</th>
                    <th>Telephone fixe</th>
                    <th>Date creation</th>
                    <th>Date Modfication</th>
                    <th>Adresse</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@section('modals')

    @include('includes.clientModals')

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
    <script src="{{ asset("js/steps.js") }}"> </script>
    <script src="{{ asset("js/clientShow.js") }}"> </script>
    <script src="{{ asset("js/modifJS.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection