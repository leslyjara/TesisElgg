$( document ).ready(function() {   
    
    data={};
    data['container']= $('input:hidden[name=container]').val();
    data['categoria']= $('input:hidden[name=categoria]').val();
    data['group']= $('input:hidden[name=container]').val(); 
    data['cuestionario']= $('input:hidden[name=cuestionario]').val(); 
   
    //carga formulario: listado de preguntas
    require(['elgg/Ajax'], Ajax => {
        var ajax = new Ajax();
        ajax.form('questions/deleteQ',{
            data:data
        }).done(function (output, statusText, jqXHR) {
            if (jqXHR.AjaxData.status == -1) {
                //return;
            } 
             
            $('#view-form').html(output);            
        });          
    }); 
}); 


//------------------------------------------

//OPCIONES DE PREGUNTAS EN MODAL
    var desc={
        'pregunta':[
            {  'nombre':'Verdadero/Falso', 'descripcion': 'Pregunta de opción múltiple con solamente dos opciones: Falso o Verdadadero.'    },
            {  'nombre':'Seleccion multiple', 'descripcion': 'Permite seleccionar una o varias respuestas de una lista pre-definida.'    },
            {  'nombre':'texto', 'descripcion': 'Permite ingresar texto como respuesta.'  },
        ]     
    };

    $( "li" ).each(function( index ) {
       // console.log( index + ": " + $( this ).text() );
        $(this).click(function(){
            if($( this ).text()=='Verdadero/Falso'){
                $("#descripcion").text(desc.pregunta[0].descripcion);
            }
            if($( this ).text()=='Seleccion multiple'){
                $("#descripcion").text(desc.pregunta[1].descripcion);
            }
            if($( this ).text()=='texto'){
                $("#descripcion").text(desc.pregunta[2].descripcion);
            }
        });
    });
//-----------------------------

//----MODAL----------------------------------------------
    // Get the modal
    var modal = document.getElementById("modal1");
    // Get the button that opens the modal
    var btn = document.getElementById("agregarPregunta");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
//----------------------------------------------
