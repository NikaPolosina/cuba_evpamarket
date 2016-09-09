

var ChartsAmcharts = function() {
    var initChartSample2 = function() {
        var chart = AmCharts.makeChart("chart_2", {
            "type": "serial",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color":    '#888888',
            "legend": {
                "equalWidths": false,
                "useGraphSettings": true,
                "valueAlign": "left",
                "valueWidth": 120
            },
            "dataProvider": data,
            "valueAxes": [{
                "id": "moneyAxis",
                "axisAlpha": 0,

                "position": "left",
                "title": "Рублей"
            }],
            "graphs": [{
                "balloonText": "[[value]] руб.",
                "fillAlphas": 0.7,
                "legendPeriodValueText": "всего: [[value.sum]] рублей",
                "title": "Деньги",
                "type": "column",
                "valueField": "money",
                "valueAxis": "moneyAxis"
            }],
            "chartCursor": {
                "cursorAlpha": 0.1,
                "cursorColor": "#000000",
                "fullWidth": true,
                "valueBalloonsEnabled": false,
                "zoomable": false
            },
            "dataDateFormat": "YYYY-MM-DD",
            "categoryField": "date",
            "categoryAxis": {
                "dateFormats": [{
                    "period": "DD",
                    "format": "DD"
                }, {
                    "period": "WW",
                    "format": "MMM DD"
                }, {
                    "period": "MM",
                    "format": "MMM"
                }, {
                    "period": "YYYY",
                    "format": "YYYY"
                }],
                "parseDates": true,
                "autoGridCount": false,
                "axisColor": "#555555",
                "gridAlpha": 0.1,
                "gridColor": "#FFFFFF",
                "gridCount": 50
            },

        });

        $('#chart_2').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            initChartSample2();

        }
    };

}();

jQuery(document).ready(function() {    
   ChartsAmcharts.init(); 
});