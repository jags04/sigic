/**
 * Created by jags on 01/08/2017.
 */

$(function(){

    $("input[data-type='number']").inputmask("decimal", {
        radixPoint: ",",
        autoGroup: true,
        groupSeparator: ".",
        groupSize: 3,
        autoUnmask: true
    });
    $(":input").inputmask();

    dt_table = $('#dt_empresas').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-plus fa-lg"></i>',titleAttr: 'Agregar registro', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#addEmpresa' ).modal('show');
                }
            },
            {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
            {text: '<i class="fa fa-upload fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar producción',
                 action: function ( e, dt, node, config ){
                     uploadProduccion('0', 'GRAL', $('#user-rol').data('rol'))
                 }
             },
            {text: '<i class="fa fa-cloud-upload fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data externa',
                action: function ( e, dt, node, config ){
                    $( '#cDataExt' ).modal('show');
                }
            },
            {text: '<i class="fa fa-money fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data DICOM',
                action: function ( e, dt, node, config ){
                    uploadDicom()
                }
            }
        ],
        // setup responsive extension: http://datatables.net/extensions/responsive/
        processing: false,
        serverSide: true,
        responsive: true,
        //"ordering": false, disable column ordering
        //"paging": false, disable pagination
        "order": [
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 100, 500, 1000/*, -1*/],
            [5, 10, 25, 100, 500, 1000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_empresas').data('lenguaje')
        },
        ajax: {
            url: $('#dt_empresas').data('urldata'),
            /*data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             }
             //method: 'POST'*/
        },
        columns:
            [
                { data: 'rif', name: 'empresas.rif', 'width': '10%'},
                { data: 'rsocial', name: 'empresas.rsocial', 'width': '15%' },
                { data: 'estado', name: 'empresas.estado', 'width': '10%'},
                { data: 'municipio', name: 'empresas.municipio', orderable: false, searchable: false, visible: false },
                { data: 'parroquia', name: 'empresas.parroquia', orderable: false, searchable: false, visible: false },
                { data: 'localidad', name: 'empresas.localidad', orderable: false, searchable: false, visible: false },
                { data: 'trabajadores', name: 'empresas.trabajadores', orderable: false, searchable: false, visible: false },
                { data: 'ciiu', name: 'empresas.ciiu', orderable: false, searchable: false, visible: false },
                { data: 'acteconomica', name: 'empresas.acteconomica', orderable: false, searchable: false, visible: false },
                { data: 'cnp', name: 'empresas.cnp', orderable: false, searchable: false, visible: false },
                { data: 'fuente', name: 'empresas.fuente', orderable: false, searchable: false, visible: false },
                { data: 'sector', name: 'empresas.sector', 'width': '15%' },
                { data: 'subsector', name: 'empresas.subsector' , 'width': '15%'},
                { data: 'motor', name: 'empresas.motor', orderable: false, searchable: false, visible: false },
                { data: 'status', name: 'empresas.status', orderable: false, searchable: false, visible: false },
                { data: 'rlegal', name: 'empresas.rlegal', orderable: false, searchable: false, visible: false },
                { data: 'ci', name: 'empresas.ci', orderable: false, searchable: false, visible: false },
                { data: 'telefonos', name: 'empresas.telefonos', orderable: false, searchable: false, visible: false },
                { data: 'email', name: 'empresas.email', orderable: false, searchable: false, visible: false },
                { data: 'latitud', name: 'empresas.latitud', orderable: false, searchable: false, visible: false },
                { data: 'longitud', name: 'empresas.longitud', orderable: false, searchable: false, visible: false },
                { data: 'dicom', name: 'dicom', searchable: false , 'width': '10%'},
                { data: 'plantas', name: 'plantas', orderable: false, searchable: false, visible: false },
                { data: 'accion', name: 'accion', orderable: false, searchable: false}
            ],
        initComplete: function () {
            this.api().columns([1, 2, 11, 12]).every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).addClass('md-input').attr("placeholder", "Buscar press ENTER").appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column.search(val ? val : '', true, false).draw();
                    });
                // keyup change
            });
        }
    });
    $('div .dataTables_filter input').addClass('material');
    $('#fAddEmp').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddEmp').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fAddEmp').data('accion'),
                data: $('#fAddEmp').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        $('#fAddEmp').clearForm();
                        dt_table.ajax.reload( null, false );
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#addEmpresa').on('hidden.bs.modal', function (e) {
        $('#municipio, #parroquia, #sector, #subsector, #ciiu').find('option:not(:first)').remove();
        $("#cnp option:last, #status option:last ").remove();
        $('#fAddEmp').clearForm();
    })

    findUpdateEmp  = function(id){
        $.ajax({
            type: "POST",
            url:$('#url-find').data('url'),
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $('#updRsocial').html(item.rsocial);
                    $("#id_emp").val(item.id);
                    $("#rsocial2").val(item.rsocial);
                    $("#rif2").val(item.rif);
                    $('#estado2').append($('<option>').text(item.estado).attr({value: item.estado,selected: "selected"}));
                    $('#municipio2').append($('<option>').text(item.municipio).attr({value: item.municipio,selected: "selected"}));
                    $('#parroquia2').append($('<option>').text(item.parroquia).attr({value: item.parroquia,selected: "selected"}));
                    $("#localidad2").val(item.localidad);
                    $("#trabajadores2").val(item.trabajadores);
                    $('#motor2').append($('<option>').text(item.motor).attr({value: item.motor,selected: "selected"}));
                    $('#sector2').append($('<option>').text(item.sector).attr({value: item.sector, selected: "selected"}));
                    $('#subsector2').append($('<option>').text(item.subsector).attr({value: item.subsector ,selected: "selected"}));
                    $('#ciiu2').append($('<option>').text(item.ciiu).attr({value: item.ciiu ,selected: "selected"}));
                    $("#cnp2").append($('<option>').text(item.cnp).attr({value: item.cnp,selected: "selected"}));
                    $("#status2").append($('<option>').text(item.status).attr({value: item.status,selected: "selected"}));
                    $("#coordenadas2").val(item.coordenadas);
                    $("#rlegal2").val(item.rlegal);
                    $("#ci2").val(item.ci);
                    $("#email2").val(item.email);
                    telf = item.telefonos.split(';')
                    $("#telf12").val(telf[0]);
                    $("#telf22").val(telf[1]);
                    $("#telf32").val(telf[2]);
                })
                $("#updEmpresa").modal('show');
            }
        });
    }

    $('#fUpdEmp').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddEmp').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fUpdEmp').data('accion'),
                data: $('#fUpdEmp').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                        $("#updEmpresa").modal('hide');
                        $('#fUpdEmp').clearForm();
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#updEmpresa').on('hidden.bs.modal', function (e) {
        $('#municipio2, #parroquia2, #sector2, #subsector2, #ciiu2').find('option:not(:first)').remove();
        $("#motor2 option:last, #estado2 option:last, #cnp2 option:last, #status2 option:last ").remove();
        $('#fUpdEmp').clearForm();
    })


    deleteEmp = function(id){
        swal({
            title: "¿Esta seguro que quiere borrar este registro?",
            text: "Esta acción no puede ser desecha",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url: $('#url-del').data('url'),
                data: { "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });
    }

    $('#fbsqDicom').validate({
        submitHandler: function(form){
            swal({
                title: "¿Esta seguro que quiere cargar los datos de la tabla DICOM?",
                text: "Esta acción no puede ser desecha",
                type: "warning",
                cancelButtonText: "No",
                showCancelButton: true,
                confirmButtonText: "Si, estoy seguro",
                reverseButtons: true
            }).then(function (text) {
                $.ajax({
                    type: "POST",
                    url: $('#url-dicom').data('url'),
                    data: $('#fbsqDicom').serialize(),
                    success: function( data ) {
                        if(data.status == 1){
                            swal(data.msg, "", "success");
                            dt_table.ajax.reload( null, false );
                        }
                        else{
                            swal(data.msg, "", "error");
                        }
                    }
                });
            });

        }
    });
    $('#fbsqSaiise').validate({
        submitHandler: function(form){
            swal({
                title: "¿Esta seguro que quiere cargar los datos del SAIISE?",
                text: "Esta acción no puede ser desecha",
                type: "warning",
                cancelButtonText: "No",
                showCancelButton: true,
                confirmButtonText: "Si, estoy seguro",
                reverseButtons: true
            }).then(function (text) {
                $.ajax({
                    type: "POST",
                    url: $('#url-saiise').data('url'),
                    data: $('#fbsqSaiise').serialize(),
                    success: function( data ) {
                        if(data.status == 1){
                            swal(data.msg, "", "success");
                            dt_table.ajax.reload( null, false );
                        }
                        else{
                            swal(data.msg, "", "error");
                        }
                    }
                });
            });

        }
    });
    viewEmp = function(id){
        $.ajax({
            type: "POST",
            url: $('#url-view').data('url'),
            data: {"id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    html = '<div class="row">'+
                        '<div class="col-md-4">RIF: <strong>'+item.rif+'</strong></div>'+
                        '<div class="col-md-8">Razón social: <strong>'+item.rsocial+'</strong></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-4">Estado: <strong>'+item.estado+'</strong></div>'+
                        '<div class="col-md-4">Municipio: <strong>'+item.municipio+'</strong></div>'+
                        '<div class="col-md-4">Parroquia: <strong>'+item.parroquia+'</strong></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-12">Dirección: <strong>'+item.localidad+'</strong></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-8">Actividad económica: <strong>'+item.acteconomica+'</strong></div>'+
                        '<div class="col-md-2">Nº trabajadores: <strong>'+item.trabajadores+'</strong></div>'+
                        '<div class="col-md-2">Nº plantas: <strong>'+item.plantas+'</strong></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-4">Sector: <strong>'+item.sector+'</strong></div>'+
                        '<div class="col-md-4">Subsector: <strong>'+item.subsector+'</strong></div>'+
                        '<div class="col-md-4">Motor: <strong>'+item.motor+'</strong></div>'+
                        '</div>'+
                        '<br><br>'+
                        '<div class="row">'+
                        '<div class="col-md-12">Representante legal<hr></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-8">Nombre: <strong>'+item.rlegal+'</strong></div>'+
                        '<div class="col-md-4">Cédula de identidad: <strong>'+item.ci+'</strong></div>'+
                        '</div><br>'+
                        '<div class="row">'+
                        '<div class="col-md-6">Teléfonos: <strong>'+item.telefonos+'</strong></div>'+
                        '<div class="col-md-6">Email: <strong>'+item.email+'</strong></div>'+
                        '</div><br>';
                    rif = item.rif;
                })


                $('iframe#mapUbicacion').attr("src", $('#url-mapUbicacion').data('url')+"?rif="+rif);
                $('#grafProd').attr("src",  $('#url-dataProdAnual').data('url')+"?rif="+rif);
                $('#grafProdHist').attr("src", $('#url-dataProdAnual').data('url')+"?rif="+rif);

                $('#grafProdUn').attr("src", $('#url-dataProdUn').data('url')+"?rif="+rif);
                $('#grafProdUnHist').attr("src", $('#url-dataProdUnHist').data('url')+"?rif="+rif);
                $('#grafAsigUn').attr("src", $('#url-dataAsigUn').data('url')+"?rif="+rif);
                $('#grafAsigUnHist').attr("src", $('#url-dataAsigUnHist').data('url')+"?rif="+rif);



                $("#tab_1_1").empty().html(html);
                $("#detalleEmp").modal('show');
            }
        });

        $('#detalleEmp').on('hidden.bs.modal', function (e) {
            $('#mapUbicacion,#grafProd,#grafProdHist').attr("src", "");
        })
    }

    getCoordenadas = function(id){
        $('#modalMapa').modal('show');
        $('#iframeMapa').attr('src', $('#iframeMapa').data('url')+'?id='+id)
    }

    verDetalleSubastas = function(id, nombre){
        $('#modalDetSubastas').modal('show');
        $('#rsocialSubastas').empty().html(nombre);
        $.ajax({
            type: "POST",
            url: $('#url-dicomSubasta').data('url'),
            data: { "rif" : id},
            success: function( data ) {
                $('#cuerpoSubastas').empty().html(data);

            }
        });
    }

})


