<?php

use Elgg\Export\Data;

$limite= (int)elgg_extract('limite', $vars);
$offset= (int)elgg_extract('offset', $vars);
$intentoActual= (int)elgg_extract('intentoActual', $vars);
$cuestionario= (int)elgg_extract('cuestionario', $vars);
$cuestionario= get_entity($cuestionario);
$index= $offset+1;//(int)elgg_extract('index', $vars);



$sitio=elgg_get_site_url();
$user = elgg_get_logged_in_user_guid();

$respuesta= (int)elgg_extract('respuesta', $vars);
$respuesta= get_entity($respuesta);

$salir= elgg_view('output/url', array(
    'text' => 'SALIR',
    'href' => $sitio. "cuestionario/view/{$cuestionario->group}/{$cuestionario->guid}",
  
    // 'confirm' => 'Seguro que desea terminar el examen?',
    // 'is_trusted' => true,
    // 'is_action' => false,
));
if(!$respuesta){
    $btnTerminarExamen="<button   onclick='enviar(true) 'class='elgg-button enviar'>$enviar Terminar examen</button>";
}else{
    $btnTerminarExamen="<button class='elgg-button enviar'>$salir</button>";
}

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'cuestionario',
    'value' => $cuestionario->guid,
]);
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' => $cuestionario->group,
]);
//----VERIFICAR INTENTO ACTUAL
// $intentosRealizados = elgg_get_entities([
//     'type' => 'object',
//     'subtype' => 'answer',
//     'relationship' => 'respuestaCuestionario',
//     'relationship_guid' => $cuestionario->guid,
//     'inverse_relationship' => true,    
//     'owner_guid' =>$user,
// ]);
// $intentoActual = count($intentosRealizados) + 1;
if($cuestionario->aleatorioAlumno=='on'){ 
    $relationship="preguntaIntento-$intentoActual-$cuestionario->guid";
    $relationship_guid=$user;
}else{ 
    $relationship="preguntaCategoria";
    $relationship_guid=$cuestionario->guid;
   
}

$preguntas=elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',   
    'relationship' =>$relationship,
    'relationship_guid' => $relationship_guid,
    'inverse_relationship' => true,
    'full_view' => false,
    'limit' => $limite, //cantidad de entidades a mostrar  
    'offset' =>$offset,  //indice
    'full_view' => false,
));

// $preguntas=elgg_get_entities(array(
//     'subtype'=>'questions',
//     'type' => 'object',   
//     'relationship' => 'preguntaCategoria',
//     'relationship_guid' => $cuestionario->guid,
//     'inverse_relationship' => true,    
//     'limit' => $limite, //cantidad de entidades a mostrar  
//     'offset' =>$offset,  //indice
//     'full_view' => false,
// ));
$p=elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',   
    'relationship' =>$relationship,
    'relationship_guid' => $relationship_guid,
    'inverse_relationship' => true,
    'full_view' => false, 
   
));
// $p=elgg_get_entities(array(
//     'subtype'=>'questions',
//     'type' => 'object',   
//     'relationship' => 'preguntaCategoria',
//     'relationship_guid' => $cuestionario->guid,
//     'inverse_relationship' => true,  
//     'full_view' => false,  
   
// ));

$total=count($p);

// echo "index ". $index;
// echo " offset: ". $offset;
// echo "limite:". $limite;
// echo " total:". $total;


$mostrar=elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',   
    'relationship' => $relationship,
    'relationship_guid' => $relationship_guid,
    'inverse_relationship' => true,
    'full_view' => false,
    'limit' => $limite, //cantidad de entidades a mostrar  
    'offset' =>$offset,  //indice
    'full_view' => false,
));
// $mostrar=elgg_get_entities(array(
//     'subtype'=>'questions',
//    'type' => 'object',   
//    'relationship' => 'preguntaCategoria',
//    'relationship_guid' =>  $cuestionario->guid,
//    'inverse_relationship' => true,    
//     'limit' => $limite, //cantidad de entidades a mostrar  
//     'offset' =>$offset,  //indice
//     'full_view' => false,
// ));



