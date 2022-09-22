<?php

elgg_register_event_handler('init', 'system', 'actividad_init');
function actividad_init() {
 // echo elgg_get_context();
    //menu_item();  

    elgg_register_entity_type('object', 'mi_actividad');
        
    #registrar accion
    elgg_register_action("actividad/actividadForm", __DIR__ . "/actions/actividad/actividadForm.php");
    elgg_register_action("upload/actividadUpload", __DIR__ . "/actions/upload/actividadUpload.php");
    elgg_register_action("upload/actividadVideo", __DIR__ . "/actions/upload/actividadVideo.php");
    elgg_register_action("upload/actividadTexto", __DIR__ . "/actions/upload/actividadTexto.php");
    elgg_register_action("nota/nota", __DIR__ . "/actions/nota/nota.php");
    elgg_register_action("export/uos", __DIR__ . "/actions/export/uos.php");
    elgg_register_action("export/XML", __DIR__ . "/actions/export/XML.php");
        
    #registrar controlador de la pagina
    elgg_register_page_handler('actividad', 'actividad_page_handler');    
    
    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'actividad_owner_block_menu'); // Add menu in group menu
    
    //elgg_register_entity_type('object', 'mi_actividad');
    //add_group_tool_option('actividad', elgg_echo('group:actividad'), true);
    //elgg_extend_view('groups/tool_latest', 'actividad/group_module');//agregar a group tools

    // register a hook handler to override urls
    elgg_register_plugin_hook_handler('entity:url', 'object', 'mi_actividad_set_url');  
    elgg_register_plugin_hook_handler('entity:url', 'object', 'respuesta_set_url');  
    elgg_register_plugin_hook_handler('entity:url', 'object', 'entrega_set_url');  
    elgg_register_plugin_hook_handler('entity:url', 'object', 'file_view');


	// Notifications
    elgg_register_notification_event('object', 'mi_actividad', array('create'));
    elgg_register_plugin_hook_handler('prepare', 'notification:create:object:mi_actividad', 'actividad_prepare_notification');
}


function actividad_page_handler($segments) { 
    //$user =elgg_get_logged_in_user_guid(); //usuario actual
    //elgg_set_page_owner_guid($user);


    switch ($segments[0]){   
        
        case 'add':             
           if($segments[1]){
                $resource_vars['group']=$segments[1]; //guid grupo
                $resource_vars['page']=$segments[2]; //guid page
                echo elgg_view_resource('actividad/actividadAdd',$resource_vars);
           }else return false;           
           break;

        case 'actividadView':
            if($segments[1]){
                $resource_vars['guid'] = elgg_extract(1, $segments);
                echo elgg_view_resource('actividad/actividadView', $resource_vars);
            }else return false;            
            break;
        case 'all':        
            //si parametro 1 no es nulo
            if($segments[1]){               
                $resource_vars['group'] = $segments[1];//guid de grupo
                echo elgg_view_resource('actividad/todos',$resource_vars);
               // return true;   
            }else return false;                   
           break;
        case 'cursos'://no usado aun
            $resource_vars['guid'] = elgg_extract(1, $segments);
            echo elgg_view_resource('cursos/listarCursos',$resource_vars);
            break;
        case 'upload':
            $resource_vars['guid'] = elgg_extract(2, $segments);//guid de entidad object
            $resource_vars['group'] = elgg_extract(1, $segments);
            echo elgg_view_resource('upload/actividadUpload',$resource_vars); 
            break;
        case 'view':
            $resource_vars['guid'] = elgg_extract(2, $segments);
            $resource_vars['group'] = elgg_extract(1, $segments);
            echo elgg_view_resource('upload/view',$resource_vars); 
            break;
        case 'status':
            if($segments[1]){
                $resource_vars['group'] = elgg_extract(1, $segments);//guid grupo
                echo elgg_view_resource('actividad/status',$resource_vars); 
            }else return false;             
            break;
        case 'edit':
            $resource_vars['entity'] = elgg_extract(1, $segments);//guid grupo
            echo elgg_view_resource('actividad/edit',$resource_vars); 
            break;
        case 'file':
            $resource_vars['guid'] = elgg_extract(1, $segments);//guid grupo
            echo elgg_view_resource('file/view',$resource_vars);
            break;



    }    
   // elgg_pop_context();
    return true;
}

