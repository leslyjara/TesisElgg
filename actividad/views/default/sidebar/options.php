<?php

/*
OPCIONES PARA BARRA LATERAL
*/

$group = elgg_extract('group', $vars);
$group=get_entity($group);
$owner_group=$group->owner_guid;//propietario grupo
$user =elgg_get_logged_in_user_guid(); //usuario actual

//devuelve un ElggGroup
$page_owner = elgg_get_page_owner_entity();          


if(elgg_instanceof($page_owner, 'group')|| elgg_in_context('actividad')  ) {  
  
    elgg_register_menu_item('page', array(
        'name' => 'parent',
        'href' => '#',
        'text' => elgg_echo('Tareas'),
        'item_class' => ' elgg-menu-item-has-dropdown ',
        // controls the position relative to the trigger
        'data-position' => json_encode([
            'my' => 'right top',
            'at' => 'right bottom+5px',
        ]),
        // popup appear in a fixed position and detached from the original DOM position
        // you can add an additional class to have more control over styling
        'data-popup-class' => 'elgg-menu-entity-popup  ',
        'data-collision' => 'fit fit',
    ));

    if($owner_group==$user){
            
        
        //--------TEST----------------------------------------------------
    
       
        elgg_register_menu_item('page', array(
            'name' => 'A-menu',
            'parent_name' => 'parent',
            'text' => elgg_echo('Añadir actividad'),
            'href' => "actividad/add/{$group->guid}",  
                         
        ));
        elgg_register_menu_item('page', array(
            'name' => 'B-ver',
            'parent_name' => 'parent',
            'text' => elgg_echo('ver actividades'),
            'href' => "actividad/all/{$group->guid}",               
        ));
        elgg_register_menu_item('page', array(
            'name' => 'C-estadoActividad',
            'text' => elgg_echo('Notas'),
            'parent_name' => 'parent',
            'href' => "actividad/status/{$group->guid}",               
        ));
        // FIN TEST------------------------------------------------------------
         
    
    }else{
        elgg_register_menu_item('page', array(
            'name' => 'B-ver',
            'parent_name' => 'parent',
            'text' => elgg_echo('ver actividades'),
            'href' => "actividad/all/{$group->guid}",               
        ));
        elgg_register_menu_item('page', array(
            'name' => 'C-estadoActividad',
            'parent_name' => 'parent',
            'text' => elgg_echo('Notas'),
            'href' => "actividad/status/{$group->guid}",               
        ));      
    
    } 

    $title = elgg_get_friendly_title($group->name);  
    if(elgg_in_context('actividad')){
        elgg_register_menu_item('page', array(
            'name' => 'Z-volverCurso',
            'text' => elgg_echo('Volver al curso'),
            'href' => "groups/profile/{$group->guid}/{$title}"
                           
        ));  

    }
        
    
}