foreach($mostrar as $pregunta){
   
   
    $tipo= $pregunta->typeQuestion;
    $texto=$pregunta->texto;
    $vars['entity']=$pregunta->guid;

    $form= elgg_view_form("questions/views/$tipo",array(), $vars);
   
    $estado='correcto';
    if($respuesta->guid){
        
        //CORRECCION
        if($tipo=='VF'){//PREGUNTAS VERDADERO FALSO
            

            $metadata="pregunta_".$pregunta->guid;
            $retroalimentacion="";
      


            echo elgg_view_field([
                '#type' => 'hidden',
                'name'  => $pregunta->guid."_",
                'value' =>$respuesta->$metadata[1],
            ]); 
        
            if($pregunta->respuestaCorrecta== $respuesta->$metadata[1]){
                $estado='correcto';
            }else{$estado='incorrecto';
            }
            //RETROALIMANTACION
            if($respuesta->$metadata[1]=='Verdadero'){
                $retroalimentacion= $pregunta->ReRespuestaVerdadero ;

            }
            if($respuesta->$metadata[1]=='Falso'){
                $retroalimentacion=$pregunta->ReRespuestaFalso;
            } 
            $panelRetroalimentacion= "<div class='Retroalimentacion  $estado'> $retroalimentacion  $pregunta->ReGeneral</div>";      
        }
        $puntos=0;
        if($tipo=='SM'){//PREGUNTAS SELECCION MULTIPLE
            
            $metadata="pregunta_".$pregunta->guid;//metadata[1] guarda las respuestas del alumno(opcion1_valor-opcion2_valor...)  
            
            $opcionesRespuesta  = getOpciones($respuesta->$metadata[1]);//retorna array con respuesta
            
            //echo $respuesta->$metadata[1];
            for ($i=1; $i <= 5; $i++) { 
               $opcionPregunta="opcion".$i;
               $calificacion="calificacion".$i;
               if($opcionesRespuesta[$opcionPregunta]==1){
                   $puntos=$puntos +(float)$pregunta->$calificacion;
                }
                //    echo $pregunta->$calificacion;  
                echo elgg_view_field([
                    '#type' => 'hidden',
                    'name'  => $pregunta->guid."_".$opcionPregunta,
                    'value' => $opcionesRespuesta[$opcionPregunta],
                ]); 
            }
          
            $puntos= ceil($puntos);
            if(count($opcionesRespuesta)==0){//si no hay respuesta
                $estado='incorrecto';
                $panelRetroalimentacion= "<div class='Retroalimentacion  $estado'>$pregunta->ReGeneral</div>";  

            }else{
                if($puntos==100){
                    $estado='correcto';
                    $retroalimentacion=$pregunta->RespuestaCorrecta;                        
                }elseif($puntos<=0){
                    $estado='incorrecto';
                    $retroalimentacion=$pregunta->RespuestaIncorrecta;
                }else{
                    $estado='parcialCorrecto';
                    $retroalimentacion=$pregunta->RespuestaParcialCorrecta;
                }         
                $panelRetroalimentacion= "<div class='Retroalimentacion  $estado'>$retroalimentacion $pregunta->ReGeneral</div>"; 
            }
             
            
        }


        
    }
    echo <<<___HTML
        <fieldset>
            <legend class='RC ftoggler'>
                <div class="cont">
                    <h3 class='tittle' >Pregunta {$index} ({$pregunta->puntuacion} punto/s)</h3> 
                    <div><h1>$pregunta->texto</h1></div>           
                    $form
                </div>
                $panelRetroalimentacion
              
                
            </legend>      
            
        </fieldset>
        <br>
    ___HTML;

    echo elgg_view_field([
        '#type' => 'hidden',
        'name' => 'index_'.$pregunta->guid,
        'value' => $index,
    ]);
    $index++;
}

$anterior= $offset-$limite; 
$siguiente= $offset+$limite;

//$index=intdiv($i, $limite);
$btn="<div class='pagination-container'>";

// if($limite<$total){//si aun hay preguntas por mostrar
    if($offset==0){  
        if($offset<$total-$limite){
            $btn.= "<button id='reset' class='pagination-cuestionario pagination-container' onclick='cargarproductos($siguiente,$index)'>Siguiente</button>";
        }  
       
    }
    elseif($offset>=$total-$limite){
       
        $btn.= "<button id='reset' class='pagination-cuestionario' onclick='cargarproductos($anterior,$index)'>Anterior</button>";    
    }
    elseif($offset<$total){
        
        $btn.= "<button id='reset' class='pagination-cuestionario' onclick='cargarproductos($anterior,$index)'>Anterior</button> &nbsp &nbsp &nbsp ";
        $btn.= "<button id='reset' class='pagination-cuestionario' onclick='cargarproductos($siguiente,$index)'>Siguiente</button>";
    }
    
// }


// $enviar= elgg_view('output/url', array(
//     'text' => 'Terminar examen',
//   //  'href' => "action/cuestionario/reply",
  
//     'confirm' => 'Seguro que desea terminar el examen?',
//     'is_trusted' => true,
//     'is_action' => false,
// ));
$btn.=" <br><br><br><br>   $btnTerminarExamen </div>"; 

echo $btn;




