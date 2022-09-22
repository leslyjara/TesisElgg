<?php


/*
MUESTRA TODAS LAS ACTIVIDADES
QUE PERTENECEN A UN GRUPO DETERMIDADO
*/
// asegurarse que le usuario inicio sesion
gatekeeper();

$titlebar = "actividad";
$pagetitle = "Actividades";



$guid = elgg_extract('group', $vars);//guid de grupo
$group=get_entity($guid);//grupo entidad
//acceso solo para miembros del grupo
elgg_group_gatekeeper(true, $guid);
//contexto grupo
elgg_set_page_owner_guid($group->guid);

$agregar = elgg_view('output/url', array(
	'href' => "actividad/add/$group->guid",
	'text' => elgg_echo('Nueva Tarea'),
    'class' => "elgg-button  elgg-button-submit",
));
$content="";
//solo el propietario puede crear tareas
if(elgg_get_logged_in_user_guid() == $group->getOwnerEntity()->guid ){
	$content.= $agregar;
}


//actividades del curso

$content.=  elgg_list_entities([
    'type' => 'object',
    'subtype'=>'mi_actividad', 
    'relationship' =>'pertenece',// tipo de relacion
    'relationship_guid' =>$group->guid, 
    'full_view' => false,
   // 'inverse_relationship' => true,
    'no_results' => elgg_echo('Sin actividades.'), 
    
    //'preload_owners' => true,
	//'preload_containers' => true,
	//'distinct' => false,
 
        
]);




$sidebar= elgg_view('sidebar/options', array(
    'group' => $group->guid,
       
));



// layout the page
$body = elgg_view_layout('one_sidebar', array(
    'title'=> "{$group->name}: Actividades",
   'content' => $content,
   'sidebar' => $sidebar,
));
echo elgg_view_page($titlebar, $body);


