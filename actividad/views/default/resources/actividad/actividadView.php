<?php
/* visualiza la actividad creada*/

// asegurarse que le usuario inicio sesion
gatekeeper();

// get the entity
$guid = elgg_extract('guid', $vars);
$mi_actividad = get_entity($guid);

//contenido de la actividad
$content = elgg_view_entity($mi_actividad, array('full_view' => true));


$params = array(
    'title' => $mi_actividad->title,
    'content' => $content,
    'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($mi_actividad->title, $body);

