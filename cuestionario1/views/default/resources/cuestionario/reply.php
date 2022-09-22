
<style>
    .timer-cuestionario{
        
        float: left;
        padding: 20px 0;
    }




    .title{
    float: left;
    width: 75%;
    text-align: left;
    box-sizing: border-box;
    padding: 14px;
    margin: auto;


    }

    .ftoggler{
    width: 100%;
    border: 1px solid #80B3FC;
    border-radius:5px;   
    box-shadow: 2px 3px 5px #EEF0F3;   


    }
    .cont{
    margin: 10px;
    }
    .Retroalimentacion{   
    margin: 2px;
    border-radius:5px; 
    padding: 14px;
    border: 1px solid;

    }
    .correcto{
    border: 1px solid green;
    background-color: rgba(156, 248, 124,0.4); /* Black w/ opacity */
    }
    .incorrecto{
    border: 1px solid red;
    background-color: rgba(247, 33, 33,0.4); /* Black w/ opacity */
    }



</style>
<?php
elgg_gatekeeper();
$group=elgg_extract("group", $vars);
$group=get_entity($group);
$cuestionario=elgg_extract("cuestionario", $vars);
$cuestionario=get_entity($cuestionario);
$respuesta=elgg_extract("respuesta", $vars);
$respuesta= get_entity($respuesta);
$user = elgg_get_logged_in_user_guid();


$vars['cuestionario']= $cuestionario->guid;
$vars['group']= $group->guid;
//elgg_group_gatekeeper(true, $group);

function twoDigitos($num){
    $numero= str_pad($num, 2, "0", STR_PAD_LEFT);
    return $numero;
}

$sitio=elgg_get_site_url();
$title=$cuestionario->nombre;
$content=elgg_view_title($title);

$intentosRealizados = elgg_get_entities([
    'type' => 'object',
    'subtype' => 'answer',
    'relationship' => 'respuestaCuestionario',
    'relationship_guid' => $cuestionario->guid,
    'inverse_relationship' => true,    
    'owner_guid' =>$user,
]);
$intentoActual = count($intentosRealizados);

$preguntas=elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',   
    'relationship' => 'preguntaCategoria',
    'relationship_guid' =>  $cuestionario->guid,
    'inverse_relationship' => true,
    'full_view' => false,
));


$html=""; $i=1; $color="#ededed";
$puntajeTotal=0; $nota="";
if(!$respuesta->guid){//responder examen
    list($puntajeObtenido,$puntajeTotal)=getPuntaje($preguntas,$respuesta,$html);
    //verificar si preguntar deben ser aleatorias para cada alumno
    $intentoActual = $intentoActual + 1;
    if($cuestionario->aleatorioAlumno=='on'){  
        $IDs=[];   
        $orden=[];//arreglo con id's de preguntas, aleatorio
        foreach($preguntas as $pregunta){
            array_Push($IDs,$pregunta->guid);
        }
        $list=random_questions($IDs,$orden,$cuestionario->numeroPreguntas);
       

        $preguntas=elgg_get_entities(array(
            'subtype'=>'questions',
            'type' => 'object',   
            'relationship' => "preguntaIntento-$intentoActual-$cuestionario->guid",
            'relationship_guid' =>  $user,
            'inverse_relationship' => true,
            'full_view' => false,
        ));
        $preguntas=array();
    
        foreach($list as $guid){//preguntas aleatorias, entidad
        add_entity_relationship($guid, "preguntaIntento-$intentoActual-$cuestionario->guid ",$user);

            $entidad=get_entity($guid);
            array_Push($preguntas,$entidad);
        
        }
    
    }
    foreach($preguntas as $pregunta){
       
        $html.="<div id='index-$i'class='pregunta' style='background-color:$color;'>$i</div>";
        $i++;
    }
    $timer=<<<___HTML
        <div class=''>
            <div id="hms" class="timerCuestionario"></div>    
        </div>
        <br>
    ___HTML;
    $estado_cuestionario = "Responder"; //Se está respondiendo el cuesitonario
}else{
    if($cuestionario->aleatorioAlumno=='on'){ 
       
        $preguntas=elgg_get_entities(array(
            'subtype'=>'questions',
            'type' => 'object',   
            'relationship' => "preguntaIntento-$intentoActual-$cuestionario->guid",
            'relationship_guid' =>  $user,
            'inverse_relationship' => true,
            'full_view' => false,
        ));
        

    }

    list($puntajeObtenido,$puntajeTotal,$html)=getPuntaje($preguntas,$respuesta,$html);
    $respuesta->nota = getNota($puntajeObtenido, $puntajeTotal, $cuestionario->exigencia/100, 1.0, 7.0, $cuestionario->calificacion);
    $respuesta->puntaje=$puntajeObtenido;
    $respuesta->save();
    $estado_cuestionario = "Revicion"; //Se está revisando el cuesitonario
    $nota = <<<___HTML
        Puntaje: $puntajeObtenido/$puntajeTotal <br>
        Nota: 
    ___HTML;
}


