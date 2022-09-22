<?php
/*
FORMULARIO PARA SUBIR ACTIVIDAD(alumno)
*/
$guid = elgg_extract('guid', $vars);//guid actividad
//echo($guid);


echo elgg_view_field([
    '#type' => 'file',
    'name' => 'upload',
    '#label' => elgg_echo('subir recurso'),    
     //'#help' => '',		
   // 'value' => ($guid),
	'required' => true,

]);




echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'actividad_guid',
    'value'=> $guid,    
]);

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot center',
    'value' => elgg_echo('guardar'),
));
elgg_set_form_footer($submit);