/**
 * Add a menu item to an ownerblock
 */
// function actividad_owner_block_menu($hook, $type, $return, $params){
//      $entity = elgg_extract('entity', $params);
//     $group = elgg_get_page_owner_entity();   //grupo  
//     $owner_group=$group->owner_guid;//propietario grupo
//     $user =elgg_get_logged_in_user_guid(); //usuario actual
   
   
//     if(($entity instanceof ElggGroup )||  (elgg_in_context('actividad'))) {          
//         $url = "actividad/all/{$entity->guid}";
//         $text =elgg_echo('tareas');
//         $item = new ElggMenuItem('tareas', $text,$url);
//         $return[] = $item;
   
//     }    


//     return $return; 
// }
function actividad_owner_block_menu($hook, $type, $return, $params){
    $entity = elgg_extract('entity', $params);
    $group = elgg_get_page_owner_entity();   //grupo  
    $owner_group=$group->owner_guid;//propietario grupo
    $user =elgg_get_logged_in_user_guid(); //usuario actual
  
  
   if(($entity instanceof ElggGroup )||  (elgg_in_context('actividad'))) {  
       
        $url = "#";//"actividad/all/{$entity->guid}";
        $text =elgg_echo('actividad:task');
        $parent = new ElggMenuItem('task', $text,$url);//menu padre

        if($owner_group==$user){
            $add = new ElggMenuItem('taskAdd', elgg_echo('actividad:add'),"actividad/add/{$group->guid}");//menu hijo1
            $parent->addChild( $add);
        }
        

        $all = new ElggMenuItem('taskAll', elgg_echo('actividad:all'),"actividad/all/{$group->guid}");//menu hijo2
        $parent->addChild( $all);

        $grades = new ElggMenuItem('taskGrades', elgg_echo('actividad:grades'),"actividad/status/{$group->guid}");//menu hijo3 calificaciones
        $parent->addChild($grades ); 

        
            
       
        

     
 
        $return[] = $parent; 
    
  
    }    


   return $return; 
}


//genera un URL
function entrega_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'entrega')) {
        return "actividad/upload/{$entity->guid_group}{$entity->guid}";        
    }
}

function mi_actividad_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'mi_actividad')) {
        return "actividad/upload/{$entity->guid_group}/{$entity->guid}";        
    }
}

function respuesta_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    //echo $entity->guid;
    if (elgg_instanceof($entity, 'object', 'respuesta')) {      
        return "actividad/view/{$entity->guid_group}/{$entity->guid}";    
        
    }
}

// function menu_item() {         
//     //devuelve un ElggGroup
//     $page_owner = elgg_get_page_owner_entity();      
//     elgg_view('sidebar/options', array(
//         'group' => $page_owner->guid,           
//     ));    
// }


function file_view($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'file')) {
        return "actividad/file/$entity->guid";
    }
}

function actividad_prepare_notification($hook, $type, $notification, $params) {

    $entity = $params['event']->getObject();
    $owner = $params['event']->getActor();
    $recipient = $params['recipient'];
    $language = $params['language'];
    $method = $params['method'];
    $group = $entity->guid_group;
    $group = get_entity($group);
    $categoriaGrupo = $group->categoria;

    // Title for the notification
    
    if($categoriaGrupo == "curso"){
	$subject =elgg_echo('actividad:notification:subject',[$group->name], $language);
	$summary =  elgg_echo('actividad:notification:summary',array($group->name), $language);
    }else{
	$subject = elgg_echo('actividad:notification:subject:CFProssional',[$group->name], $language);
	$summary = elgg_echo('actividad:notification:summary:CFProssional',array($group->name), $language);	

    }
    $notification->subject = $subject;

    // Message body for the notification
    $notification->body = elgg_echo('actividad:notification:body', array(
        $group->name,
        $entity->title,
        $entity->description,
        $owner->name,
       
    ), $language);

    // Short summary about the notification
    $notification->summary = $summary;

    return $notification;
}
