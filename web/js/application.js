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
            navigation: {
                buttonOptions: {
                    enabled: false
                }
            },
            yAxis: [{
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'Price'
                },
                height: '60%',
                lineWidth: 2,
                resize: {
                    enabled: true
                }
            }, {
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'Volume'
                },
                top: '65%',
                height: '35%',
                offset: 0,
                lineWidth: 2
            }],

            series: [{
                name: 'Price',
                type: 'spline',
                data: data,
            }, {
                name: 'Volume',
                type: 'column',
                data: dataColumns,
                yAxis: 1,
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
        navigation: {
            buttonOptions: {
                enabled: false,
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
            "height": 600,
            "borderColor": "#335cad",
            "backgroundColor": "#F7FaFb",
            "plotBorderColor": "#cccccc",
            "panning": true,
            "pinchType": "none",
            "zoomType": "xy",
            "events": {}
        },
        "title": {
            "style": {"color": "#333333", "fontSize": "16px", "fill": "#333333", "width": "1046px"},
            "text": null,
            "align": "center",
            "margin": 15,
            "widthAdjust": -44
        },
        "xAxis":{
            minRange: 60*60*1000
        },
        "yAxis": [{ // Primary yAxis
            labels: {
                align: 'right',
                x: 10,
                format: '{value} $',
                style: {
                    color: "#ffbd16"
                }
            },
            title: {
                text: 'Price',
                style: {
                    color: "#ffbd16"
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Volume',
                style: {
                    color: "#ff14dc"
                }
            },
            labels: {
                format: '{value} k $',
                style: {
                    color: "#ff14dc"
                }
            },
            opposite: false
        }],
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
                },
                "events": {},
                "marker": null,
                "point": {
                    "events": {}
                },
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
            // "series": {
            //     "animation": false,
            //     "lineWidth": 1,
            //     "dataGrouping": {"enabled": true, "groupPixelWidth": 3, "approximation": "close"},
            //     "tooltip": {}
            // }
        },
        "labels": {"style": {"position": "absolute", "color": "#333333"}},
        "rangeSelector": {
            allButtonsEnabled: true,
            selected: 4,
            buttons: [
            {
                type: 'minute',
                count: 60,
                text: '1h',
                dataGrouping: {
                    forced: true,
                    units: [['minute', [1]]]
                }
            },
            {
                type: 'minute',
                count: 240,
                text: '4h',
                dataGrouping: {
                    forced: true,
                    units: [['minute', [1]]]
                }
            }, {
                type: 'minute',
                count: 1440,
                text: '24h',
                dataGrouping: {
                    forced: true,
                    units: [['minute', [15]]]
                }
            }, {
                type: 'hour',
                count: 168,
                text: '7d',
                dataGrouping: {
                    forced: true,
                    units: [['hour', [4]]]
                }
            }, {
                type: 'day',
                count: 14,
                text: '14d',
                dataGrouping: {
                    forced: true,
                    units: [['day', [1]]]
                }
            }, {
                type: 'day',
                count: 30,
                text: '30d',
                dataGrouping: {
                    forced: true,
                    units: [['day', [1]]]
                }
            }, {
                type: 'day',
                count: 45,
                text: '45d',
                dataGrouping: {
                    forced: true,
                    units: [['day', [1]]]
                }
            }, {
                type: 'day',
                count: 90,
                text: '90d',
                dataGrouping: {
                    forced: true,
                    units: [['day', [1]]]
                }
            }, {
                type: 'all',
                text: 'All',
                dataGrouping: {
                    forced: true,
                    units: [['day', [1]]]
                }
            },]
        },
        // "legendBackgroundColor": "rgba(0, 0, 0, 0.5)",
        // "background2": "#505053",
        // "dataLabelsColor": "#B0B0B3",
        // "textColor": "#34495e",
        // "contrastTextColor": "#F0F0F3",
        // "maskColor": "rgba(255,255,255,0.3)",
        "navigation": {
            "buttonOptions": {
                "enabled": false
            }
        }, "series": [{
            type: 'candlestick',
            zIndex: 6,
            name: name + ' Stock Price',
            data: data,
        }, {
            name: "Total volume",
            type: "column",
            data: volumes,
            yAxis: 1,
            //zIndex: 0,
            //id: "mainvolume"
        }],
        "isStock": true

    };

    Highcharts.stockChart(id, options);
};
