/**
 * Created by dn on 08.10.18.
 */
$(document).ready(function () {

    window.openGraph = function(id, data)
    {
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
    };

});