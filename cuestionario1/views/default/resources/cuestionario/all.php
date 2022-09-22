<?php
elgg_gatekeeper();
$group = elgg_extract('group', $vars);
$group = get_entity($group);
$guid = elgg_extract('guid', $vars);
$user=elgg_get_logged_in_user_guid();


elgg_group_gatekeeper(true, $grupo);

if($group->owner_guid==$user){
    $agregar="<a class='boton_agregar' href='../add/{$group->guid}'><button>+</button></a>";
}

$entity=elgg_extract("entity", $vars);

$title="Cuestionarios $agregar";
$content=elgg_view_title($title);
#$content.= "<a href='../add/$group'><button>+</button></a>";
$content.= elgg_list_entities_from_relationship(array(
    'type'=>'object',
    'subtype'=>'cuestionario',
    'relationship' => 'CuestionarioGrupo',
    'relationship_guid' => $group->guid ,
    'inverse_relationship' => true,
    'full_view' => false,
));


$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar,
));

echo elgg_view_page("Cuestionarios", $body);

