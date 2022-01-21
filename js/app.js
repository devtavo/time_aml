(function() {
    var submitBtn = document.getElementById("sig-submitBtn");
    var nombres = $('[name="nombrer"]');
    var nombresd = $('[name="nombrerd"]');
    var buscador = $('[name="buscador"]');
    var cod_reg = $('[name="cod_registro"]');
    var imge = "";
    var subida = [];
    var subidad = [];
    var tmp;
    var m_det_timeline = $('#m_det_time');
    document.getElementById('crear').disabled = true;
    // var dequien = document.getElementById("ddlvendedor").value;

    $('[name="buscador"]').keyup(function() {
        nombres.prop("readonly", false);
        fs_ciudadano($(this).val());
        // diplomados('juan');
    });

    $('[name="buscadord"]').keyup(function() {
        nombresd.prop("readonly", false);
        fs_ciudadanod($(this).val());
        // diplomados('juan');
    });

    $('[name="buscador"]').click(function() {
        nombres.prop("readonly", false);
        var target = $("[data-target='nuevo']");
        buscador.prop("readonly", false);
        target.css('display', 'none');
    });

    $(document).ready(function() {
        diploma('nom');


    });

    $('[name="nombrer"]').click(function() {
        var target = $("[data-target='nuevo']");
        buscador.prop("readonly", true);

        target.css('display', '');
        // diplomados();

    });
    $(document).on('change', '[name="cod_registro"]', function(e) {
        // console.log(e.target.value);
        subida.cod_certificado = e.target.value;
    });

    $(document).on('change', '[name="quien"]', function(e) {
        // console.log(e.target.value);
        subida.quien = e.target.value;
    });
    $(document).on('change', '[name="firma"]', function(e) {
        // console.log(e.target.value);
        subida.firma = e.target.value;
    });
    $(document).on('change', '[name="escuela"]', function(e) {
        // console.log(e.target.value);
        subida.escuela = e.target.value;
    });
    $(document).on('change', '[name="categoria"]', function(e) {
        // console.log(e.target.value);
        subida.categoria = e.target.value;
    });

    // $('[name="crear"]').click(function() {
    //     var nombres = $('[name="nombrer"]').val();
    //     var dni = $('[name="dni"]').val();
    //     var correo = $('[name="correo"]').val();
    //     var celular = $('[name="celular"]').val();
    //     crear(nombres, dni, correo, celular);
    // });

    $('[name="sig-submitBtn"]').click(function() {
        var nombres = $('[name="nombrer"]').val();
        var sel = document.getElementById('diplomados');

        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].selected == true) {
                var curso = sel.options[i].text;
            }
        }

        var horas = $('[name="horas"]').val();
        var fechai = $('[name="fechai"]').val();
        var fechaf = $('[name="fechaf"]').val();
        // var fechae = $('[name="fechae"]').val();
        var cod_registro = $('[name="cod_registro"]').val();
        // console.log(subida);
        var fecha_e = $('[name="fechae"]').val();
        subida.fecha_emision = fecha_e;
        subida.categoria = $('[name="categoria"]').val();
        subida.quien = $('[name="quien"]').val();
        subida.firma = $('[name="firma"]').val();
        subida.escuela = $('[name="escuela"]').val();
        subida.cod_registro = cod_registro;
        envio_certificado(subida.codnombre, subida.cod_diplomado, horas, fechai, fechaf, subida.fecha_emision, cod_registro, nombres, curso, subida.plantilla, subida.categoria, subida.firma, subida.quien, subida.escuela);

        console.log(subida);
    });
    $('[name="sig-submitBtn2"]').click(function() {

        var cod_registro = $('[name="fechae"]').val();
        subida.fecha_emision = cod_registro;
        console.log(subida);
        registro_certificado(subida);

    });
    $('[name="actualizar"]').click(function() {

        subida.idpersona = subida.idpersona;
        subida.nombres_completos = $('[name="nombrer"]').val();
        subida.dni = $('[name="dni"]').val();
        subida.correo = $('[name="correo"]').val();
        subida.celular = $('[name="celular"]').val();
        console.log(subida);
        console.log($('[name="dni"]').val());
        update_persona(subida);

    });
    $('[name="eliminar"]').click(function() {
        console.log(subida.idpersona);
        delete_persona(subida.idpersona);

    });

    $('[name="crear"]').click(function() {
        subida.nombres_completos = $('[name="nombrer"]').val();
        subida.dni = $('[name="dni"]').val();
        subida.correo = $('[name="correo"]').val();
        subida.celular = $('[name="celular"]').val();
        create_persona(subida);


    });
    // $(document).on('change', '[name="diplomados"]', function(e) {
    //     var sel = document.getElementById('diplomados');
    //     for (var i = 0; i < sel.options.length; i++) {
    //         if (sel.options[i].selected == true) {
    //             document.getElementById('nombrer').value = sel.options[i].text;
    //         }
    //     }
    // });
    $(document).on('change', '[name="diplomados"]', function(e) {
        var sel = document.getElementById('diplomados');
        var w = "";
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].selected == true) {
                set_codigo(sel.options[i].value);
                subida.cod_diplomado = sel.options[i].value;
                console.log(subida);
            }
        }
    });

    $(document).on('click', '[name="rsimg"]', function(e) {
        // var a = window["rsimg"].src;

        // console.log(imge);
        m_verimagen(imge);

    });

    $(document).on('change', '[name="adjunto"]', function(e) {
        let img = document.getElementById("adjunto").files[0];
        let formData = new FormData();
        formData.append("photo", img);
        fetch('upload_file.php', { method: "POST", body: formData })
            /*.then(response => {
                document.getElementById("img_res").innerHTML =
                    "<img src='../" + response[0].path + "' width='20px' height='20px'>";
            })*/
            // .then((response) => response.json())
            .then(response => response.text())
            .then(result => {
                var a = JSON.parse(result);
                imge = a[0].path;
                document.getElementById("img_res").innerHTML =
                    "<img id='rsimg' name='rsimg' src='" + a[0].path + "' width='40px' height='40px'>";
                // m_verimagen(a[0].path);
                subida.plantilla = a[0].path
            });

        // console.log(formData);

    });
    $(document).on('change', '[name="adjunto2"]', function(e) {
        let img = document.getElementById("adjunto2").files[0];
        let formData = new FormData();
        formData.append("photo", img);
        var data = {};
        // data.a = 'aa';
        // data.b = 'bb';
        // data.c = 'cc';
        fetch('upload_file_cert.php', { method: "POST", body: formData })
            /*.then(response => {
                document.getElementById("img_res").innerHTML =
                    "<img src='../" + response[0].path + "' width='20px' height='20px'>";
            })*/
            // .then((response) => response.json())
            .then(response => response.text())
            .then(result => {
                // var a = JSON.parse(result);
                // imge = a[0].path;
                // document.getElementById("img_res").innerHTML =
                // "<img id='rsimg' name='rsimg' src='" + a[0].path + "' width='40px' height='40px'>";
                // m_verimagen(a[0].path);
            });

        // console.log(formData);

    });

    // $(document).on('click', '[name="cnombre"]', function(e) {

    //     m_verimagen.find('.modal-content').html('e');
    //     m_verimagen.modal('show');


    // });


    // $(document).on('change', '[name="cnombre"]', function(e) {
    //     var sel = document.getElementById('cnombre');
    //     for (var i = 0; i < sel.options.length; i++) {
    //         if (sel.options[i].selected == true) {
    //             document.getElementById('nombrer').value = sel.options[i].text;
    //             subida.codnombre = sel.options[i].value;
    //             console.log(subida);
    //             nombres.prop("readonly", true);
    //             var target = $("[data-target='nuevo']");

    //             if (sel.options[i].text == "[no se encontro]") {
    //                 nombres.prop("readonly", false);
    //                 buscador.prop("readonly", true);

    //                 document.getElementById('nombrer').value = '';
    //                 if (target.is(':visible')) {
    //                     target.css('display', 'none');
    //                 } else {
    //                     target.css('display', '');

    //                 }
    //             } else {
    //                 buscador.prop("readonly", false);
    //                 target.css('display', 'none');

    //             }
    //         }
    //     }
    // });
    $(document).on('change', '[name="cnombreu"]', function(e) {
        var sel = document.getElementById('cnombreu');
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].selected == true) {
                document.getElementById('nombreru').value = sel.options[i].text;
                subidau.codnombre = sel.options[i].value;
                console.log(subida);
                nombres.prop("readonly", true);
                var target = $("[data-target='nuevo']");

                if (sel.options[i].text == "[no se encontro]") {
                    nombres.prop("readonly", false);
                    buscador.prop("readonly", true);

                    document.getElementById('nombrer').value = '';
                    if (target.is(':visible')) {
                        target.css('display', 'none');
                    } else {
                        target.css('display', '');

                    }
                } else {
                    buscador.prop("readonly", false);
                    target.css('display', 'none');

                }
            }
        }
    });
    $(document).on('change', '[name="cnombred"]', function(e) {
        var sel = document.getElementById('cnombred');
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].selected == true) {
                // subidad.codnombre = sel.options[i].value;

                if (sel.options[i].text == '[no se encontro]') {
                    document.getElementById('creard').disabled = false;
                    document.getElementById('nombrerd').value = subidad.nombre_cert = '';
                    document.getElementById('horasd').value = subidad.horas_academicas = '';
                    document.getElementById('fecha_i_d').value = subidad.fecha_inicio = '';
                    document.getElementById('fecha_f_d').value = subidad.fecha_fin = '';
                    document.getElementById('cortod').value = subidad.momenclatura = '';
                    document.getElementById('mesd').value = subidad.mes = '';
                    document.getElementById('anod').value = subidad.ano = '';

                } else {
                    a = tmp.filter(x => x.idcert_disponible == sel.options[i].value).shift();

                    subidad.idcert_disponible = a.idcert_disponible;
                    document.getElementById('nombrerd').value = subidad.nombre_cert = a.nombre_cert;
                    document.getElementById('horasd').value = subidad.horas_academicas = a.horas_academicas;
                    document.getElementById('fecha_i_d').value = subidad.fecha_inicio = a.fecha_inicio;
                    document.getElementById('fecha_f_d').value = subidad.fecha_fin = a.fecha_fin;
                    document.getElementById('cortod').value = subidad.momenclatura = a.momenclatura;
                    document.getElementById('mesd').value = subidad.mes = a.mes;
                    document.getElementById('anod').value = subidad.ano = a.ano;
                    document.getElementById('creard').disabled = true;

                }
            }
        }
    });
    //para obtener el nombre y rellenar los datos
    $(document).on('change', '[name="cnombre"]', function(e) {
        var sel = document.getElementById('cnombre');
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].selected == true) {
                // subidad.codnombre = sel.options[i].value;

                if (sel.options[i].text == '[no se encontro]') {
                    document.getElementById('crear').disabled = false;
                    document.getElementById('nombrer').value = subida.nombres_completos = '';
                    document.getElementById('dni').value = subida.dni = '';
                    document.getElementById('correo').value = subida.correo = '';
                    document.getElementById('celular').value = subida.celular = '';

                } else {
                    a = tmp.filter(x => x.idpersona == sel.options[i].value).shift();

                    subida.idpersona = a.idpersona;
                    document.getElementById('nombrer').value = subida.nombres_completos = a.nombres_completos;
                    document.getElementById('dni').value = subida.nro_doc_identidad = a.nro_doc_identidad;
                    document.getElementById('correo').value = subida.correo = a.correo;
                    document.getElementById('celular').value = subida.celular = a.celular;
                    document.getElementById('crear').disabled = true;

                }
            }
        }
    });
    $(document).on('click', '[name="time"]', function(e) {
        var tr = $(this).closest('tr');
        var incidente_id = Number(tr.attr('data-id'));
        console.log(incidente_id);
        // App.tabStorage('detalle_incidente', 5);
        modal_det_time(incidente_id);
    });

    var modal_det_time = function(incidente_id) {
        $.get("time.php", { idpersona: incidente_id }, function(data) {
            m_det_timeline.find('.modal-content').html(data);
            m_det_timeline.modal('show');
        }).done(function() {
            // AppEditIncidente.init();
        });
    }
    var m_verimagen = function(ruta) {

        var m_verimagen = $('#m_verimagen');
        m_verimagen.find('.modal-content').html("<img id='rsimge' name='rsimge' src='" + ruta + "' >");
        m_verimagen.modal('show');

    }

    var crear = function(nombre, dni, correo, celular) {
        var data = {};
        data.class = 'CertificadoController';
        data.method = 'create';
        data.nombre = nombre;
        data.apellidos = nombre;
        data.nombres_completos = nombre;
        data.dni = dni;
        data.correo = correo;
        // console.log(data);
        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                subida.codnombre = response;
                console.log(subida);
                document.getElementById('estadousuario').innerHTML = "Creado con Exito";
            }
        });
    }

    var set_codigo = function(curso) {
        var data = {};
        data.class = 'CertificadoController';
        data.method = 'get_codigo';
        data.id = curso;

        $.ajax({
            url: 'php/ws.php',
            type: 'get',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);
                if (response.length != 0) {
                    if (response.ultimo <= 10) {
                        cod_reg.val(response[0].cod_nuevo + "0" + response[0].ultimo);
                        subida.cod_certificado = response[0].cod_nuevo + "0" + response[0].ultimo;
                        // console.log(subida);
                    } else {
                        cod_reg.val(response[0].cod_nuevo + response[0].ultimo);
                        subida.cod_certificado = response[0].cod_nuevo + response[0].ultimo;
                        // console.log(subida);
                    }
                } else {
                    var data = {};
                    data.class = 'CertificadoController';
                    data.method = 'get_codigo_nom';
                    data.id = curso;
                    $.ajax({
                        url: 'php/ws.php',
                        type: 'post',
                        dataType: 'json',
                        data: data,
                        success: function(response2) {
                            console.log(response2.momen);
                            cod_reg.val(response2.momen + "01");
                            subida.cod_certificado = response2.momen + "01";
                            // console.log(subida);
                        }
                    });
                }
            }
        });

    }
    var registro_certificado = function(params) {
        var data = {};
        data.class = 'CertificadoController';
        data.method = 'creaRegistroCert';
        data.cod_certificado = params.cod_certificado
        data.cod_diplomado = params.cod_diplomado;
        data.cod_nombre = params.codnombre;
        data.fecha_emision = params.fecha_emision;
        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log("sesubio");
                document.getElementById('estado').innerHTML = "Se Subió exitosamente";

            }
        });
    }

    var envio_certificado = function(nombre, curso, horas, fechai, fechaf, fechae, cod_registro, nom_x_nombre, nom_x_diplomado, path_plantilla, categoria, firma, quien, escuela) {
        var data = {};
        data.class = 'CertificadoController';
        data.method = 'creaCerti';
        data.nombre = nombre;
        data.diplomado = curso;
        data.horas = horas;
        data.fechai = fechai;
        data.fechaf = fechaf;
        data.fechae = fechae;
        data.cod_registro = cod_registro;
        data.nom_nombre = nom_x_nombre;
        data.nom_diplomado = nom_x_diplomado;
        data.r_plantilla = path_plantilla;
        data.categoria = categoria;
        data.firma = firma;
        data.escuela = escuela;
        data.quien = quien;
        // console.log(data);
        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log("aquui");
                gen(data);
                // document.getElementById('estado').innerHTML = "Generado con exito";
                // document.getElementById('link').innerHTML = "<a href='localhost/otro/creacion_forem/carpeta/docu.pdf' target='_blank'>link de visualizacion</a>";
                /*
                $.ajax({
                    url: 'generador.php',
                    type: 'get',
                    dataType: 'json',
                    data: data,
                    success: function(respons2e) {
                        document.getElementById('estado').innerHTML = "Generado con exito";
                        document.getElementById('link').innerHTML = "<a href='http://idra.pe/gen/carpeta/docu.pdf' target='_blank'>link de visualizacion</a>";
                    }
                });
            */
            }
        });
    }

    var gen = function(data) {

        // $.ajax({
        //     url: 'generador.php',
        //     type: 'get',
        //     dataType: 'json',
        //     data: data,
        //     success: function(respons2e) {

        //     }
        // });
        $.get({
            url: 'generador.php?data=' + encodeURIComponent(JSON.stringify(data)),
            success: function(response) {
                console.log(response);
                console.log("asdasdsad");

                document.getElementById('estado').innerHTML = "Generado con exito";
                document.getElementById('link').innerHTML = '<a href="../verifica_idra/' + subida.cod_registro + '.pdf" target="_blank">link de visualizacion</a>';
            }
        });
    }

    var diploma = function(nom) {
        var data = {};
        data.class = 'CertificadoController';
        data.method = 'findByIdi';
        data.nombre = 'A';

        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                // console.log(response);
                dropDownList2('diplomados', response);

            }
        });

    }

    var fs_ciudadano = function(nombresx) {
        var data = {};
        data.class = 'TimeController';
        data.method = 'findById';
        data.nombre = nombresx;

        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                dropDownList('cnombre', response);
                // dropDownList('diplomados', response);
                // console.log(response);
                tmp = response;
                console.log(tmp);
                var nombrexx = "";
                if (response != null) {
                    // denunciante.attr("readonly", true);
                    nombrexx = response.nombre;
                    nombres.val(nombrexx);
                    // console.log(response);
                    // nro_doc_identidad.val(response.nro_doc_identidad);
                } else if (response == null) {
                    nombres.attr("readonly", false);
                    nombres.val('No encontrado');
                }
            }
        });
    }

    var fs_ciudadanod = function(nombresx) {
        var data = {};
        data.class = 'TimeController';
        data.method = 'findByIdDip';
        data.nombre = nombresx;

        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);

                dropDownListDip('cnombre', response);
                // dropDownList('diplomados', response);
                var nombrexxd = "";
                if (response != null) {
                    // denunciante.attr("readonly", true);
                    nombrexxd = response.nombre_cert;
                    nombresd.val(nombrexxd);
                    // console.log(response);
                    // nro_doc_identidad.val(response.nro_doc_identidad);
                } else if (response == null) {
                    nombresd.attr("readonly", false);
                    nombresd.val('No encontrado');
                }
            }
        });
    }
    var update_persona = function(params) {
        var data = {};
        data.class = 'TimeController';
        data.method = 'UpdatePersona';
        data.idpersona = params.idpersona;
        data.nombres_completos = params.nombres_completos;
        data.nro_doc_identidad = params.dni;
        data.correo = params.correo;
        data.celular = params.celular;

        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);
            }
        });

    }
    var create_persona = function(params) {
        var data = {};
        data.class = 'TimeController';
        data.method = 'CreatePersona';
        // data.idcert_disponible = params.idcert_disponible;
        data.nombres_completos = params.nombres_completos;
        data.nro_doc_identidad = params.dni;
        data.correo = params.correo;
        data.celular = params.celular;
        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);
            }
        });

    }
    var delete_persona = function(params) {
        var data = {};
        data.class = 'TimeController';
        data.method = 'DeletePersona';
        data.idpersona = params;
        console.log(data);
        $.ajax({
            url: 'php/ws.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);
            }
        });

    }
    var dropDownList = function(selector, params) {
        $('#' + selector).empty();
        for (i = 0; i < params.length; i++) {
            $('#' + selector).append($("<option></option>").attr("value", params[i].idpersona).text(params[i].nombre));
        }
        $('#' + selector).append($("<option></option>").attr("value", '[no se encontro]').text('[no se encontro]'));

    }
    var dropDownListDip = function(selector, params) {
        $('#' + selector).empty();
        for (i = 0; i < params.length; i++) {
            $('#' + selector).append($("<option></option>").attr("value", params[i].idcert_disponible).text(params[i].nombre_cert));
        }
        $('#' + selector).append($("<option></option>").attr("value", '[no se encontro]').text('[no se encontro]'));

    }
    var dropDownList2 = function(selector, params) {
        $('#' + selector).empty();
        $('#' + selector).append($("<option></option>").attr("value", '[Seleccione un Curso/Diplomado]').text('[Seleccione un Curso/Diplomado]'));
        for (i = 0; i < params.length; i++) {
            $('#' + selector).append($("<option></option>").attr("value", params[i].idcert_disponible).text(params[i].nombre_cert));
        }
        $('#' + selector).append($("<option></option>").attr("value", '[no se encontro]').text('[no se encontro]'));

    }



    // submitBtn.addEventListener("click", function(e) {
    //     //   var dataUrl = canvas.toDataURL("image/png");
    //     var nombres = $('[name="nombrer"]').val();


    //     data.class = 'CertificadoController'
    //     data.method = 'envio'

    //     $.ajax({
    //         type: "POST",
    //         url: 'php/ws.php',
    //         data: data,
    //         dataType: "dataType",
    //         success: function(response) {
    //             console.log(response);
    //         }
    //     });

    //     dataform = document.createElement("form");
    //     document.body.appendChild(dataform);
    //     dataform.setAttribute("action", "mod_pdf.php");
    //     dataform.setAttribute("enctype", "multipart/form-data");
    //     dataform.setAttribute("method", "POST");
    //     dataform.setAttribute("target", "_self");
    //     dataform.innerHTML =
    //         '<input type="text" hidden name="nombre" value="' + nombre + '"/>' +
    //         '<input type="text" hidden name="ruc" value="' + ruc + '"/>' +
    //         '<input type="text" hidden name="telefono" value="' + telefono + '"/>' +
    //         '<input type="text" hidden name="domicilio" value="' + domicilio + '"/>' +
    //         '<input type="text" hidden name="distrito" value="' + distrito + '"/>' +
    //         '<input type="text" hidden name="provincia" value="' + provincia + '"/>' +
    //         '<input type="text" hidden name="departamento" value="' + departamento + '"/>' +
    //         '<input type="text" hidden name="nombrer" value="' + nombrer + '"/>' +
    //         '<input type="text" hidden name="rucr" value="' + rucr + '"/>' +
    //         '<input type="text" hidden name="telefonor" value="' + telefonor + '"/>' +
    //         '<input type="text" hidden name="domicilior" value="' + domicilior + '"/>' +
    //         '<input type="text" hidden name="correo" value="' + correo + '"/>' +
    //         '<input type="text" hidden name="distritor" value="' + distritor + '"/>' +
    //         '<input type="text" hidden name="provinciar" value="' + provinciar + '"/>' +
    //         '<input type="text" hidden name="departamentor" value="' + departamentor + '"/>' +
    //         '<input type="text" hidden name="referenciar" value="' + referenciar + '"/>' +
    //         '<input type="text" hidden name="dequien" value="' + dequien + '"/>' +
    //         '<input type="text" hidden name="pagorealizado" value="' + pagorealizado + '"/>' +
    //         '<input type="text" hidden name="fechapago" value="' + fechapago + '"/>' +
    //         '<input type="text" hidden name="montopagado" value="' + montopagado + '"/>' +
    //         '<input type="text" hidden name="observaciones" value="' + observaciones + '"/>';
    //     dataform.submit();
    // }, false);

})();