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
            "dataProvider": [{
                "date": "2012-01-01",
                "money": 643,
            }, {
                "date": "2012-01-02",
                "money": 371,
            }, {
                "date": "2012-01-03",
                "money": 433,
            }, {
                "date": "2012-01-04",
                "money": 345,
            }, {
                "date": "2012-01-05",
                "money": 480,
            }, {
                "date": "2012-01-06",
                "money": 386,
            }, {
                "date": "2012-01-07",
                "money": 348,
            }, {
                "date": "2012-01-08",
                "money": 238,
            }, {
                "date": "2012-01-09",
                "money": 218,
            }, {
                "date": "2012-01-10",
                "money": 349,
            }, {
                "date": "2012-01-11",
                "money": 603,
            }, {
                "date": "2012-01-12",
                "money": 534,
            }, {
                "date": "2012-01-13",
            }, {
                "date": "2012-01-14",
            }],
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