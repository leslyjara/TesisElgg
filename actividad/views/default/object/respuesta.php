<?php
//ARCHIVO PARA VISTAS DE OBJETOS

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);


//vista list entity
if(!$full){	
	$opt= elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'mi_actividad',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	$file_icon = elgg_view_entity_icon($entity, 'small', array('href' => false));
	$icon=elgg_view('object/elements/full', array(
		'body' => $body,
		'entity' => $entity,
		'icon' => $file_icon,
		'summary' => $summary,		
		
	));
	$vars['owner_url'] = "$entity->owner";
	$by_line = elgg_view('page/elements/by_line', $vars);
	$subtitle = "$by_line"; 
	echo $opt;	
	$params = array(
		'entity' => $entity,
		//'metadata' => $metadata,
		'subtitle' => $subtitle,
		//'content' => $excerpt,
		'icon' => $file_icon,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params); 	
	
}

