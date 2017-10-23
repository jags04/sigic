/**
 * Created by jags on 01/08/2017.
 */

$(function() {

    $("input[data-type='number']").inputmask("decimal", {
        radixPoint: ",",
        autoGroup: true,
        groupSeparator: ".",
        groupSize: 3,
        autoUnmask: true
    });
    $(":input").inputmask();

    $('#qryPlanAct').validate({
        submitHandler: function (form) {
            fi = $("#fp1").val().split('-');
            ff = $("#fp2").val().split('-');
            $("#divNFecha").html(fi[2] + '/' + fi[1] + '/' + fi[0] + ' al ' + ff[2] + '/' + ff[1] + '/' + ff[0])
            dt_rdia = c_avance($('#dt_pAct').data('urldata') + '?f1=' + $("#fp1").val() + '&f2=' + $("#fp2").val(), $('#dt_pAct').data('lenguaje'));
            $("#modalPlantasActualizadas").modal('show');
        }
    });


    c_avance = function (url, lg, f1, f2) {
        cdia = $('#dt_pAct').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            //paging: false,
            destroy: true,
            order: [[0, "asc"]],
            lengthMenu: [[5, 10, 25, 100, 500, 1000, 5000/*, -1*/], [5, 10, 25, 100, 500, 1000, 5000]],
            pageLength: 10,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o fa-lg"></i>',
                titleAttr: 'Excel',
                className: 'btn btn-no-border btn-sm green-meadow btn-outline'
            }],
            language: {url: lg},
            ajax: url,
            columns: [
                {data: 'fecha', name: 'planta_info_comp.fecha', orderable: false, searchable: false},
                {data: 'rif', name: 'empresas.rif' },
                {data: 'rsocial', name: 'empresas.rsocial' },
                {data: 'sector', name: 'empresas.sector' },
                {data: 'subsector', name: 'empresas.subsector', orderable: false, searchable: false, visible: false},

                {data: 'rlegal', name: 'empresas.rlegal', orderable: false, searchable: false, visible: false},
                {data: 'ci', name: 'empresas.ci', orderable: false, searchable: false, visible: false},
                {data: 'telefonos', name: 'empresas.telefonos', orderable: false, searchable: false, visible: false},
                {data: 'estado', name: 'plantas.estado'},
                {data: 'municipio', name: 'plantas.municipio', orderable: false, searchable: false, visible: false},
                {data: 'parroquia', name: 'plantas.parroquia', orderable: false, searchable: false, visible: false},
                {data: 'status', name: 'plantas.status', orderable: false, searchable: false, visible: false},
                {data: 'ambito', name: 'plantas.ambito'},
                {data: 'telf', name: 'plantas.telf', orderable: false, searchable: false, visible: false},

                {data: 'mobra', name: 'planta_info_comp.mobra', orderable: false, searchable: false, visible: false},
                {data: 'cinstalada', name: 'planta_info_comp.cinstalada', orderable: false, searchable: false},
                {data: 'coperativa', name: 'planta_info_comp.coperativa', orderable: false, searchable: false},
                {data: 'produccion', name: 'planta_info_comp.produccion', orderable: false, searchable: false},
                {data: 'inventario',name: 'planta_info_comp.inventario',orderable: false,searchable: false,visible: false},
                {data: 'pprincipal',name: 'planta_info_comp.pprincipal',orderable: false,searchable: false,visible: false},
                {data: 'ncritico',name: 'planta_info_comp.ncritico',orderable: false,searchable: false,visible: false },
                {data: 'observacion', name: 'planta_info_comp.observacion',orderable: false,searchable: false,visible: false},
                {data: 'foto', name: 'foto',orderable: false,searchable: false,visible: false},
            ]
        });
        return cdia;
    }

    $('#qryPorProd').validate({
        submitHandler: function (form) {
            fi = $("#fpp1").val().split('-');
            ff = $("#fpp2").val().split('-');
            $("#divPNFecha").html(fi[2] + '/' + fi[1] + '/' + fi[0] + ' al ' + ff[2] + '/' + ff[1] + '/' + ff[0])
            dt_rppc = c_porc_amb($('#dt_pPorPro').data('urldata') + '?f1=' + $("#fpp1").val() + '&f2=' + $("#fpp2").val(), $('#dt_pPorPro').data('lenguaje'));
            $("#modalPorcentajeAmbitos").modal('show');
        }
    });

    c_porc_amb = function (url, lg, f1, f2) {
        cdia = $('#dt_pPorPro').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            //paging: false,
            destroy: true,
            order: [[0, "asc"], [3, "asc"]],
            lengthMenu: [[5, 10, 25, 100, 500, 1000, 5000/*, -1*/], [5, 10, 25, 100, 500, 1000, 5000]],
            pageLength: 10,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o fa-lg"></i>',
                titleAttr: 'Excel',
                className: 'btn btn-no-border btn-sm green-meadow btn-outline'
            }],
            language: {url: lg},
            ajax: url,
            columns: [
                {data: 'estado', name: 'plantas.estado', orderable: false},
                {data: 'municipio', name: 'plantas.municipio', orderable: false, searchable: false, visible: false},
                {data: 'parroquia', name: 'plantas.parroquia', orderable: false, searchable: false},
                {data: 'ambito', name: 'plantas.ambito', orderable: false, searchable: false},
                {data: 'produccion', name: 'produccion', orderable: false, searchable: false}
            ]
        });
        return cdia;
    }

    $('#qryPorProdEdo').validate({
        submitHandler: function (form) {
            fi = $("#fpe1").val().split('-');
            ff = $("#fpe2").val().split('-');
            $("#divEPNFecha").html(fi[2] + '/' + fi[1] + '/' + fi[0] + ' al ' + ff[2] + '/' + ff[1] + '/' + ff[0])
            dt_rppce = c_porc_edo($('#dt_pPorProEdo').data('urldata') + '?f1=' + $("#fpe1").val() + '&f2=' + $("#fpe2").val(), $('#dt_pPorProEdo').data('lenguaje'));
            $("#modalPorcentajeEstados").modal('show');
        }
    });

    c_porc_edo = function (url, lg, f1, f2) {
        cdia = $('#dt_pPorProEdo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            //paging: false,
            destroy: true,
            order: [[0, "asc"]],
            lengthMenu: [[5, 10, 25, 100, 500, 1000, 5000/*, -1*/], [5, 10, 25, 100, 500, 1000, 5000]],
            pageLength: 10,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o fa-lg"></i>',
                titleAttr: 'Excel',
                className: 'btn btn-no-border btn-sm green-meadow btn-outline'
            }],
            language: {url: lg},
            ajax: url,
            columns: [
                {data: 'estado', name: 'plantas.estado', orderable: false},
                {data: 'produccion', name: 'produccion', orderable: false, searchable: false}
            ]
        });
        return cdia;
    }

    $('#qryPlanSeg').validate({
        submitHandler: function (form) {
            fi = $("#fps1").val().split('-');
            ff = $("#fps2").val().split('-');
            $("#divSegFecha").html(fi[2] + '/' + fi[1] + '/' + fi[0] + ' al ' + ff[2] + '/' + ff[1] + '/' + ff[0])
            dt_rppse = c_plan_seg($('#dt_pSeg').data('urldata') + '?f1=' + $("#fps1").val() + '&f2=' + $("#fps2").val(), $('#dt_pSeg').data('lenguaje'));
            $("#modalPlantasSeg").modal('show');
            $('#ifrGrafSegPlan').attr('src', $('#dt_pSeg').data('urlgrafico') + '?f1=' + $("#fps1").val() + '&f2=' + $("#fps2").val())
        }
    });

    c_plan_seg = function (url, lg, f1, f2) {
        cdia = $('#dt_pSeg').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            paging: false,
            searching: false,
            destroy: true,
            order: [[0, "asc"]],
            lengthMenu: [[5, 10, 25, 100, 500, 1000, 5000/*, -1*/], [5, 10, 25, 100, 500, 1000, 5000]],
            pageLength: 10,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o fa-lg"></i>',
                titleAttr: 'Excel',
                className: 'btn btn-no-border btn-sm green-meadow btn-outline'
            }],
            language: {url: lg},
            ajax: url,
            columns: [
                {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false},
                {data: 'cant', name: 'cant', orderable: false, searchable: false}
            ]
        });
        return cdia;
    }


})