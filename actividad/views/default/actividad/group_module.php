<?php

$group = elgg_get_page_owner_entity();
$owner_group=$group->owner_guid;//propietario grupo
$user =elgg_get_logged_in_user_guid();
/*
if ($group->etherpad_enable == "no") {
	return true;
}
*/
if ($group->blog_enable == "no") {
	return true;
}


$all_link = elgg_view('output/url', array(
	'href' => "actividad/all/$group->guid",
	'text' => elgg_echo('link:view:all'),
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'mi_actividad',
	'container_guid' => elgg_get_page_owner_guid(),
	'class' => 'elgg-menu-hz',
);
$content = elgg_list_entities($options);
elgg_pop_context();

if($owner_group==$user){
    $new_link = elgg_view('output/url', array(
        'href' => "actividad/add/$group->guid",
        'text' => elgg_echo('actividaes:add'),
        'is_trusted' => true,	
    ));

}



echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('actividades:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
