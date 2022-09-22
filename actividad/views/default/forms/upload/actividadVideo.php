<?php
/*
FORMULARIO PARA SUBIR url
*/
$guid = elgg_extract('guid', $vars);//guid actividad

$texto= elgg_extract('texto', $vars);


echo elgg_view_field([
    '#type' => 'url',
    'name' => 'url',
    '#label' => elgg_echo('Insertar URL'),    
    //'#help' => 'Insertar url',		
   'value' => $texto,
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