/******************************************************upload****/
function uploadDicom(){
    $( '#uplDicom' ).modal('show');

    $(".upload_dicom").upload({
        action: $('#url-uplDicom').data('url'),
        label: '<br><i class="fa fa-upload fa-5x"></i>',
        multiple: false,
        //postData: { id : ide },
        autoUpload: true,
        maxSize: 1073741824,
        beforeSend: onBeforeSend
    }).on("start.upload", onStart)
        .on("complete.upload", onComplete)
        .on("filestart.upload", onFileStart)
        .on("fileprogress.upload", onFileProgress)
        .on("filecomplete.upload", onFileComplete)
        .on("fileerror.upload", onFileError)
        .on("chunkstart.upload", onChunkStart)
        .on("chunkprogress.upload", onChunkProgress)
        .on("chunkcomplete.upload", onChunkComplete)
        .on("chunkerror.upload", onChunkError)
        .on("queued.upload", onQueued);

    $(".filelist.queue").on("click", ".cancel", onCancel);
    $(".cancel_all").on("click", onCancelAll);

    /*$("#dzone").upload({});*/

    $('#uplDicom').on('hidden.bs.modal', function (e) {
        $(".upload_dicom").upload("destroy");
        $(".filelist.queue, .filelist.complete").empty()
    })
}

