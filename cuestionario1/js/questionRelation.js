var cuestionario_guid= $('input:hidden[name=cuestionario]').val();
var titulo=$("#verPreguntasClick").text();


$( "#verPreguntasClick" ).click(function() {
    if($("#verPreguntasClick").text()=="Ver preguntas"){

        require(['elgg/Ajax'], Ajax => {
            var ajax = new Ajax();
            ajax.view('QuestionRelation',{
                data:{
                    cuestionario:cuestionario_guid,
                }
            }).done(function (output, statusText, jqXHR) {
                if (jqXHR.AjaxData.status == -1) {
                    return;
                } 
                $("#verPreguntas").html(output);                    
                $("#verPreguntasClick").html("Ocultar Preguntas");                    
            });          
        }); 
    }else{
        $("#verPreguntas").html(" ");                    
        $("#verPreguntasClick").html("Ver preguntas"); 
    }
});
