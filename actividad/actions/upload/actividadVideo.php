<?php

$url = get_input('url');
$guid_A=get_input('actividad_guid');//guid de la actividad
$actividad= get_entity($guid_A);


//Elimninar si exite una respuesta
$options = array('type'=>'object','subtype'=>'respuesta');//respuesta Entidad
$entities= elgg_get_entities($options);
$existe=false;
foreach($entities as $entity){
  if($entity->owner_guid==elgg_get_logged_in_user_guid() && $entity->actividad==$actividad->guid){
    $entity->respuesta=$url;
    $existe=true;
    //system_message("existe"); 
    //$blog_guid = $entity->save();
    //delete_entity($entity->guid);           
   }
}


//si no existe respuesta se crea la entidad
if($existe==false){
//system_message("no existe"); 
$respuesta = new ElggObject();
//METADATOS DE OBJETO ENTREGA
$owner=get_entity(elgg_get_logged_in_user_guid());
$respuesta->title = $owner->name;
$respuesta->estadoEntrega=true;
$respuesta->modificacion= " ";
$respuesta->comentario= " ";
$respuesta->nota= " ";
$respuesta->owner_guid=elgg_get_logged_in_user_guid(); //quien sube la actividad
//$entrega->guid_group=get_input('guid_group');
$respuesta->subtype = 'respuesta';
$respuesta->actividad= $guid_A;//guid de actividad a la que pertenece
$respuesta->tipoEntrega=$actividad->tipoEntrega;
$respuesta->access_id=2; 
$respuesta->container_guid= $actividad->guid_group;
$respuesta->guid_group= $actividad->guid_group;
$respuesta->respuesta=$url;

$blog_guid = $respuesta->save();
//establecer relacion: respuesta
add_entity_relationship($blog_guid, 'respuesta', $actividad->guid);
add_entity_relationship( $actividad->guid, 'respuesta', $blog_guid);




}
/*
if ($blog_guid) {
  system_message("actividad enviada."); 
   
  // forward($respuesta->getURL());
    
   
} else {
  register_error("la actividad no pudo ser creada.");
  forward(REFERER); // REFERER es una variable global que define la página anterior
}

*/