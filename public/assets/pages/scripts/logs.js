/**
 * Created by jags on 01/08/2017.
 */

$(function(){

    dt_table = $('#dt_logs').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-calendar fa-lg"></i>',titleAttr: 'busqueda en intervalo de fecha', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#modalBsqFecha' ).modal('show');
                }
            },
            {text:'<i class="fa fa-refresh"></i>',titleAttr: 'Actualizar', className: 'btn btn-no-border btn-sm green btn-outline',
                action: function (e, dt, node, config) {
                    dt_table.ajax.reload();
                }
            },
            {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
            {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o fa-lg"></i>',titleAttr: 'PDF', className: 'btn btn-sm btn-no-border red btn-outline', orientation: 'landscape', pageSize: 'LEGAL'},
            {text:'<i class="fa fa-file-text  fa-lg"></i>',titleAttr: 'Reportes', className: 'btn btn-no-border btn-sm green btn-outline',
                action: function (e, dt, node, config) {
                    $('#modalRepFecha').modal('show');
                }
            },
        ],
        // setup responsive extension: http://datatables.net/extensions/responsive/
        processing: false,
        serverSide: true,
        responsive: true,
        //"ordering": false, disable column ordering
        //"paging": false, disable pagination
        "order": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [5, 10, 25, 100, 500, 1000/*, -1*/],
            [5, 10, 25, 100, 500, 1000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_logs').data('lenguaje')
        },
        ajax: {
            url: $('#dt_logs').data('urldata'),
            data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             },
            method: 'POST'
        },
        columns:
            [
                { data: 'id', name: 'logs.id' },
                { data: 'usuario', name: 'logs.usuario' },
                { data: 'modulo', name: 'logs.modulo' },
                { data: 'accion', name: 'logs.accion' },
                { data: 'empresa', name: 'logs.empresa' },
                { data: 'fecha', name: 'fecha' }
            ],
        initComplete: function () {
            this.api().columns([1, 2, 3, 4]).every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).addClass('md-input').attr("placeholder", "Buscar press ENTER").appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column.search(val ? val : '', true, false).draw();
                    });
                // change keyup
            });
        }
    });

    $('#formBsqFcha').validate({
        submitHandler : function () {
            dt_table.page.len( -1 ).draw();
            //table.draw();
            $('#modalBsqFecha').modal('hide');
        }
    });

    $('#bsqIntFecha').on('hidden.bs.modal', function (e) {
        $('#formBsqFcha').clearForm();
    })

    /***************************************/

    var fRpInd = $("#fRepInd");
    fRpInd.validate();
    $('#btnFRepInd').click(function(){
        fi = $("#fid").val().split('-');
        ff = $("#ffd").val().split('-');

        if(fRpInd.valid()){
            $('#table_repInd').show();
            //$("#fecha_pca").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
            dt_fpca = c_rind_rcom(fRpInd.data('accion')+'?f_ini='+$("#fid").val()+'&f_fin='+$("#ffd").val()+'&cnd='+$('#tipoi').val()+'&rand='+Math.random() , 'dt_repInd');
        }
    })

    var fRpCom = $("#fRepCom");
    fRpCom.validate();
    $('#btnFRepCom').click(function(){
        fi = $("#fic").val().split('-');
        ff = $("#ffc").val().split('-');

        if(fRpCom.valid()){
            $('#table_repCom').show();
            //$("#fecha_pca").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
            dt_fpca = c_rind_rcom(fRpCom.data('accion')+'?f_ini='+$("#fic").val()+'&f_fin='+$("#ffc").val()+'&cnd='+$('#tipoc').val()+'&rand='+Math.random() , 'dt_repCom');
        }
    })



    c_rind_rcom = function (url, tid) {
        cdia = $('#'+tid).DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: false,
                destroy: true,
                order: [[1, "desc"]],
                dom: 'Brtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o  fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o  fa-lg"></i>',titleAttr: 'PDF', className: 'btn btn-sm btn-no-border red btn-outline', orientation: 'landscape', pageSize: 'LEGAL'},
                ],
                language: {
                    url: $('#dt_logs').data('lenguaje')
            },
            ajax: url,
            columns: [
            {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false },
            {data: 'cant', name: 'cant', orderable: false, searchable: false }
        ]
    });
        return cdia;
    }

    $('#modalRepFecha').on('hidden.bs.modal', function (e) {
        $('#fRepInd, #fRepCom').clearForm();
        $('#table_repInd, #table_repCom').hide();
    })
    /***************************************/


})