function uploadProduccion(ide, cnd, rol){

    $( '#uplProduccion' ).modal('show');

    $(".upload").upload({
        action: $('#url-uplProduccion').data('url'),
        label: '<br><i class="fa fa-upload fa-5x"></i>',
        multiple: false,
        postData: { id : ide, 'cnd': cnd, 'rol': rol },
        autoUpload: true,
        //maxSize: 1073741824,
        maxSize: 2097152, // 2mb
        beforeSend: onBeforeSend
    }).on("start.upload", onStart)
        .on("complete.upload", onComplete)
        .on("filestart.upload", onFileStart)
        .on("fileprogress.upload", onFileProgress)
        .on("filecomplete.upload", onFileComplete)
        .on("fileerror.upload", onFileError)
        .on("chunkstart.upload", onChunkStart)
        .on("chunkprogress.upload", onChunkProgress)
        .on("chunkcomplete.upload", onChunkComplete)
        .on("chunkerror.upload", onChunkError)
        .on("queued.upload", onQueued);

    $(".filelist.queue").on("click", ".cancel", onCancel);
    $(".cancel_all").on("click", onCancelAll);

    /*$("#dzone").upload({});*/

    $('#uplProduccion').on('hidden.bs.modal', function (e) {
        $(".upload").upload("destroy");
        $(".filelist.queue, .filelist.complete").empty()
    })
}

