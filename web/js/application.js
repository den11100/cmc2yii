/**
 * Created by alfred on 23.09.18.
 */
$(document).ready(function () {
    $('.main-table').dragtable();

    $(".visual-td").on("click", function(){
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
                formatter: function() {
                    return '$'+ this.y;
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

    $(".close, .popup").on("click", function(){
        $(".popup, .popup-content").removeClass("active");
    });

});

window.openGraph = function(id, data)
{
    chartOptions = {
        title: '',
        chart: {
            backgroundColor:'rgba(255, 255, 255, 0.0)',
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
            formatter: function() {
                return '$'+ this.y;
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
            labels:
                {
                    enabled: false
                },
            visible: false,
        }],
        yAxis: [{
            labels:
                {
                    enabled: false
                },
            visible: false,
            startOnTick: true,
        }],
    };

    // Create the chart
    Highcharts.chart(id, chartOptions);
};



window.openCandleGraph = function(id, data, name, volumes) {

    console.log('id');
    console.log(id);
    console.log('data');
    console.log(data);
    console.log('name');
    console.log(name);
    console.log('volumes');
    console.log(volumes);

    var options = {
        "colors": ["rgba(132, 184, 235, 0.7)", "rgba(46, 204, 113, 0.7)", "rgba(155, 89, 182, 0.7)", "rgba(231, 76, 60, 0.7)", "rgba(52, 73, 94, 0.7)", "rgba(241, 196, 15, 0.7)", "rgba(26, 188, 156, 0.7)", "rgba(243, 156, 18, 0.7)", "rgba(211, 84, 0, 0.7)"],
        "symbols": ["circle", "diamond", "square", "triangle", "triangle-down"],
        "lang": {
            "loading": "Loading...",
            "months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            "shortMonths": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            "weekdays": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "decimalPoint": ".",
            "numericSymbols": ["k", "M", "G", "T", "P", "E"],
            "resetZoom": "Reset zoom",
            "resetZoomTitle": "Reset zoom level 1:1",
            "thousandsSep": " ",
            "rangeSelectorZoom": "",
            "rangeSelectorFrom": "From",
            "rangeSelectorTo": "To"
        },
        "global": {"useUTC": false},
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
        "subtitle": {
            "style": {"color": "#666666", "fill": "#666666", "width": "1046px"},
            "text": "",
            "align": "center",
            "widthAdjust": -44
        },
        "plotOptions": {
            "line": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": {
                    "lineWidth": 0,
                    "lineColor": "#ffffff",
                    "radius": 2,
                    "states": {
                        "hover": {
                            "animation": {"duration": 50},
                            "enabled": true,
                            "radiusPlus": 2,
                            "lineWidthPlus": 1
                        }, "select": {"fillColor": "#cccccc", "lineColor": "#000000", "lineWidth": 2}
                    },
                    "enabled": false
                },
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": true,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25}
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "tooltip": {}
            },
            "area": {
                "lineWidth": 1,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": false,
                "events": {},
                "marker": {
                    "lineWidth": 0,
                    "lineColor": "#ffffff",
                    "radius": 2,
                    "states": {
                        "hover": {
                            "animation": {"duration": 50},
                            "enabled": true,
                            "radiusPlus": 2,
                            "lineWidthPlus": 1
                        }, "select": {"fillColor": "#cccccc", "lineColor": "#000000", "lineWidth": 2}
                    },
                    "enabled": false
                },
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25}
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "threshold": 0,
                "fillOpacity": 0.3,
                "tooltip": {}
            },
            "spline": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": {
                    "lineWidth": 0,
                    "lineColor": "#ffffff",
                    "radius": 2,
                    "states": {
                        "hover": {
                            "animation": {"duration": 50},
                            "enabled": true,
                            "radiusPlus": 2,
                            "lineWidthPlus": 1
                        }, "select": {"fillColor": "#cccccc", "lineColor": "#000000", "lineWidth": 2}
                    },
                    "enabled": false
                },
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": true,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25}
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "tooltip": {}
            },
            "areaspline": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": {
                    "lineWidth": 0,
                    "lineColor": "#ffffff",
                    "radius": 2,
                    "states": {
                        "hover": {
                            "animation": {"duration": 50},
                            "enabled": true,
                            "radiusPlus": 2,
                            "lineWidthPlus": 1
                        }, "select": {"fillColor": "#cccccc", "lineColor": "#000000", "lineWidth": 2}
                    },
                    "enabled": false
                },
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25}
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "threshold": 0,
                "tooltip": {}
            },

            "bar": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": null,
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": null,
                    "x": 0,
                    "y": null,
                    "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1
                    }, "select": {"marker": {}, "color": "#cccccc", "borderColor": "#000000"}
                },
                "stickyTracking": false,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "borderRadius": 0,
                "crisp": true,
                "groupPadding": 0.2,
                "pointPadding": 0.1,
                "minPointLength": 0,
                "startFromThreshold": true,
                "threshold": 0,
                "borderColor": "#ffffff"
            },
            "scatter": {
                "lineWidth": 0,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": {
                    "lineWidth": 0,
                    "lineColor": "#ffffff",
                    "radius": 4,
                    "states": {
                        "hover": {
                            "animation": {"duration": 50},
                            "enabled": true,
                            "radiusPlus": 2,
                            "lineWidthPlus": 1
                        }, "select": {"fillColor": "#cccccc", "lineColor": "#000000", "lineWidth": 2}
                    },
                    "enabled": true
                },
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": true,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25}
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "xy"
            },
            "pie": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "bottom",
                    "x": 0,
                    "y": 0,
                    "padding": 5,
                    "distance": 30,
                    "enabled": true
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": true,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": {"size": 10, "opacity": 0.25},
                        "brightness": 0.1,
                        "shadow": false
                    }, "select": {"marker": {}}
                },
                "stickyTracking": false,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "center": [null, null],
                "clip": false,
                "colorByPoint": true,
                "ignoreHiddenPoint": true,
                "legendType": "point",
                "size": null,
                "showInLegend": false,
                "slicedOffset": 10,
                "borderColor": "#ffffff",
                "borderWidth": 1
            },
            "ohlc": {
                "lineWidth": 1,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": null,
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": null,
                    "x": 0,
                    "y": null,
                    "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1,
                        "lineWidth": 3
                    }, "select": {"marker": {}, "color": "#cccccc", "borderColor": "#000000"}
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
                "shadow": false,
                "borderWidth": 0
            },
            "candlestick": {
                "lineWidth": 1,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": null,
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": null,
                    "x": 0,
                    "y": null,
                    "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1,
                        "lineWidth": 2
                    }, "select": {"marker": {}, "color": "#cccccc", "borderColor": "#000000"}
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
                "dataGrouping": {"enabled": true, "groupPixelWidth": 12, "approximation": "ohlc"}
            },
            "flags": {
                "lineWidth": 1,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": null,
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": null,
                    "x": 0,
                    "y": null,
                    "padding": 5
                },
                "cropThreshold": 50,
                "pointRange": 0,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1,
                        "lineColor": "#000000",
                        "fillColor": "#ccd6eb"
                    }, "select": {"marker": {}, "color": "#cccccc", "borderColor": "#000000"}
                },
                "stickyTracking": false,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "borderRadius": 0,
                "crisp": true,
                "groupPadding": 0.2,
                "pointPadding": 0.1,
                "minPointLength": 0,
                "startFromThreshold": true,
                "threshold": null,
                "borderColor": "#ffffff",
                "shape": "flag",
                "stackDistance": 12,
                "textAlign": "center",
                "y": -30,
                "fillColor": "#ffffff",
                "style": {"fontSize": "11px", "fontWeight": "bold"}
            },
            "treemap": {
                "lineWidth": 0,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": false,
                "point": {"events": {}},
                "dataLabels": {
                    "align": "center",
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": "middle",
                    "x": 0,
                    "y": 0,
                    "padding": 5,
                    "enabled": true,
                    "defer": false,
                    "inside": true
                },
                "cropThreshold": 300,
                "pointRange": 0,
                "softThreshold": true,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "borderColor": "#999999",
                        "brightness": 0.1,
                        "opacity": 0.75,
                        "shadow": false
                    }, "select": {"marker": {}}
                },
                "stickyTracking": true,
                "turboThreshold": 1000,
                "findNearestPointBy": "xy",
                "showInLegend": false,
                "ignoreHiddenPoint": true,
                "layoutAlgorithm": "sliceAndDice",
                "layoutStartingDirection": "vertical",
                "alternateStartingDirection": false,
                "levelIsConstant": true,
                "drillUpButton": {"position": {"align": "right", "x": -10, "y": 10}},
                "borderColor": "#e6e6e6",
                "borderWidth": 1,
                "opacity": 0.15
            },
            "sankey": {
                "lineWidth": 2,
                "allowPointSelect": false,
                "showCheckbox": false,
                "animation": {"duration": 1000},
                "events": {},
                "marker": null,
                "point": {"events": {}},
                "dataLabels": {
                    "align": null,
                    "style": {
                        "fontSize": "11px",
                        "fontWeight": "bold",
                        "color": "contrast",
                        "textOutline": "1px contrast"
                    },
                    "verticalAlign": null,
                    "x": 0,
                    "y": null,
                    "padding": 5,
                    "enabled": true,
                    "backgroundColor": "none",
                    "crop": false,
                    "inside": true
                },
                "cropThreshold": 50,
                "pointRange": null,
                "softThreshold": false,
                "states": {
                    "hover": {
                        "animation": {"duration": 50},
                        "lineWidthPlus": 1,
                        "marker": {},
                        "halo": false,
                        "brightness": 0.1,
                        "linkOpacity": 1
                    }, "select": {"marker": {}, "color": "#cccccc", "borderColor": "#000000"}
                },
                "stickyTracking": false,
                "turboThreshold": 1000,
                "findNearestPointBy": "x",
                "borderRadius": 0,
                "crisp": true,
                "groupPadding": 0.2,
                "pointPadding": 0.1,
                "minPointLength": 0,
                "startFromThreshold": true,
                "threshold": 0,
                "borderColor": "#ffffff",
                "colorByPoint": true,
                "curveFactor": 0.33,
                "linkOpacity": 0.5,
                "nodeWidth": 20,
                "nodePadding": 10,
                "showInLegend": false
            },
            "arearange": {"marker": {"enabled": false, "radius": 2}, "tooltip": {}},
            "areasplinerange": {"marker": {"enabled": false, "radius": 2}, "tooltip": {}},
            "columnrange": {"shadow": false, "borderWidth": 0, "tooltip": {}},
            "series": {
                "animation": false,
                "lineWidth": 1,
                "dataGrouping": {"enabled": true, "groupPixelWidth": 3, "approximation": "close"},
                "tooltip": {}
            }
        },
        "labels": {"style": {"position": "absolute", "color": "#333333"}},
        "legend": {
            "enabled": true,
            "align": "center",
            "layout": "horizontal",
            "borderColor": "#999999",
            "borderRadius": 0,
            "navigation": {"activeColor": "#003399", "inactiveColor": "#cccccc"},
            "itemStyle": {
                "color": "#333333",
                "fontSize": "12px",
                "fontWeight": "bold",
                "textOverflow": "ellipsis",
                "cursor": "pointer"
            },
            "itemHoverStyle": {"color": "#000000"},
            "itemHiddenStyle": {"color": "#cccccc"},
            "shadow": false,
            "itemCheckboxStyle": {"position": "absolute", "width": "13px", "height": "13px"},
            "squareSymbol": true,
            "symbolPadding": 5,
            "verticalAlign": "bottom",
            "x": 0,
            "y": 0,
            "title": {"style": {"fontWeight": "bold"}},
            "padding": 0,
            "itemMarginBottom": 0,
            "itemMarginTop": 0
        },
        "loading": {
            "labelStyle": {"fontWeight": "bold", "position": "relative", "top": "45%"},
            "style": {
                "position": "absolute",
                "backgroundColor": "#ffffff",
                "opacity": 0.5,
                "textAlign": "center",
                "zIndex": 10
            }
        },
        "tooltip": {
            "enabled": true,
            "animation": true,
            "borderRadius": 3,
            "dateTimeLabelFormats": {
                "millisecond": "%A, %b %e, %H:%M:%S.%L",
                "second": "%A, %b %e, %H:%M:%S",
                "minute": "%A, %b %e, %H:%M",
                "hour": "%A, %b %e, %H:%M",
                "day": "%A, %b %e, %Y",
                "week": "Week from %A, %b %e, %Y",
                "month": "%B %Y",
                "year": "%Y"
            },
            "footerFormat": "",
            "padding": 8,
            "snap": 10,
            "backgroundColor": "rgba(247,247,247,0.85)",
            "borderWidth": 1,
            "headerFormat": "<span style=\"font-size: 10px\">{point.key}</span><br/>",
            "pointFormat": "<span style=\"color:{point.color}\">●</span> {series.name}: <b>{point.y}</b><br/>",
            "shadow": true,
            "style": {
                "color": "#333333",
                "cursor": "default",
                "fontSize": "12px",
                "pointerEvents": "none",
                "whiteSpace": "nowrap"
            },
            "split": true,
            "crosshairs": true,
            "useHTML": true,
            "userOptions": {"split": true, "crosshairs": true, "useHTML": true}
        },
        "credits": {
            "enabled": false,
            "href": "http://www.highcharts.com",
            "position": {"align": "right", "x": -10, "verticalAlign": "bottom", "y": -5},
            "style": {"cursor": "pointer", "color": "#999999", "fontSize": "9px"},
            "text": "Highcharts.com"
        },
        "scrollbar": {
            "height": 14,
            "barBorderRadius": 0,
            "buttonBorderRadius": 0,
            "liveRedraw": false,
            "margin": 10,
            "minWidth": 6,
            "step": 0.2,
            "zIndex": 3,
            "barBackgroundColor": "#cccccc",
            "barBorderWidth": 1,
            "barBorderColor": "#cccccc",
            "buttonArrowColor": "#333333",
            "buttonBackgroundColor": "#e6e6e6",
            "buttonBorderColor": "#cccccc",
            "buttonBorderWidth": 1,
            "rifleColor": "#333333",
            "trackBackgroundColor": "#f2f2f2",
            "trackBorderColor": "#f2f2f2",
            "trackBorderWidth": 1,
            "enabled": false
        },
        "rangeSelector": {
            selected: 2,
            buttons: [{
                type: 'day',
                count: 7,
                text: '7d'
            }, {
                type: 'day',
                count: 14,
                text: '14d'
            }, {
                type: 'all',
                text: 'All'
            }]
        },
        "legendBackgroundColor": "rgba(0, 0, 0, 0.5)",
        "background2": "#505053",
        "dataLabelsColor": "#B0B0B3",
        "textColor": "#34495e",
        "contrastTextColor": "#F0F0F3",
        "maskColor": "rgba(255,255,255,0.3)",
        "responsive": {
            "rules": [{
                "condition": {"maxWidth": 768},
                "chartOptions": {"chart": {"spacing": [10, 0, 10, 0]}},
                "_id": "highcharts-dsxxqvm-50"
            }]
        },
        "series": [ {
            type: 'candlestick',
            name: name + ' Stock Price',
            data: data,
            dataGrouping: {
                units: [
                    [
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 4, 6]
                    ]
                ]
            },
        },{
            "name": "Total volume",
            "type": "column",
            "data": volumes,
            "zIndex": 0,
            "id": "mainvolume"
        },
            {
                "name": "Avg. BTCUSD",
                "type": "area",
                "data": data,
                "zIndex": 2,
                "_colorIndex": 0,
                "_symbolIndex": 0
            },],
        "isStock": true
    }

    /*var options = {
        plotOptions: {
            candlestick: {
                color: 'green',
                upColor: 'red'
            }
        },
        rangeSelector: {
            selected: 2,
            buttons: [{
                type: 'day',
                count: 7,
                text: '7d'
            }, {
                type: 'day',
                count: 14,
                text: '14d'
            }, {
                type: 'all',
                text: 'All'
            }]
        },

        title: {
            text: name + ' Stock Price'
        },

        series: [{
            type: 'candlestick',
            name: name + ' Stock Price',
            data: data,
            dataGrouping: {
                units: [
                    [
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 4, 6]
                    ]
                ]
            },
        },{
            "name": "Total volume",
            "type": "column",
            "data": volumes,
            "zIndex": 0,
            "id": "mainvolume"
        }]
    };*/

    Highcharts.stockChart(id, options);
};


