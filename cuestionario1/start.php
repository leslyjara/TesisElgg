<?php 

elgg_register_event_handler('init', 'system', 'cuestionario_init');

function cuestionario_init(){
	elgg_extend_view("css/elgg", "css/cuestionario/reply");
	elgg_extend_view("css/elgg", "css/cuestionario/style");
	elgg_register_ajax_view('forms/cuestionario/agregarQ');
	elgg_register_ajax_view('QuestionRelation');
	elgg_register_ajax_view('AnswerRelation');
	elgg_register_page_handler('cuestionario', 'cuestionario_page_handler');
	elgg_register_ajax_view('returnPreguntas');
	elgg_register_action("cuestionario/add", __DIR__. "/actions/cuestionario/add.php");
	elgg_register_action("cuestionario/view", __DIR__. "/actions/cuestionario/view.php");
	elgg_register_action("cuestionario/agregarQ", __DIR__. "/actions/cuestionario/agregarQ.php");
	elgg_register_action("cuestionario/reply", __DIR__. "/actions/cuestionario/reply.php");
	elgg_register_action("cuestionario/deleteRelation", __DIR__. "/actions/cuestionario/deleteRelation.php");
	elgg_register_action("cuestionario/habilitar", __DIR__. "/actions/cuestionario/habilitar.php");
	elgg_register_action("cuestionario/randomQuestions", __DIR__. "/actions/cuestionario/randomQuestions.php");


	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'cuestionario_owner_block_menu');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'answer_set_url');  
	elgg_register_plugin_hook_handler('entity:url', 'object', 'cuestionario_set_url');  
}

function cuestionario_page_handler($page){

    switch ($page[0]) {
		case 'add':
			$resource_vars['group'] = elgg_extract(1, $page);	//id grupo
			$resource_vars['page'] = elgg_extract(2, $page);//id de pagina de grupo
			echo elgg_view_resource('cuestionario/add', $resource_vars);
			break;
		case 'view':
			$resource_vars['group'] = elgg_extract(1, $page);	//id grupo
			$resource_vars['guid'] = elgg_extract(2, $page);	//id cuestionario
			echo elgg_view_resource('cuestionario/view', $resource_vars);
			break;
		case 'all':
			$resource_vars['group'] = elgg_extract(1, $page);	//id grupo
			echo elgg_view_resource('cuestionario/all', $resource_vars);
			break;
		case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $page);	//id cuestionario
			$resource_vars['page'] = elgg_extract(2, $page);//id de pagina de grupo
			echo elgg_view_resource('cuestionario/add', $resource_vars);
			break;
		case 'reply':
			$resource_vars['group'] = elgg_extract(1, $page);	//id grupo
			$resource_vars['cuestionario'] = elgg_extract(2, $page);//id cuestionario
			$resource_vars['respuesta'] = elgg_extract(3, $page);//id cuestionario
			echo elgg_view_resource('cuestionario/reply',$resource_vars);
			break;
		case 'answer':
			$resource_vars['guid'] = elgg_extract(1, $page);//id cuestionario
			echo elgg_view_resource('cuestionario/answer',$resource_vars);
			break;

		default:
			return false;
	}
}

function cuestionario_owner_block_menu($hook, $type, $return, $params){
	$entity = elgg_extract('entity', $params);
	$group = elgg_get_page_owner_entity(); //grupo
	$owner_group=$group->owner_guid;//propietario grupo
	$user =elgg_get_logged_in_user_guid(); //usuario actual
   
   
	if(($entity instanceof ElggGroup )) {//&&($group->owner_guid== $user)
		$url = "cuestionario/all/{$entity->guid}";
		$text =elgg_echo('Cuestionario');
		$item = new ElggMenuItem('cuestionario', $text,$url);
		if ($entity->isMember($user->guid)){
			$return[] = $item;
		}
		//$return[] = $item;
	}
	return $return;
}


function cuestionario_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'cuestionario')) {
        return "cuestionario/view/{$entity->group}/{$entity->guid}";        
    }
}
function answer_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'answer')) {
        return "cuestionario/answer/{$entity->guid}";        
    }
}
