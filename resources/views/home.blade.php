@extends('layouts.layout')


@section('header')
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-datatable.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style type="text/css"> .pac-container { z-index: 1051 !important; } </style>
    <meta name="_token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/jquery.popconfirm.js')}}"></script>

@endsection

@section('title')
    Statistiques
@endsection


@section('content')


    <div id="chartContainer1" style="height: 240px; width: 100%;"></div>
    <div id="chartContainer2" style="height: 240px; width: 100%;"></div>
    <div id="chartContainer3" style="height: 240px; width: 100%;"></div>
    <div id="chartContainer4" style="height: 240px; width: 100%;"></div>

@endsection

@section('modals')

@endsection


@section('footer')
    <script src="{{ asset("js/tableTools.js") }}"> </script>
    <script src="{{ asset("js/steps.js") }}"> </script>
    <script src="{{ asset("js/modifJS.js") }}"> </script>
    <script src="{{ asset("js/mapsJS.js") }}"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE&signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: '/facture/year/cumul?y=' + new Date().getFullYear() + '&pred=1',
                type: "GET",
                success: function (data) {
                    console.log(data);
                    var options1 = {
                        title: {
                            text: "Prediction du revenue cumule de l'annee " + new Date().getFullYear()
                        },
                        animationEnabled: true,
                        data: [
                            {
                                type: "spline", //change it to line, area, bar, pie, etc
                                dataPoints: data
                            }
                        ],
                        axisX: {
                            labelFontSize: 14
                        },
                        axisY: {
                            labelFontSize: 14
                        }
                    };
                    $("#chartContainer2").CanvasJSChart(options1);
                }, error: function () {
                    alert("error!!!!");
                }
            });


            $.ajax({
                url: '/facture/year?y='+new Date().getFullYear()+'&pred=1',
                type:"GET",
                success:function(data){
                    console.log(data);
                    var options1 = {
                        title: {
                            text: "Prediction du revenue de l'annee "+new Date().getFullYear()
                        },
                        animationEnabled: true,
                        data: [
                            {
                                type: "spline", //change it to line, area, bar, pie, etc
                                dataPoints: data
                            }
                        ],
                        axisX: {
                            labelFontSize: 14
                        },
                        axisY: {
                            labelFontSize: 14
                        }
                    };
                    $("#chartContainer1").CanvasJSChart(options1);
                },error:function(){
                    alert("error!!!!");
                }
            });
        });
    </script>
@endsection