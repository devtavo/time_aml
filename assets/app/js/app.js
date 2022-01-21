var path_root = '../..';
var path_media = 'http://95.217.44.43/siae_adjuntos';
var path_ws = '../../php/ws.php';
var path_wave = 'http://191.98.172.15:7001';
var height_win = parseInt($(window).height() * .44);
var width_win = $(window).width(); //parseInt($(window).width() * .5);

var drp_es = {
    "format": "DD/MM/YYYY",
    "separator": " - ",
    "applyLabel": "Guardar",
    "cancelLabel": "Cancelar",
    "fromLabel": "Desde",
    "toLabel": "Hasta",
    "customRangeLabel": "Personalizar",
    "daysOfWeek": [
        "Do",
        "Lu",
        "Ma",
        "Mi",
        "Ju",
        "Vi",
        "Sa"
    ],
    "monthNames": [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Setiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ],
    "firstDay": 1
};
var drp_esno = {
    "format": "YYYY-MM-DD hh:mm:00 A",
    "separator": " - ",
    "applyLabel": "Guardar",
    "cancelLabel": "Cancelar",
    "fromLabel": "Desde",
    "toLabel": "Hasta",
    "customRangeLabel": "Personalizar",
    "daysOfWeek": [
        "Do",
        "Lu",
        "Ma",
        "Mi",
        "Ju",
        "Vi",
        "Sa"
    ],
    "monthNames": [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Setiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ],
    "firstDay": 1
};

var App = function() {
    var init = function() {
        initBoostrap();
        navBar();
        window.addEventListener('storage', function(e) {
            if (e.key === 'logged-in') {
                location.reload();
                window.location.href = '/gastos/users/login/cerrar_sesion.php';
            }

        });
    }

    var initBoostrap = function() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    var dropDownList = function(selector, params) {
        $('#' + selector).empty();

        $.ajax({
            url: path_ws,
            type: 'get',
            dataType: 'json',
            data: params,
            success: function(response) {
                response.unshift({ etiqueta: '[Seleccione]', id: '0' });

                $.each(response, function(key, value) {
                    $('#' + selector).append($("<option></option>").attr("value", value.id).text(value.etiqueta));
                });
            }
        });
    }

    var arrayToForm = function(formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            if (formArray[i]['name'] in returnArray) {
                returnArray[formArray[i]['name']].push(formArray[i]['value']);
            } else {
                if (formArray[i]['name'].includes("[]")) {
                    returnArray[formArray[i]['name'].replace('[]', '')] = [formArray[i]['value']];
                } else {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
            }
            //returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        //        console.log(returnArray);
        return returnArray;
    }

    var pad = function(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }

    var getUrl = function() {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams;
    }

    var toaster = function(header, text, icon) {
        $.toast({
            heading: header,
            text: text,
            icon: icon,
            loader: true,
            loaderBg: '#9EC600'
        });
    }

    var uploadFile = function(name, pathName) {
        var file_data = $('[name="' + name + '"]').prop('files');
        var form_data = new FormData();

        if (file_data.length > 0) {
            for (i = 0; i < file_data.length; i++) {
                form_data.append('file_' + i, file_data[i]);
            }

            $.ajax({
                url: '../../php/upload_file.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('[name="' + pathName + '"]').val(response);
                }
            });
        }
    }

    var refreshIframe = function(iframe, path) {
        var iframe = $('#' + iframe);
        if (iframe.length > 0) {
            iframe.attr('src', path);
            return false;
        }
        return true;
    }

    var paginator = function(id, cantidad) {
        return $('#' + id).bootpag({
            total: cantidad,
            page: 1,
            maxVisible: 5,
            leaps: true,
            firstLastUse: true,
            first: '←',
            last: '→',
            wrapClass: 'pagination pagination-sm'
        });
    }

    var paginatorMsg = function(id, ini, fin, total) {
        $('#' + id).html('Mostrando <b>' + ini + '</b> de <b>' + fin + '</b> de un total de <b>' + total + '</b> registros');
    }

    var navBar = function() {
        //$('#navbar').find('li.active').removeClass('active');
        //$('#navbar').find('[href="' + currentPage() + '"]').closest('li').addClass('active');
    }


    var currentPage = function() {
        var path = window.location.pathname;
        var page = path.split("/").pop();
        return page;
    }

    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    var replaceAccents = function(str) {
        var chars = {
            "á": "a",
            "é": "e",
            "í": "i",
            "ó": "o",
            "ú": "u",
            "à": "a",
            "è": "e",
            "ì": "i",
            "ò": "o",
            "ù": "u",
            "ñ": "n",
            "Á": "A",
            "É": "E",
            "Í": "I",
            "Ó": "O",
            "Ú": "U",
            "À": "A",
            "È": "E",
            "Ì": "I",
            "Ò": "O",
            "Ù": "U",
            "Ñ": "N"
        };
        var expr = /[áàéèíìóòúùñ]/ig;
        var res = str.replace(expr, function(e) { return chars[e] });
        return res;
    };

    var tabStorage = function(method, values) {
        localStorage.setItem(
            method,
            values
        );
    };

    var topoJson = function() {
        L.TopoJSON = L.GeoJSON.extend({
            addData: function(jsonData) {
                if (jsonData.type === "Topology") {
                    for (key in jsonData.objects) {
                        geojson = topojson.feature(jsonData, jsonData.objects[key]);
                        L.GeoJSON.prototype.addData.call(this, geojson);
                    }
                } else {
                    L.GeoJSON.prototype.addData.call(this, jsonData);
                }
            }
        });
    }

    var auth_wave = function() {
        var auth_digest = '';

        $.get(path_wave + "/api/getNonce", function(data) {
            var user_name = "admin";
            var password = "S4p0.1234";
            var method = "GET";
            var nonce = data.reply.nonce;
            var realm = data.reply.realm;

            var digest = md5(user_name + ":" + realm + ":" + password);
            var partial_ha2 = md5(method + ":");
            var simplified_ha2 = md5(digest + ":" + nonce + ":" + partial_ha2);
            auth_digest = btoa(user_name + ":" + nonce + ":" + simplified_ha2);
            console.log(auth_digest);
        });

        return auth_digest;
    }

    return {
        init: function() {
            return init();
        },
        arrayToForm: function(formArray) {
            return arrayToForm(formArray);
        },
        dropDownList: function(selectorName, data) {
            return dropDownList(selectorName, data);
        },
        pad: function(val) {
            return pad(val);
        },
        getUrl: function() {
            return getUrl();
        },
        toaster: function(header, text, icon) {
            return toaster(header, text, icon);
        },
        uploadFile: function(name, pathName) {
            return uploadFile(name, pathName);
        },
        refreshIframe: function(iframe, path) {
            return refreshIframe(iframe, path);
        },
        paginator: function(id, cantidad) {
            return paginator(id, cantidad);
        },
        paginatorMsg: function(id, ini, fin, total) {
            return paginatorMsg(id, ini, fin, total);
        },
        navBar: function() {
            return navBar();
        },
        replaceAccents: function(str) {
            return replaceAccents(str);
        },
        tabStorage: function(method, values) {
            return tabStorage(method, values);
        },
        topoJson: function() {
            return topoJson();
        },
        auth_wave: function() {
            return auth_wave();
        }
    }
}();