$puntaje_total= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'puntaje_total',
    'id' => 'puntaje_total',
    'value' => $puntajeTotal,
]);
$est_cuest= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'estado_cuestionario',
    'id' => 'estado_cuestionario',
    'value' => $estado_cuestionario,
]);
$FechaTermino= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'FechaTermino',
    'id' => 'FechaTermino',
    'value' =>$cuestionario->termino ."T".twoDigitos($cuestionario->horaTermino).":".twoDigitos($cuestionario->minutoTermino).":00Z",
]);
$limite= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'limite',
    'id' => 'limite',
    'value' => $cuestionario->limite,
]);
$nueva= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'nueva',
    'id' => 'nueva',
    'value' => $cuestionario->nueva,
]);
$cuestionarioInput= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'cuestionario',
    'id'=> 'cuestionario',
    'value' => $cuestionario->guid,
]);
$cuestionarioGroup= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'id'=> 'group',
    'value' => $cuestionario->group,
]);
$sitioURL= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'sitio',
    'id'=> 'sitio',
    'value' =>$sitio,
]);
$respuestaInput= elgg_view_field([//si olo se admite 1 intento
    '#type' => 'hidden',
    'name' => 'respuesta',
    'id'=> 'respuesta',
    'value' => $respuesta->guid,
]);
$intento= elgg_view_field([
    '#type' => 'hidden',
    'name' => 'intentoActual',
    'id'=> 'intentoActual',
    'value' => $intentoActual,
]);




$pagination=<<<___HTML
    <section id="preguntas" class=''>
    
    </section>  
___HTML;


$content=$limite;
$content.=$nueva;
$content.=$cuestionarioInput;
$content.=$cuestionarioGroup;
$content.=$sitioURLsi;
$content.=$timer;
$content.=$respuestaInput;
$content.=$pagination;
$content.=$est_cuest;
$content.=$FechaTermino;
$content.=$intento;
$content.=$puntaje_total;


$sidebar = <<<___HTML
            
            <div class="elgg-module elgg-owner-block  elgg-module-info fix">
                $nota 
                <div class="elgg-head">
                    <div data-guid="62" class="elgg-image-block clearfix elgg-chip">
                        <h2>Listado de preguntas </h2>
                    </div>
                </div>
                <div class="elgg-body">
                    $html
                </div>
            </div>
___HTML;



$body = elgg_view_layout('two_sidebar', array(
    'title'=>$title,
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page("Cuestionario", $body);



echo "<script type='text/javascript' src='{$sitio}mod/cuestionario/js/reply.js'></script>";
if(!$respuesta){
    echo "<script type='text/javascript' src='{$sitio}mod/cuestionario/js/timer.js'></script>";
}



function getPuntaje($preguntas,$res, $html){
    $index=1;
    $puntaje=0;

   
    $puntajeObtenido=0;
    foreach($preguntas as $pregunta){ 
        $puntaje+=$pregunta->puntuacion;
        $color="#FCA6A6";  
        
        $tipo= $pregunta->typeQuestion;
        if($tipo=='VF'){//PREGUNTAS VERDADERO FALSO
            $metadata="pregunta_".$pregunta->guid;        
            if($pregunta->respuestaCorrecta== $res->$metadata[1]){
                $puntajeObtenido= $puntajeObtenido+ $pregunta->puntuacion;    
                $color="#D7FCCB" ;         
            }
        }
        if($tipo=='SM'){//PREGUNTAS SELECCION MULTIPLE
            $puntos=0;
            $metadata="pregunta_".$pregunta->guid;//metadata[1] guarda las respuestas del alumno(opcion1_valor-opcion2_valor...)  
            $opcionesRespuesta  = getOpciones($res->$metadata[1]);//retorna array con respuesta
       
            for ($i=1; $i <= 5; $i++) { 
               $opcionPregunta="opcion".$i;             
               $calificacion="calificacion".$i;
               if($opcionesRespuesta[$opcionPregunta]==1){
                   $puntos=$puntos +(float)$pregunta->$calificacion;
                }             
            }
          
            $puntos= ceil($puntos);
            if($puntos>=100){//correcto   

                $puntajeObtenido= $puntajeObtenido+$pregunta->puntuacion;
                $color="#D7FCCB" ;
                            
            }elseif($puntos<=0){//incorrecto
                 
            }elseif($puntos>0 && $puntos<99){  ///parcialmente correcto
                $color="yellow" ;
            }   
        }
       
           
        $html.="<div id='index-$index'class='pregunta' style='background-color:$color;'>$index</div>";
        $index++;
      

    }
   return array($puntajeObtenido,$puntaje,$html);
}

// PO   = Puntaje Obtenido
// PT   = Puntaje Total
// PE   = Porcentaje de exigencia
// NMIX = Nota mínima
// NMAX = Nota máxima
// NA   = Nota de aprovación
function getNota($PO, $PT, $PE, $NMIN, $NMAX, $NA){ 
    if($PO < $PE*$PT)  return number_format(( ($NA-$NMIN) * ($PO / ($PE*$PT)) + $NMIN ), 2);
    if($PO >= $PE*$PT) return number_format(( ($NMAX-$NA) * (($PO-$PE*$PT) / ($PT * (1-$PE))) + $NA ), 2);
}

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

//funcion para ordenar de manera aleatoria un arreglo, retorna un arreglo
function random_questions($arr,$ordenQ,$n){
   
    $length= count($arr);
    $indice=rand(0,$length-1);
    array_Push($ordenQ,$arr[$indice]);
    //array_splice($arr,1,$indice);
    array_splice($arr,$indice,1);
    if(count($ordenQ)>=$n){ 
        foreach($ordenQ as $i){
            echo $i."-";
        }
       
        return $ordenQ;
    }else{
        return random_questions($arr,$ordenQ,$n);
    }
}


?>
<script>
    var resultados={};//variable global 
    resultados['respuestas']={}; //objeto para guardar las respuestas
</script>