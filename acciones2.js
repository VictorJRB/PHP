function buscarSub(){
    var $incidencia = $("#id_incidencia").val();

    if ($incidencia==""){
        $("#id_subincidencia").html('<option value="">- Seleccione primero una Incidencia -</option>')
    }
    else {
        $.ajax({
            dataType: "json",
            data: {"incidencia": $incidencia},
            url:   'buscar2.php',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
            },
            success: function(respuesta){
                //lo que se si el destino devuelve algo
                $("#id_subincidencia").html(respuesta.html);
            },
            error:    function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
            }
        });
    }
}



