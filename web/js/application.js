/**
 * Created by alfred on 23.09.18.
 */
$(document).ready(function () {
    $('.main-table').dragtable();

    $(".visual-td").on("click", function () {
        $(".popup, .popup-content").addClass("active");
        var id = $(this).data('id');
        var data = $(this).data('data');
        var dataColumns = $(this).data('columns');
        console.log(dataColumns);
        chartOptions = {
            title: '',
            plotOptions: {
                series: {
                    showInLegend: false,
                    label: {
                        connectorAllowed: false
                    },
                },
                line: {
                    marker: {
                        enabled: false
                    },
                    color: '#FF0000',
                }
            },
            tooltip: {
                formatter: function () {
                    return '$' + this.y;
                }
            },
            series: [{
                name: '',
                type: 'spline',
                data: data,
            }, {
                name: '',
                type: 'column',
                data: dataColumns,
            }],
        };

        // Create the chart
        Highcharts.chart(id, chartOptions);
    });

    $(".close, .popup").on("click", function () {
        $(".popup, .popup-content").removeClass("active");
    });

});

window.openGraph = function (id, data) {
    chartOptions = {
        title: '',
        chart: {
            backgroundColor: 'rgba(255, 255, 255, 0.0)',
        },
        plotOptions: {
            series: {
                showInLegend: false,
                className: 'main-color',
                negativeColor: true,
                label: {
                    connectorAllowed: false
                },
            },
            area: {
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                return '$' + this.y;
            }
        },
        series: [{
            threshold: data[6],
            type: 'area',
            name: '',
            data: data,
        }],
        legend: [{
            enabled: false,
        }],
        xAxis: [{
            labels: {
                enabled: false
            },
            visible: false,
        }],
        yAxis: [{
            labels: {
                enabled: false
            },
            visible: false,
            startOnTick: true,
        }],
    };

    // Create the chart
    Highcharts.chart(id, chartOptions);
};


window.openCandleGraph = function (id, data, name, volumes) {
    var options = {
        "chart": {
            "borderRadius": 0,
            "defaultSeriesType": "line",
            "ignoreHiddenSeries": true,
            "spacing": [10, 10, 15, 10],
            "resetZoomButton": {"theme": {"zIndex": 20}, "position": {"align": "right", "x": -10, "y": 10}},
            "width": null,
            "height": null,
            "borderColor": "#335cad",
            "backgroundColor": "#F7FaFb",
            "plotBorderColor": "#cccccc",
            "panning": true,
            "pinchType": "none",
            "zoomType": "x",
            "events": {}
        },
        "title": {
            "style": {"color": "#333333", "fontSize": "16px", "fill": "#333333", "width": "1046px"},
            "text": null,
            "align": "center",
            "margin": 15,
            "widthAdjust": -44
        },
        "plotOptions": {
            "column": {
                "lineWidth": 4,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": false,
                "marker": null,
                "dataLabels": {
                    "align": null, "style": {
                        "fontSize": "11px", "fontWeight": "bold", "color": "contrast", "textOutline": "1px contrast"
                    },
                    "verticalAlign": null, "x": 0, "y": null, "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {
                            "duration": 50
                        },
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1
                    },
                    "select": {
                        "marker": {},
                        "color": "#cccccc", "borderColor": "#000000"
                    }
                },
                "stickyTracking": false,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "borderRadius": 0,
                "crisp": true,
                "groupPadding": 0.1,
                "pointPadding": 0.1,
                "minPointLength": 0,
                "startFromThreshold": true,
                "tooltip": {},
                "threshold": 0,
                "borderColor": "rgba(132, 184, 235, 0.8)",
                "shadow": false,
                "borderWidth": 0,
                "color": "rgba(132, 184, 235, 0.8)",
                "stacking": "normal",
                "showInLegend": false,
                "dataGrouping": {
                    "enabled": true, "groupPixelWidth": 3, "approximation": "sum"
                }
            },
            "candlestick": {
                "lineWidth": 1,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {
                    "duration": 1000
                }
                ,
                "events": {}
                ,
                "marker": null,
                "point": {
                    "events": {}
                },
                "dataLabels": {
                    "align": null, "style": {
                        "fontSize": "11px", "fontWeight": "bold", "color": "contrast", "textOutline": "1px contrast"
                    }
                    ,
                    "verticalAlign": null, "x": 0, "y": null, "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {
                            "duration": 50
                        },
                        "lineWidthPlus": 1, "marker": {},
                        "halo": false, "brightness": 0.1, "lineWidth": 2
                    },
                    "select": {
                        "marker": {},
                        "color": "#cccccc",
                        "borderColor": "#000000"
                    }
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "borderRadius": 0,
                "crisp": true,
                "groupPadding": 0.2,
                "pointPadding": 0.1,
                "minPointLength": 0,
                "startFromThreshold": true,
                "tooltip": {},
                "threshold": null,
                "borderColor": "#ffffff",
                "lineColor": "green",
                "upColor": "green",
                "shadow": false,
                "borderWidth": 0,
                "color": "red",
                "upLineColor": "red",
                "dataGrouping": {
                    "enabled": true, "groupPixelWidth": 12, "approximation": "ohlc"
                }
            },
            "columnrange": {"shadow": false, "borderWidth": 0, "tooltip": {}},
            "series": {
                "animation": false,
                "lineWidth": 1,
                "dataGrouping": {"enabled": true, "groupPixelWidth": 3, "approximation": "close"},
                "tooltip": {}
            }
        },
        "labels": {"style": {"position": "absolute", "color": "#333333"}},
        "rangeSelector": {
            selected: 2,
            buttons: [
            {
                type: 'h',
                count: 1,
                text: '1h'
            },
            {
                type: 'h',
                count: 4,
                text: '4h'
            }, {
                type: 'h',
                count: 24,
                text: '24h'
            }, {
                type: 'h',
                count: 7,
                text: '7d'
            }, {
                type: 'day',
                count: 14,
                text: '14d'
            }, {
                type: 'day',
                count: 30,
                text: '30d'
            }, {
                type: 'day',
                count: 45,
                text: '45d'
            }, {
                type: 'day',
                count: 90,
                text: '90d'
            }, {
                    type: 'day',
                    count: 200,
                    text: '200d'
            },]
        },
        "legendBackgroundColor": "rgba(0, 0, 0, 0.5)",
        "background2": "#505053",
        "dataLabelsColor": "#B0B0B3",
        "textColor": "#34495e",
        "contrastTextColor": "#F0F0F3",
        "maskColor": "rgba(255,255,255,0.3)",
        "series": [{
            type: 'candlestick',
            "zIndex": 6,
            name: name + ' Stock Price',
            data: data,
            dataGrouping: {
                units: [
                    [
                        'day', // unit name
                        [1, 2, 3, 4, 5] // allowed multiples
                    ],
                    [
                        'week', // unit name
                        [1, 2, 3, 4] // allowed multiples
                    ], [
                        'month',
                        [1]
                    ]
                ]
            },
        }, {
            "name": "Total volume",
            "type": "column",
            "data": volumes,
            "zIndex": 0,
            "id": "mainvolume"
        }],
        "isStock": true
    }

    Highcharts.stockChart(id, options);
};