function getOpciones($cadena){//para preguntas SM
    $data=[];
    $arr=[];
    $arr= explode('-', $cadena);
  
 
    for ($i=0; $i < count($arr)-1; $i++) { 
        $temp =explode('_', $arr[$i]);   
        //echo  $temp[0] ."-" . $temp[1] ;
        $data+=[$temp[0] => $temp[1]] ;
        
    }

   return $data;
}

?>
<script>

var cuestionario_guid= $('input:hidden[name=cuestionario]').val();
var group_guid= $('input:hidden[name=group]').val();
var estado_cuestionario= $('input:hidden[name=estado_cuestionario]').val();
var intentoActual= $('input:hidden[name= intentoActual]').val();
var puntaje_total= $( "input[type=hidden][name=puntaje_total]" ).val();

// Marcar como seleccionado respuestas previas
if(Object.keys(resultados['respuestas']).length != 0){
    for(var key in resultados['respuestas']){
        if(resultados["respuestas"][key]["opcion"] == 'Verdadero' || resultados["respuestas"][key]["opcion"] == 'Falso'){
            $('input:radio[value='+resultados["respuestas"][key]["opcion"]+']:radio[name='+key+']').prop('checked', true);//marca repuesta seleccionada en examen        
        }
        else{
            for(var opcion in resultados["respuestas"][key]){
                value = (resultados["respuestas"][key][opcion]).split('_');
                if(value[1] == '1')$('input:checkbox[value='+value[0]+']:checkbox[name='+key+']').prop('checked', true);//marca repuesta seleccionada en examen        
            }
        }
    };
}

$('input[type="hidden"]').each(function(index){ //obtiene todos los input hidden
    name_hidden = $(this).attr('name');         //guarda el name de cada input name:"idpregunta_opcion"
    nombre = name_hidden.split('_');
    idpregunta = nombre[0];
    respuesta  = nombre[1];
    valor=$(this).val();
    if(estado_cuestionario == "Revicion"){
        $('input:checkbox').prop('disabled', true);//marca repuesta seleccionada en examen
        $('input:radio').prop('disabled', true);
    }
    if(valor=='1'){
       $('input:checkbox[value='+respuesta+']:checkbox[name='+idpregunta+']').prop('checked', true);//marca repuesta seleccionada en examen

    }
    if(valor=="Verdadero" || valor=='Falso'){
        $('input:radio[value='+valor+']:radio[name='+idpregunta+']').prop('checked', true);
    }
});


$('input[type="radio"]').click(function(){ //para preguntas VF
    name =$(this).attr('name');
    key=$(this).val();
    var index= $('input:hidden[name=index_'+name+']').val();
    if(!resultados['respuestas'][name]){
        resultados['respuestas'][name]={}//si no exite lo crea
    }
    resultados['respuestas'][name]["opcion"]=key;
    resultados['respuestas'][name]["index"]=index;
    //resultados['respuestas'][name]["index"]="1";
    //alert(name);
    console.log( JSON.stringify(resultados, undefined),4);
    // PANEL
    index=resultados['respuestas'][name]['index'];
    const elem = document.querySelector("#index-"+index);
    elem.style.backgroundColor = 'lightgreen'; //marca la casilla correspondiente como respondido
});


$('input[type="checkbox"]').click(function(){ //para preguntas de SM  
    name =$(this).attr('name');
    key=$(this).val();
    var index= $('input:hidden[name=index_'+name+']').val();
    if(!resultados['respuestas'][name]){
        resultados['respuestas'][name]={}//si no exite lo crea
    }
    if($(this).is(":checked")){
        resultados['respuestas'][name][key]=key+"_1";
        resultados['respuestas'][name]["index"]=index;
    }else  resultados['respuestas'][name][key]=key+"_0";   
    console.log( JSON.stringify(resultados, undefined,4));  
    //--------------------------------
    //PANEL
    // console.log('clave: '+ resultados['respuestas'][name]['index']);
    index=resultados['respuestas'][name]['index'];
    const elem = document.querySelector("#index-"+index);
    elem.style.backgroundColor = 'lightgreen'; //marca la casilla correspondiente como respondido
   
});


function enviar(mensaje){   
    if(mensaje== true){
        var confirmar = confirm("Seguro que desea terminar el examen?");
    }else{
        var confirmar=true;
    }
        if (confirmar == true) {        
            require(['elgg/Ajax'], Ajax => {
                var ajax = new Ajax();
                resultados['cuestionario']=cuestionario_guid;
                resultados['intentoActual']=intentoActual;
                resultados['puntaje_total']=puntaje_total
                ajax.action('cuestionario/reply', {
                    data: resultados,
                }).done(function (output, statusText, jqXHR) { 
                    window.location.href = output.sitio+"cuestionario/reply/"+group_guid+"/"+cuestionario_guid+"/"+output.guidEntity;
                });                
            })
        }
    

};


</script>