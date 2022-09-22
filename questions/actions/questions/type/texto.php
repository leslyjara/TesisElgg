<?php



$group=get_input('group');
$guid=get_input('guid');
$categoria=get_input('categoria');
$nombre=get_input('nombre');
$texto=get_input('texto');
$puntuacion=get_input('puntuacion');
$ReGeneral=get_input('ReGeneral');


if($guid){
    $pregunta= get_entity($guid);
    $group=$group; //$pregunta->container_guid;

}else{   
    $pregunta = new ElggObject();
    $pregunta->subtype= 'questions';
    $pregunta->typeQuestion= 'texto';
    $pregunta->typeString= 'texto';
    $pregunta->container_guid=$categoria;
    $pregunta->owner= elgg_get_logged_in_user_guid();
}
$pregunta->container_guid=$categoria;
$pregunta->categoria=$categoria;
$pregunta->title=$nombre;
$pregunta->texto=$texto;
$pregunta->puntuacion=$puntuacion;
$pregunta->ReGeneral=$ReGeneral;
$pregunta->access_id=2 ;


$pregunta_guid =$pregunta->save();
if(!$guid){
    add_entity_relationship($pregunta->guid, 'preguntaCategoria',(int)$categoria);//sistema, grupo, cuestionario
}


if ($pregunta_guid) {
    system_message("Guardado");  
    $c= get_entity($categoria);
    //retornar a cuetionario
    if($c){
        if($c->getSubtype()=='cuestionario'){
            return elgg_redirect_response("cuestionario/view/$group/$categoria");
        } 
    }

    return elgg_redirect_response("questions/all/$group");
   // forward($pregunta->getURL());
       
       
 } else {
       register_error("Error al guardar");
       forward(REFERER); // REFERER es una variable global que define la página anterior
 }

