<?php
//MUESTRA UNA LISTA CON LAS PREGUNTAS QUE PERTENECES A UN CUESTIONARIO
$cuestionario=(int)elgg_extract('cuestionario',$vars);
$cuestionario=get_entity($cuestionario);

echo elgg_list_entities(array(
    'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $cuestionario->group,
	'inverse_relationship' => true,
    'item_view' => 'user_list',
	'limit' => 0,
	'cuestionario' => $cuestionario->guid,
	'group' => $cuestionario->group,
));