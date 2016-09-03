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

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Facture Stats
            <div class="pull-right">
                <div class="btn-group">
                    <button aria-expanded="false" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        Annee
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">n</a>
                        </li>
                        <li><a href="#">n-1</a>
                        </li>
                        <li><a href="#">n-2</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div id="chartContainer1" style="height: 240px; width: 100%;"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Facture Cumul Stats
            <div class="pull-right">
                <div class="btn-group">
                    <button aria-expanded="false" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        Annee
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">n</a>
                        </li>
                        <li><a href="#">n-1</a>
                        </li>
                        <li><a href="#">n-2</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div id="chartContainer2" style="height: 240px; width: 100%;"></div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Demande Stats
            <div class="pull-right">
                <div class="btn-group">
                    <button aria-expanded="false" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        Annee
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">n</a>
                        </li>
                        <li><a href="#">n-1</a>
                        </li>
                        <li><a href="#">n-2</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div id="chartContainer3" style="height: 240px; width: 100%;"></div>
        </div>
    </div>
    <div id="chartContainer4" style="height: 240px; width: 100%;"></div>

@endsection

@section('modals')

@endsection


@section('footer')
    <script type="text/javascript">
        $(document).ready(function() {

            function getCumule (y,pred) {
                $.ajax({
                    url: '/facture/year/cumul?y=' + y + '&pred=' + pred,
                    type: "GET",
                    success: function (data) {
                        var options1 = {
                            title: {
                                text: "Prediction du revenue cumule de l'annee " + y
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
            }

            function getRevenuFacts (y,pred) {
                $.ajax({
                    url: '/facture/year?y=' + y + '&pred=' + pred,
                    type: "GET",
                    success: function (data) {
                        var options1 = {
                            title: {
                                text: "Prediction du revenue de l'annee " + y
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
                    }, error: function () {
                        alert("error!!!!");
                    }
                });
            }


            function getDemandes (y) {
                $.ajax({
                    url: '/demande/year?y=' + y,
                    type: "GET",
                    success: function (data) {
                        var chart = new CanvasJS.Chart("chartContainer3",
                                {
                                    title: {
                                        text: "Nombre des demandes "+y
                                    },
                                    animationEnabled: true,
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function (e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                                e.dataSeries.visible = false;
                                            }
                                            else {
                                                e.dataSeries.visible = true;
                                            }
                                            chart.render();
                                        }
                                    },
                                    axisY: {
                                        title: "Demandes"
                                    },
                                    toolTip: {
                                        shared: true,
                                        content: function (e) {
                                            var str = '';
                                            var total = 0;
                                            var str3;
                                            var str2;
                                            for (var i = 0; i < e.entries.length; i++) {
                                                var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                                                total = e.entries[i].dataPoint.y + total;
                                                str = str.concat(str1);
                                            }
                                            str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";
                                            str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";

                                            return (str2.concat(str)).concat(str3);
                                        }

                                    },
                                    data: [
                                        {
                                            type: "bar",
                                            showInLegend: true,
                                            name: "Finalisee",
                                            color: "silver",
                                            dataPoints: data['F']
                                        },
                                        {
                                            type: "bar",
                                            showInLegend: true,
                                            name: "Non finalisees",
                                            color: "#A57164",
                                            dataPoints: data['T']
                                        }

                                    ]
                                });
                        chart.render();
                    }
                });
            }
            getDemandes(2016);
            getRevenuFacts(2016,1);
            getCumule(2016,1);

        });
    </script>
@endsection