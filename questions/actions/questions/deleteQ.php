<?php

//$container= get_input('container');
$container = get_input('container');
$group= get_input('group');
$cuestionario = get_input('cuestionario');
$submit= get_input('hide_input');
$cuestionario = get_entity($cuestionario);

$p= elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',
    //'full_view'=>true,
));

foreach($p as $pregunta){    
    
    $guid=get_input($pregunta->guid."entity"); 
    if($guid){
        $pregunta->delete();
        system_message("Pregunta eliminada");
        system_message($guid);
    //     if ($submit=="agregar"){
    //         // add_entity_relationship($pregunta->guid, 'PreguntaCuestionario',$cuestionario->guid);
    //         system_message("Pregunta agregada");
    //     }else{
    //         $pregunta->delete();
    //         system_message("Pregunta eliminada");
    //     }
    // }else{
    //     system_message("asd ".$guid);
    }
}


$vars['group']=$group->guid;
$vars['container']=$container;
//echo elgg_view_form('questions/deleteQ',array(),$vars);

/* 
echo json_encode([
    'sum' =>(int)1,
    'product' =>42,
]);  */