/**
 * Created by dn on 08.10.18.
 */

window.openCandleGraph = function(id, data) {
    // create the chart
    chartOptions = {

        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'AAPL Stock Price'
        },

        series: [{
            type: 'candlestick',
            name: 'AAPL Stock Price',
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
            }
        }]
    };
    // Create the chart
    Highcharts.chart(id, chartOptions);
};

