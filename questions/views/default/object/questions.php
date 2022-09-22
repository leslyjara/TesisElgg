<?php
$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);
$sitio=elgg_get_site_url();
$cuestionario=elgg_extract('cuestionario', $vars,FALSE);


//vista list entity
if(!$full){	
	$opt= elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'questions',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	//$file_icon = elgg_view_entity_icon($entity, 'small', array('href' => false));	
	$file_icon="<a><img src='{$sitio}/mod/questions/images/{$entity->typeQuestion}.png ' ></img></a>";
	
	//--------------------------
	$vars['owner_url'] = "$entity->owner";
	$by_line = elgg_view('page/elements/by_line', $vars);
	$subtitle = "$by_line"; 
	//echo $opt;
	
	$params = array(
		'entity' => $entity,
		//'metadata' => $metadata,
		'subtitle' => $subtitle,
		//'content' => $excerpt,
		'icon' => $file_icon,
		
	);
	$params = $params + $vars;
	
	$deleteRelation= elgg_view('output/url', array(
		'text' => 'Eliminar de la lista',
		'href' => "action/cuestionario/deleteRelation?answerGuid={$entity->guid}&cuestionarioGuid={$cuestionario }",	
		'confirm' => "Seguro que desea eliminar esta prengunta del cuestionario?",
		//'is_trusted' => true,
		'is_action' => true,
		
	));
	$time=elgg_get_friendly_time($entity->time_created);
	echo  <<<___HTML
		<div class='elgg-image-block clearfix elgg-river-item'>
			<div class='elgg-image'>
				<div class='elgg-avatar  '>
					$file_icon				
				</div>
			
			</div>
			<div class='elgg-body'>
				<div class="elgg-listing-summary-metadata">
					<nav class="elgg-menu-container elgg-menu-entity-container" data-menu-name="entity">
						<ul class='elgg-menu elgg-menu-social elgg-menu-hz elgg-menu-social-default'>
						<li class='elgg-menu-item-comment  '><a href="{$sitio}questions/edit/{$entity->guid}">Editar</a></li>
						<li class='elgg-menu-item-comment  '><a >$deleteRelation</a> </li>
					</ul>					
					</nav>
				</div>
				<div class='elgg-river-summary'>
					<spam class='elgg-anchor-label'>$entity->title</spam>
					<spam class='elgg-river-timestamp'>$time </spam>
				</div>
			</div>

			
		
		</div>
		
	___HTML;

	//echo elgg_view('object/elements/summary', $params); 
	
	
}

// $entity->title
// 			<a href="{$sitio}questions/edit/{$entity->guid}">Editar</a> 
// 			<a >$deleteRelation</a>