function onCancel(e) {
    console.log("Cancel");
    var index = $(this).parents("li").data("index");
    $(this).parents("form").find(".upload").upload("abort", parseInt(index, 10));
}

function onCancelAll(e) {
    console.log("Cancel All");
    $(this).parents("form").find(".upload").upload("abort");
}

function onBeforeSend(formData, file) {
    console.log("Before Send");
    /*formData.append("test_field", "test_value");
     return (file.name.indexOf(".csv") < -1) ? false : formData; // cancel all jpgs
     //return formData;*/
    if (file.name.indexOf(".csv") < 0 ) {
        return false;
    }

    return formData;
}

function onQueued(e, files) {
    console.log("Queued");
    var html = '';
    for (var i = 0; i < files.length; i++) {
        html += '<li data-index="' + files[i].index + '"><span class="content"><span class="file">' + files[i].name + '</span><span class="cancel">Cancel</span><span class="progress">Queued</span></span><span class="bar"></span></li>';
    }

    $(this).parents("form").find(".filelist.queue").append(html);
}

function onStart(e, files) {
    console.log("Start");
    $(this).parents("form").find(".filelist.queue")
        .find("li")
        .find(".progress").text("Error");
}

function onComplete(e) {
    console.log("Complete");
    // All done!
}

function onFileStart(e, file) {
    console.log("File Start");
    $(this).parents("form").find(".filelist.queue")
        .find("li[data-index=" + file.index + "]")
        .find(".progress").text("0%");
}

function onFileProgress(e, file, percent) {
    console.log("File Progress");
    var $file = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]");

    $file.find(".progress").text(percent + "%")
    $file.find(".bar").css("width", percent + "%");
}

function onFileComplete(e, file, response) {
    console.log("File Complete");
    if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
        $(this).parents("form").find(".filelist.queue")
            .find("li[data-index=" + file.index + "]").addClass("error")
            .find(".progress").text(response.trim());
        swal(response, "", "error");
    }
    else {
        var $target = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]").addClass('font-green-sharp');
        $target.find(".file").text(file.name+" Listo");//file.name+' '+response.trim()
        $target.find(".progress").remove();
        $target.find(".cancel").remove();
        $target.appendTo($(this).parents("form").find(".filelist.complete"));
        swal(file.name+'<br>'+response, "", "success");
    }
}

function onFileError(e, file, error) {
    console.log("File Error");
    $(this).parents("form").find(".filelist.queue")
        .find("li[data-index=" + file.index + "]").addClass("error")
        .find(".progress").text("Error: " + error);
}

function onChunkStart(e, file) {
    console.log("Chunk Start");
}

function onChunkProgress(e, file, percent) {
    console.log("Chunk Progress");
}

function onChunkComplete(e, file, response) {
    console.log("Chunk Complete");
}

function onChunkError(e, file, error) {
    console.log("Chunk Error");
}

//"_token": "{{ csrf_token() }}",
