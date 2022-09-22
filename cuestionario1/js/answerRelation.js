var cuestionario_guid= $('input:hidden[name=cuestionario]').val();
var titulo=$("#verPreguntasClick").text();


$( "#verRespuestasClick" ).click(function() {
    if($("#verRespuestasClick").text()=="Ver respuestas"){

        require(['elgg/Ajax'], Ajax => {
            var ajax = new Ajax();
            ajax.view('AnswerRelation',{
                data:{
                    cuestionario:cuestionario_guid,
                }
            }).done(function (output, statusText, jqXHR) {
                if (jqXHR.AjaxData.status == -1) {
                    return;
                } 
                $("#verRespuestas").html(output);                    
                $("#verRespuestasClick").html("Ocultar Respuestas");                    
            });          
        }); 
    }else{
        $("#verRespuestas").html(" ");                    
        $("#verRespuestasClick").html("Ver respuestas"); 
    }
});
