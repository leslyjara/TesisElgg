<?php


$user = elgg_get_logged_in_user_entity();
$user = get_entity($user);
$entity = $vars['item']->getObjectEntity();
$subject = $vars['item']->getSubjectEntity();

$item = elgg_extract('item', $vars);
$group = $entity->guid_group;
$group = get_entity($group);




$file_icon = elgg_view_entity_icon($subject, 'small');



$owner=get_entity($entity->owner);

$subtitle =elgg_echo('actividad:river:body',[
    $owner->name,
    $entity->title,
    $group->name

]); 
$params = array(
    'entity' => $entity,
    'content' =>$subtitle,
    'icon' => $file_icon,
    'handler' => 'mi_actividad',
    
);
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);





