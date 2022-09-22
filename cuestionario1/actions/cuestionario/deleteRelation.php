<?php

$cuestionario=get_input('cuestionarioGuid');
$answer=get_input('answerGuid');

//remove_entity_relationship($answer,'PreguntaCuestionario',$cuestionario);

if(remove_entity_relationship($answer,'preguntaCategoria',$cuestionario)){
    system_message("Eliminado de la lista");
}

