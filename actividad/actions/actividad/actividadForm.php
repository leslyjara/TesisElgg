<?php
/* Archivo que guarda el formulario de creacion de actividad en la base de datos */
elgg_make_sticky_form('mi_actividad');
// get the form inputs
$existe=get_input('existe');
$title = get_input('nombre');
$archivo = get_input('upload');//nombre del archivo
$body = get_input('descripcion');
$tipoEntrega=get_input('tipoEntrega');
$conFecha = get_input('conFecha');//se define si la actividad tendra fecha
$fecha = get_input('fecha');
$hora=get_input('hora');
$minuto=get_input('minuto');
//$time = get_input('hora');
$porcentaje = get_input('porcentaje');
$guid_group =get_input('guid_group');
$guid_page =get_input('guid_page');


//si la actividad existe, editarla
if($existe==true){
   $actividad=get_input('guid_Act');
   $actividad=get_entity($actividad);
   $actividad->title = $title;
   $actividad->description = $body;
   $actividad->conFecha = $conFecha;//si se definira fecha de entrega
   $actividad->fechaTermino =$fecha ;
   $actividad->horaTermino=$hora;
   $actividad->minutoTermino=$minuto;
   $actividad->file = $file;
   $actividad->porcentaje= $porcentaje;
   $actividad->owner = elgg_get_logged_in_user_guid();//propietario
   $actividad->guid_group =$guid_group;//get_input('guid_group');//guid de grupo
   $actividad->tipoEntrega = $tipoEntrega;
   $actividad->access_id=2;

   //file
  
   //obtener entidad group
   $entity =get_entity($guid_group);   
   $file_type=$_FILES['upload']['type']; 

   $uploaded_files = elgg_get_uploaded_files('upload');
   $uploaded_file = array_shift($uploaded_files);
   if($uploaded_file){     
      $file = new ElggFile();
      $file->owner_guid = elgg_get_logged_in_user_guid();
      $file->subtype='file';
      $file->container='actividad';
      $file->access_id= $entity->access_id;//2;
      if ($file->acceptUploadedFile($uploaded_file)) {
         $archivo=$file->save();       
      }
      if(!$archivo){
         register_error("archivo no subido!");
         forward(REFERER);
      }
         
   } 

   //---------------------------------
   $actividad->archivo=$file->guid;


   $blog_guid=$actividad->save();
   if($archivo){
      add_entity_relationship($actividad->guid, 'recurso',$file->guid);
      ///add_entity_relationship($file->guid, 'recurso', $actividad);
   }
   
     
//si no existe, se crea
}else{  
   $actividad = new ElggObject();
   //METADATOS DE OBJETO ACTIVIDAD
   $actividad->title = $title;
   $actividad->description = $body;
   $actividad->conFecha = $conFecha;//si se definira fecha de entrega


   $actividad->fechaTermino =$fecha ;
   $actividad->horaTermino=$hora;
   $actividad->minutoTermino=$minuto;
   $actividad->file = $file;
   $actividad->container_guid=$guid_group;
   $actividad->porcentaje= $porcentaje;
   $actividad->estado=true; // actividad disponible
   $actividad->owner = elgg_get_logged_in_user_guid();//propietario
   $actividad->guid_group =get_input('guid_group');//guid de grupo
   // subtipo
   $actividad->subtype = 'mi_actividad';
   //$actividad->saveIconFromLocalFile('graphics/icons/default/small.png');
   
   //------------------------
   $access = get_input('guid_group');
   //obtener entidad group
   $entity =get_entity($access);
   $actividad->access_id = $entity->access_id;//
   $actividad->tipoEntrega = $tipoEntrega;
 
   //---------------------------------
   //$icon = $_FILES['upload'];
   $file_type=$_FILES['upload']['type'];
      

   $uploaded_files = elgg_get_uploaded_files('upload');
   $uploaded_file = array_shift($uploaded_files);


   if($uploaded_file){     
      $file = new ElggFile();
      $file->owner_guid = elgg_get_logged_in_user_guid();
      $file->subtype='file';
      $file->container='actividad';
      $file->access_id= $entity->access_id;//2;
      if ($file->acceptUploadedFile($uploaded_file)) {
         $archivo=$file->save();       
      }
      if(!$archivo){
         register_error("archivo no subido!");
         forward(REFERER);
      }
         
   } 

   //---------------------------------
   $actividad->archivo=$file->guid;

   // guardar en la base de datos y obtener la identificación del nuevo my_blog

   $blog_guid = $actividad->save();
   $grupo=get_entity($guid_group);


   //establecer relacion:
   if($uploaded_file){
   add_entity_relationship($blog_guid, 'recurso',$file->guid);
   add_entity_relationship($file->guid, 'recurso', $blog_guid);
   }
   //establecer relacion: actividad pertenece a un grupo
   if(!$existe){

        $members = elgg_get_entities([
      'type' => 'user',
      'subtype' =>'user',
      'relationship' => 'member',
      'relationship_guid' => $grupo->guid,
      'inverse_relationship' => true,

   ]);

      $user =  elgg_get_logged_in_user_guid();
      $user = get_entity($user);

      elgg_create_river_item(array(
         'view' => 'river/object/actividad/create',
         'action_type' => 'create', 
         'subject_guid' => $user->guid,
         'object_guid' => $actividad->getGUID(),
      ));
      elgg_trigger_event('publish', 'object', $actividad);

      add_entity_relationship($grupo->guid, 'pertenece', $blog_guid);   
      add_entity_relationship($blog_guid, 'pertenece', $grupo->guid);
   }

   if($guid_page){
      add_entity_relationship($actividad->guid, 'recursoPagina', $guid_page);
      add_entity_relationship($actividad->guid, 'recursoGrupo', $guid_group);
   }
 
   

   



}




// si se guardo la actividad se mostrara la nueva publicacion
// de lo contrario resporta un error.

if ($blog_guid) {
   system_message("Guardado");
  // elgg_clear_sticky_form('mi_actividad');
 
   forward($actividad->getURL());
      
      
} else {
      register_error("la actividad no pudo ser creada.");
      forward(REFERER); // REFERER es una variable global que define la página anterior
}
