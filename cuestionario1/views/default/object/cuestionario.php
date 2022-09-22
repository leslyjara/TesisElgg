<?php

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);
$sitio=elgg_get_site_url();
$user=elgg_get_logged_in_user_guid();

$test_icon="<a><img src='{$sitio}/mod/cuestionario/images/cuestionario.png ' ></img></a>";
$check_icon="$sitio/mod/reportEDU/images/icons/check.png";
$x_icon="$sitio/mod/reportEDU/images/icons/x.png";
$circle_icon="$sitio/mod/reportEDU/images/icons/circle.png";

//vista list entity
if(!$full){
  $opt= elgg_view_menu('entity', array(
    'entity' => $vars['entity'],
    'handler' => 'cuestionario',
    'sort_by' => 'priority',
    'class' => 'elgg-menu-hz',
  ));
  
  //$file_icon = elgg_view_entity_icon($entity, 'small', array('href' => false));
  $file_icon = elgg_view_entity_icon($entity, 'small');

  //$icon = $CONFIG->wwwroot ."mod/folder/graphics/folders-tiny.jpg";

  //$folder_icon = elgg_view('pages/icon', array('annotation' => $annotation, 'size' => 'small'));
  //--------------------------
  $vars['owner_url'] = "$entity->owner";
  $by_line = elgg_view('page/elements/by_line', $vars);
  $subtitle = "$by_line";
  $title= "$entity->nombre";
  //echo $opt;
  $params = array(
    'entity' => $entity,
    'subtitle' => $subtitle,
   //'title'=> $title,
   // 'content' => $excerpt,
    'icon' => $test_icon,//$file_icon,
  );
  $params = $params + $vars;

  
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



  echo elgg_view('object/elements/summary', $params);
  
}