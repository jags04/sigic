/**
 * Created by jags on 05/08/2017.
 */
$(function(){

    $('#pCamCla').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#pCamCla').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#pCamCla').data('accion'),
                data: $('#pCamCla').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        if($('#cnd-cambio').data('valor') == 0 ){
                            location.href = $('#url-index').data('url');
                        }
                        else{
                            swal(data.msg, "", "success");
                            $('#modalCClave').modal('hide');
                        }
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });
})