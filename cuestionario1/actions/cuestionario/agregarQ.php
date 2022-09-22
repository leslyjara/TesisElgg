<?php


$container = get_input('container');
$group= get_input('group');
$cuestionario = (int)get_input('cuestionario');



$p= elgg_get_entities(array(
    'subtype'=>'questions',
    'type' => 'object',
));

foreach($p as $pregunta){    
    $guid=get_input($pregunta->guid."entity"); 
    if($guid){
        if(check_entity_relationship($pregunta->guid, 'preguntaCategoria', $cuestionario)) {
            system_message("La pregunta {$pregunta->title} ya existe en este cuestionario");

        }else{
            add_entity_relationship($pregunta->guid, 'preguntaCategoria', $cuestionario);
            system_message("Pregunta agregada");
        }
        
    }
}
