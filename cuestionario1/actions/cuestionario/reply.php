<?php
//GUARDA ENTIDAD RESPUESTA
$respuestas=get_input('respuestas');
$intentoActual=get_input('intentoActual');
$cuestionario =get_input('cuestionario');
$puntaje_total =get_input('puntaje_total');
$cuestionario=get_entity($cuestionario);

$user = elgg_get_logged_in_user_guid();


$usuario = elgg_get_logged_in_user_guid();
$answer = new ElggObject();
$answer->subtype        = 'answer';
$answer->owner          = $usuario;
$answer->owner_guid     = $usuario;
$answer->access_id      = 1;
$answer->puntaje        = 0;
$answer->nota           = 0;
$answer->notaTotal      = 0;
$answer->puntaje_total  = $puntaje_total;

if($cuestionario->aleatorioAlumno=='on'){ 
    $relationship="preguntaIntento-$intentoActual-$cuestionario->guid";
    $relationship_guid=$user;
}else{ 
    $relationship="preguntaCategoria";
    $relationship_guid=$cuestionario->guid;
   
}

$preguntas= elgg_get_entities([
    'subtype'=>'questions',
    'type' => 'object',   
    'relationship' => $relationship,
    'relationship_guid' =>  $relationship_guid,
    'inverse_relationship' => true,
    'full_view' => false,
  
]);


$indiceBorrar=array_search($usuario,$cuestionario->habilitadoPara);
$arrTemp=$cuestionario->habilitadoPara;
array_splice($arrTemp,$indiceBorrar);//borra elemnto de array()
$cuestionario->habilitadoPara=$arrTemp;



foreach($preguntas as $p){ //id de cada pregunta
    $pregunta=$p->guid;
    $metadata = "pregunta_".$pregunta;
    if(is_array($respuestas[$pregunta])) { //SM
       
        $arreglo="";
        foreach($respuestas[$pregunta] as $respuesta){
            $arreglo.=$respuesta."-";
        }
        $answer -> $metadata = [$pregunta, $arreglo];
    }
    if($respuestas[$pregunta]["opcion"]=="Verdadero" || $respuestas[$pregunta]["opcion"]=="Falso") { //VF
    
        $answer -> $metadata = [$pregunta, $respuestas[$pregunta]["opcion"]];
    }
}

$save = $answer->save();
add_entity_relationship($answer->guid, 'respuestaCuestionario', (int)$cuestionario->guid);

if ($save) {
    system_message("Examen finalizado");
    //forward("cuestionario/answer");//No funciona
    //forward($answer->getURL());
    echo json_encode([
        'sitio'     => elgg_get_site_url(),
        'urlEntity' => $answer->getURL(), 
        'guidEntity'=> $answer->guid,
    ]);
   
}else {
       register_error("El exámen falló");
       forward(REFERER); // REFERER es una variable global que define la página anterior
}

