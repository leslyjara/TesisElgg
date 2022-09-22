<?php
//MUESTRA UNA LISTA CON LAS PREGUNTAS QUE PERTENECES A UN CUESTIONARIO
$cuestionario=(int)elgg_extract('cuestionario',$vars);



//$cuestionario= elgg_extract("cuestionario",$vars);

echo elgg_list_entities(array(
    'type'=>'object',
    'subtype'=>'questions',
    'relationship' => 'preguntaCategoria',
    'relationship_guid' => $cuestionario ,
    'inverse_relationship' => true,
    'full_view' => false,
    'cuestionario'=>$cuestionario
));