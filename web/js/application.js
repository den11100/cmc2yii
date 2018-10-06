/**
 * Created by alfred on 23.09.18.
 */
$(document).ready(function () {
    $('.main-table').dragtable();

    $(".visual-td").on("click", function(){
        $(".popup, .popup-content").addClass("active");
        var id = $(this).data('id');
        var data = $(this).data('data');
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
                data: data,
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
}