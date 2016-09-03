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

            var chart = new CanvasJS.Chart("chartContainer3",
                {
                    title:{
                        text: "Olympic Medals of all Times (till 2012 Olympics)"
                    },
                    animationEnabled: true,
                    legend: {
                        cursor:"pointer",
                        itemclick : function(e) {
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
                        title: "Medals"
                    },
                    toolTip: {
                        shared: true,
                        content: function(e){
                            var str = '';
                            var total = 0 ;
                            var str3;
                            var str2 ;
                            for (var i = 0; i < e.entries.length; i++){
                                var  str1 = "<span style= 'color:"+e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ;
                                total = e.entries[i].dataPoint.y + total;
                                str = str.concat(str1);
                            }
                            str2 = "<span style = 'color:DodgerBlue; '><strong>"+e.entries[0].dataPoint.label + "</strong></span><br/>";
                            str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";

                            return (str2.concat(str)).concat(str3);
                        }

                    },
                    data: [
                        {
                            type: "bar",
                            showInLegend: true,
                            name: "Silver",
                            color: "silver",
                            dataPoints: [
                                { y: 166, label: "Italy"},
                                { y: 144, label: "China"},
                                { y: 223, label: "France"},
                                { y: 272, label: "Great Britain"},
                                { y: 319, label: "Soviet Union"},
                                { y: 759, label: "USA"},
                                { y: 166, label: "Italy"},
                                { y: 144, label: "China"},
                                { y: 223, label: "France"},
                                { y: 272, label: "Great Britain"},
                                { y: 319, label: "Soviet Union"},
                                { y: 759, label: "USA"}
                            ]
                        },
                        {
                            type: "bar",
                            showInLegend: true,
                            name: "Bronze",
                            color: "#A57164",
                            dataPoints: [
                                { y: 185, label: "Italy"},
                                { y: 128, label: "China"},
                                { y: 246, label: "France"},
                                { y: 272, label: "Great Britain"},
                                { y: 296, label: "Soviet Union"},
                                { y: 666, label: "USA"},
                                { y: 185, label: "Italy"},
                                { y: 128, label: "China"},
                                { y: 246, label: "France"},
                                { y: 272, label: "Great Britain"},
                                { y: 296, label: "Soviet Union"},
                                { y: 666, label: "USA"}

                            ]
                        }

                    ]
                });

            chart.render();

        });
    </script>
@endsection