<?php

elgg_register_event_handler('init', 'system', 'question_init');
function question_init(){
   
   // extend site css
	elgg_extend_view("css/elgg", "css/questions/select");

   elgg_extend_view("js/elgg", "js/questions/modalAdd");
   // echo elgg_get_context();
   elgg_register_action("questions/select", __DIR__ . "/actions/questions/select.php");
   elgg_register_action("questions/type/verdaderoFalso", __DIR__ . "/actions/questions/type/verdaderoFalso.php");
   elgg_register_action("questions/type/seleccionMultiple", __DIR__ . "/actions/questions/type/seleccionMultiple.php");
   elgg_register_action("questions/type/texto", __DIR__ . "/actions/questions/type/texto.php");
   elgg_register_action("questions/deleteQ", __DIR__ . "/actions/questions/deleteQ.php");

   elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'questions_owner_block_menu');

   elgg_register_ajax_view('forms/questions/deleteQ');
   elgg_register_ajax_view('preguntas');

  // elgg_register_js("deleteQ", elgg_get_site_url() ."mod/questions/js/forms/deleteQ.js");

   elgg_register_page_handler('questions', 'questions_page_handler');    
}
function questions_page_handler($segments){ 
   switch($segments[0]){   
      case "all":
         $resource_vars['group'] = elgg_extract(1, $segments);
         echo elgg_view_resource("questions/all",$resource_vars);
         break;
      case "add":
         $resource_vars['group'] = elgg_extract(1, $segments);
         $resource_vars['type'] = elgg_extract(2, $segments);
         $resource_vars['cuestionario'] = elgg_extract(3, $segments);
         echo elgg_view_resource("questions/add",$resource_vars);
         break;
      case "edit":
         $resource_vars['guid'] = elgg_extract(1, $segments);//guid entity
         $resource_vars['group'] = elgg_extract(2, $segments);//guid entity
         echo elgg_view_resource("questions/add",$resource_vars);
         break;

   }
}

function questions_owner_block_menu($hook, $type, $return, $params){
   $entity = elgg_extract('entity', $params);
   $group = elgg_get_page_owner_entity();   //grupo  
   $owner_group=$group->owner_guid;//propietario grupo
   $user =elgg_get_logged_in_user_guid(); //usuario actual
  
  
   if(($entity instanceof ElggGroup  )&&($group->owner_guid== $user)) {          
       $url = "questions/all/{$entity->guid}";
       $text =elgg_echo('Banco de preguntas');
       $item = new ElggMenuItem('preguntas', $text,$url);
       $return[] = $item; 
  
   }    
   return $return;
}