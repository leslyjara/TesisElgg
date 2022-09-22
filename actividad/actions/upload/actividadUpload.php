<?php

$archivo = get_input('upload');//archivo
$guid_A=get_input('actividad_guid');//guid de la actividad
$actividad= get_entity($guid_A);
 

//archivo subido
$file_type=$_FILES['upload']['type'];
$uploaded_files = elgg_get_uploaded_files('upload');
$uploaded_file = array_shift($uploaded_files);
  
if($uploaded_file){     
    $file = new ElggFile();
    $file->owner_guid = elgg_get_logged_in_user_guid();
    $file->subtype='file';
    $file->access_id =2;
    $file->container='actividad';
    $file->group = $actividad->guid_group;
  
    if ($file->acceptUploadedFile($uploaded_file)) {
      $archivo=$file->save();         
   
    }
    if(!$archivo){
       register_error("archivo no subido!");
       forward(REFERER);
    }else{
      system_message("archivo  subido!");
    }
} 

$existe=false;
//Elimninar si exite una respuesta
$options = array('type'=>'object','subtype'=>'respuesta');//respuesta Entidad
$entities= elgg_get_entities($options);
foreach($entities as $entity){
  if($entity->owner_guid==elgg_get_logged_in_user_guid() && $entity->actividad==$actividad->guid){

   $R=$entity->respuesta;
  
   $existe=true;  
  // delete_entity($R);
   $entity->respuesta=$file->guid;

   }
}



//si no existe respuesta se crea la entidad
if($existe==false){


   $respuesta = new ElggObject();
   //METADATOS DE OBJETO ENTREGA
   $respuesta->estadoEntrega=true;
   $owner=get_entity(elgg_get_logged_in_user_guid());
   $respuesta->title = $owner->name;
   $respuesta->modificacion= " ";
   $respuesta->comentario= " ";
   $respuesta->nota= " ";
   $respuesta->owner_guid=elgg_get_logged_in_user_guid(); //quien sube la actividad
   //$entrega->guid_group=get_input('guid_group');
   $respuesta->subtype = 'respuesta';
   $respuesta->actividad= $guid_A;//guid de actividad a la que pertenece
   $respuesta->tipoEntrega=$actividad->tipoEntrega;
   $respuesta->guid_group= $actividad->guid_group;
   $respuesta->access_id=2; 
   $respuesta->container_guid= $actividad->guid_group;
   $respuesta->respuesta=$file->guid;
   $blog_guid = $respuesta->save();
   //establecer relacion: archivo
}
if($archivo){
   add_entity_relationship($actividad->guid, 'respuestaF',$file->guid);
   add_entity_relationship($file->guid, 'respuestaF', $actividad->guid);
}


//establecer relacion: respuesta
add_entity_relationship($blog_guid, 'respuesta', $actividad->guid);
add_entity_relationship( $actividad->guid, 'respuesta',$blog_guid);


// if ($blog_guid) {
//    system_message("la actividad ha sido enviada."); 
   
//    // forward($respuesta->getURL());      
   
// } else {
//    register_error("la actividad no pudo ser enviada.");
//    forward(REFERER); // REFERER es una variable global que define la página anterior
// }




 




