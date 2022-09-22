<?php
/*
FORMULARIO PARA SUBIR url
*/
$guid = elgg_extract('guid', $vars);//guid de respuesta
$nota = elgg_extract('nota', $vars);
$comentario = elgg_extract('comentario', $vars);


$res= get_entity($guid);//respuesta
$propietario= get_entity($res->owner_guid);//alumno
$email=$propietario->email;

//actividad
$actividad= get_entity($res->actividad);



echo elgg_view_field([
    '#type' => 'text',
    'name' => 'nota',
    '#label' => elgg_echo('nota'),    
    //'#help' => '',
    'value'=> $nota,	  
	'required' => true,

]);
echo elgg_view_field([
    '#type' => 'longtext',
    'name' => 'comentario',
    '#label' => elgg_echo('Comentario'),    
    //'#help' => '',		 
    'value'=> $comentario,
	'required' => false,

]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'respuesta_guid',
    'value'=> $guid,    
]);
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'email',
    'value'=> $email,    
]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'titulo_actividad',
    'value'=>$actividad->title,    
]);

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot center',
    'value' => elgg_echo('evaluar'),
));
elgg_set_form_footer($submit);