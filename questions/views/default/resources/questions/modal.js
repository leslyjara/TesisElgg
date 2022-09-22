var desc={
    'pregunta':[
        {  'nombre':'Verdadero/Falso', 'descripcion': 'Pregunta de opción múltiple con solamente dos opciones: Falso o Verdadadero.'    },
        {  'nombre':'Seleccion multiple', 'descripcion': 'Permite seleccionar una o varias respuestas de una lista pre-definida.'    }
    ] 
    
};


$( "li" ).each(function( index ) {
  console.log( index + ": " + $( this ).text() );
  $(this).click(function(){
        //alert( index + ": " + $( this ).text());
        if($( this ).text()=='Verdadero/Falso'){
            $("#descripcion").text(desc.pregunta[0].descripcion);
        }
        if($( this ).text()=='Seleccion multiple'){
            $("#descripcion").text(desc.pregunta[1].descripcion);
        }
        //alert(desc.pregunta[1].nombre);
  });
});