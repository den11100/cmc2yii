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