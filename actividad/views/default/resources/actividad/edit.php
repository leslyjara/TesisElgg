<?php



//actividad
$guid = elgg_extract('entity', $vars);
$entity = get_entity($guid);

//grupo
$guid=$entity->guid_group;
$group=get_entity($guid);//grupo entidad 
//contexto grupo
elgg_set_page_owner_guid($group->guid);

$titlebar = "actividad";
$pagetitle = "Actividades";

$form_vars = array('enctype' => 'multipart/form-data');


$content.= elgg_view_form("actividad/actividadForm",  $form_vars,$vars); //vars, entidad actividad


$sidebar= elgg_view('sidebar/options', array(
    'group' => $group->guid,
       
));



// layout the page
$body = elgg_view_layout('one_sidebar', array(
    'title'=> elgg_echo('Editar Actividad'),
   'content' => $content,
   'sidebar' => $sidebar,
));
echo elgg_view_page($titlebar, $body);
