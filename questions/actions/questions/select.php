<?php

$pregunta= get_input('preguntas');
//system_message("pregunta seleccionada ". $pregunta);
$group= get_input('group');
$cuestionario= get_input('cuestionario');//guid cuestionario
if($pregunta==='VerdaderoFalso'){
    $type='VF';
}
if($pregunta==='seleccionMultiple'){
    $type='SM';
}
if($pregunta==='texto'){
    $type='texto';
}

return elgg_redirect_response("questions/add/$group/$type/$cuestionario");

