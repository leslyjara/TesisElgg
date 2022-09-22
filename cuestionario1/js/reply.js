//paginacion de preguntas en cuestionario


$(document).ready(cargarproductos(0));
var cuestionario_guid= $('input:hidden[name=cuestionario]').val();
var nueva=$( "input[type=hidden][name=nueva]" ).val();//limite de pregunats por pagina
var respuestaEntity=$( "input[type=hidden][name=respuesta]" ).val();//limite de pregunats por pagina
var intento= $( "input[type=hidden][name=intentoActual]" ).val();




function cargarproductos(offset){   
   
 
    require(['elgg/Ajax'], Ajax => {
        var ajax = new Ajax();
        ajax.view('returnPreguntas',{
            data:{
                limite:nueva, //cambiar por parametro
                offset:offset,
                cuestionario:cuestionario_guid,
                respuesta: respuestaEntity, 
                intentoActual: intento,
            }
        }).done(function (output, statusText, jqXHR) {
            if (jqXHR.AjaxData.status == -1) {
                return;
            } 
            $("#preguntas").html(output);  
            
        });          
    }); 

}

