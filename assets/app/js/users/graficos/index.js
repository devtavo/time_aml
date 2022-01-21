var rango_fecha = $('input.input-dt');
var fecha_inicio = moment().subtract(29, 'days');
var fecha_final = moment();

var AppGraficos = function() {
    var init = function() {
        rango_fecha.daterangepicker({
            "locale": drp_es,
            showWeekNumbers: true,
            showISOWeekNumbers: true,
            startDate: fecha_inicio,
            endDate: fecha_final,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Mes actual': [moment().startOf('month'), moment().endOf('month')],
                'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        Highcharts.Chart.prototype.viewData = function() {
            if (!this.insertedTable) {
                var div = document.createElement('div');
                div.className = 'highcharts-data-table';
                // Insert after the chart container
                this.renderTo.parentNode.insertBefore(div, this.renderTo.nextSibling);
                div.innerHTML = this.getTable();
                this.insertedTable = true;
                div.id = this.container.id + '-data-table';
            } else {
                $('#' + this.container.id + '-data-table').toggle();
            }
        };

        initChart();
        initDate('datepicker1');
        initDate('datepicker2');
    }

    var initDate = function(dt) {
        $('#' + dt).datepicker({
            autoclose: true,
            weekStart: 1,
            calendarWeeks: true
        }).on('changeDate', function(ev) {
            var firstDate = moment(ev.date, "DD-MM-YYYY").day(1).format("DD/MM/YYYY");
            var lastDate = moment(ev.date, "DD-MM-YYYY").day(7).format("DD/MM/YYYY");
            $('#' + dt).find('.form-control').val(firstDate + " - " + lastDate);

        }).on('hide', function(ev) {
            if (ev.date != undefined) {
                var format = "DD/MM/YYYY";
                var firstDate = moment(ev.date, format).day(1).format(format);
                var lastDate = moment(ev.date, format).day(7).format(format);
                $('#' + dt).find('.form-control').val(firstDate + " - " + lastDate);
            }
        });
    }

    var initChart = function() {
        fs_grafico({ grafico: 'comp_cat_x_grupo_dia' });
        fs_grafico({ grafico: 'comp_inc_x_dia' });
        fs_grafico({ grafico: 'comp_inc_x_mes' });
        fs_grafico({ grafico: 'comp_cat_x_dia' });
        fs_grafico({ grafico: 'comp_inc_x_parte_dia' });
        fs_grafico({ grafico: 'distribucion_x_categoria' });
        fs_grafico({ grafico: 'comp_cat_x_hora' });
        fs_grafico({ grafico: 'comp_linea_x_dia' });
        fs_grafico({ grafico: 'comp_linea_x_sem' });
        fs_grafico({ grafico: 'comp_linea_x_mes' });
    }

    var fs_grafico = function(params) {
        var obj = {
            class: 'GraficoController',
            method: 'findById'
        };

        if (Object.keys(params).length > 0) {
            Object.assign(obj, params);
        }

        $.getJSON(path_ws, obj, function(response) {
            var response = JSON.parse(response);
            console.log(response);

            if ($('#' + obj.grafico).length > 0) {
                Highcharts.chart(obj.grafico, response);
                console.log(response);
            }
        });
    }

    var fs_filter1 = function(chart) {
        var charts = [
            { grafico: 'comp_cat_x_grupo_dia' },
            { grafico: 'comp_inc_x_mes' },
            { grafico: 'comp_cat_x_dia' },
            { grafico: 'distribucion_x_categoria' },
            { grafico: 'comp_cat_x_hora' }
        ];

        for (var i = 0; i < charts.length; i++) {
            var obj = { grafico: charts[i].grafico };
            var data = $('form[name="frm_1"]').serializeObject();

            if (Object.keys(data).length > 0) {
                Object.assign(obj, data);
            }

            fs_grafico(obj);
        }
    }

    var fs_filter2 = function(chart) {
        var charts = [
            { grafico: 'comp_inc_x_dia' },
            { grafico: 'comp_inc_x_parte_dia' }
        ];

        for (var i = 0; i < charts.length; i++) {
            var obj = { grafico: charts[i].grafico };
            var data = $('form[name="frm_2"]').serializeObject();

            if (Object.keys(data).length > 0) {
                Object.assign(obj, data);
            }

            fs_grafico(obj);
        }
    }

    return {
        init: function() {
            return init();
        },
        fs_filter1: function(chart) {
            return fs_filter1(chart);
        },
        fs_filter2: function(chart) {
            return fs_filter2(chart);
        }
    }
}();