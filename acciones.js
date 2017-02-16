
function buscarZona(){
    var $planta = $("#id_planta").val();

    if ($planta==""){
        $("#id_zona").html('<option value="">- Seleccione primero una Planta -</option>')
    }
    else {
        $.ajax({
            dataType: "json",
            data: {"planta": $planta},
            url:   'buscar.php',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
            },
            success: function(respuesta){
                //lo que se si el destino devuelve algo
                $("#id_zona").html(respuesta.html);
            },
            error:    function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
            }
        });
    }
}

function buscarModulo(){
    var $zona = $("#id_zona").val();

    if ($zona==""){
        $("#id_zona").html('<option value="">- Seleccione primero una Zona -</option>')
    }
    else {
        $.ajax({
            dataType: "json",
            data: {"zona": $zona},
            url:   'buscar.php',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
            },
            success: function(respuesta){
                //lo que se si el destino devuelve algo
                $("#id_modulo").html(respuesta.html);
            },
            error:    function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
            }
        });
    }
}

function buscarImagen(){
    var $planta = $("#id_planta").val();

    if ($planta==""){
        $("#id_planta").html('')
    }
    else {
        $.ajax({
            dataType: "json",
            data: {"planta": $planta},
            url:   'buscar.php',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
            },
            success: function(respuesta){
                //lo que se si el destino devuelve algo
                $("#id_imagen").html(respuesta.html);
            },
            error:    function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
            }
        });
    }
}



