<?php
//ARCHIVO PARA VISTAS DE OBJETOS

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);
$sitio=elgg_get_site_url();
$user=elgg_get_logged_in_user_guid();

$task_icon="<a><img src='{$sitio}/mod/actividad/images/icons/task.png ' ></img></a>";
$check_icon="$sitio/mod/reportEDU/images/icons/check.png";
$x_icon="$sitio/mod/reportEDU/images/icons/x.png";
$circle_icon="$sitio/mod/reportEDU/images/icons/circle.png";

//vista list entity
if(!$full){	
	$opt= elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'actividad',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	//$file_icon = elgg_view_entity_icon($entity, 'small', array('href' => false));
	
	$file_icon = elgg_view_entity_icon($entity, 'tiny');
	
	//--------------------------
	$owner=get_entity($entity->owner);
	$vars['owner_url'] = "profile/{$owner->name}";
	$by_line = elgg_view('page/elements/by_line', $vars);
	$subtitle = "$by_line"; 

	if($entity->conFecha == 'on'){
		$fechaDeEntrega = "Fecha de Entrega: $entity->fechaTermino  $entity->horaTermino : $entity->minutoTermino ";
	}
	
	$params = array(
		'entity' => $entity,
		//'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => "$entity->description $fechaDeEntrega",
		'icon' =>elgg_view_icon('file'),// $task_icon,//file_icon,
		
	);
	$params = $params + $vars;
	//echo elgg_view('object/elements/summary', $params); 
	//echo "<div><img  class='icon-state-report' src=$check_icon></img></div>";
	
	if($entity->owner==elgg_get_logged_in_user_guid() ){
		echo $opt;
	}else{
		if (elgg_is_active_plugin('reportEDU')) {
			if(check_entity_relationship($user, 'visualizar', $entity->guid)){
				echo "<div><img  class='icon-state-report' src=$check_icon></img></div>";
			}else{
				echo "<div><img  class='icon-state-report' src=$circle_icon></img></div>";
			}


			
		}
	}

	echo  elgg_view('object/elements/summary', $params); 
	

	
	
	
}



