@extends('layouts.layout')

@section('title')
    Statistiques {{$client->nom}} {{$client->prenom}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Statistiques</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Stats
            <div class="pull-right">
                <div class="btn-group">
                    <button aria-expanded="false" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        Annee
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#" id="currYear" data-id="{{Carbon\Carbon::now()->year}}" class="changeYear">{{Carbon\Carbon::now()->year}}</a>
                        </li>
                        <li><a href="#" id="prevYear" data-id="{{Carbon\Carbon::now()->year-1}}" class="changeYear">{{Carbon\Carbon::now()->year-1}}</a>
                        </li>
                        <li><a href="#" id="beforeLastYear" data-id="{{Carbon\Carbon::now()->year-2}}" class="changeYear">{{Carbon\Carbon::now()->year-2}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="chartContainer1" style="height: 240px; width: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chartContainer2" style="height: 240px; width: 100%;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="chartContainer4" style="height: 240px; width: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chartContainer3" style="height: 240px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-default" href="/client/profile?id={{$client->id}}">
        <span class="glyphicon glyphicon-arrow-left"></span>Retour
    </a>
@endsection

@section('footer')
    <script type="text/javascript">
    $(document).ready(function() {

        $("#statButt").on('click',function (e) {
            e.preventDefault();
            $("#statModal").modal('show');
        });

        function getCumule (y,pred) {
            $.ajax({
                url: '/facture/year/cumul?y=' + y + '&pred=' + pred + '&id={{$client->id}}',
                type: "GET",
                success: function (data) {
                    var options1 = {
                        title: {
                            text: "Revenue cumule de l'annee " + y,
                            fontSize : 14
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
                url: '/facture/year?y=' + y + '&pred=' + pred + '&id={{$client->id}}',
                type: "GET",
                success: function (data) {
                    var options1 = {
                        title: {
                            text: "Revenue de l'annee " + y,
                            fontSize : 14
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

        function getRevenuFactsPred (y) {
            $.ajax({
                url: '/facture/year?y=' + y + '&pred=1' + '&id={{$client->id}}',
                type: "GET",
                success: function (data) {
                    var options1 = {
                        title: {
                            text: "Prediction du revenue de l'annee " + y,
                            fontSize : 14
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
                    $("#chartContainer4").CanvasJSChart(options1);
                }, error: function () {
                    alert("error!!!!");
                }
            });
        }


        function getDemandes (y) {
            $.ajax({
                url: '/demande/year?y=' + y + '&id={{$client->id}}',
                type: "GET",
                success: function (data) {
                    var chart = new CanvasJS.Chart("chartContainer3",
                            {
                                title: {
                                    text: "Nombre des demandes "+y,
                                    fontSize : 14
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

        $('.changeYear').on('click',function (e) {
            e.preventDefault();
            var y = $(this).attr('data-id');
            getDemandes(y);
            getRevenuFacts(y,0);
            getRevenuFactsPred(y);
            getCumule(y,0);
        });


        getDemandes(new Date().getFullYear());
        getRevenuFacts(new Date().getFullYear(),0);
        getRevenuFactsPred(new Date().getFullYear());
        getCumule(new Date().getFullYear(),0);
    });
</script>
@endsection