<?php

$guid = elgg_extract('guid', $vars);
$grupo= elgg_extract('group', $vars);

elgg_entity_gatekeeper($guid, 'object', 'file');

$file = get_entity($guid);

//contexto grupo
elgg_set_page_owner_guid((int)$file->group);

$owner = elgg_get_page_owner_entity();

elgg_group_gatekeeper();
elgg_push_breadcrumb(elgg_echo('file'), 'file/all');

$crumbs_title = $owner->name;

if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "file/group/$owner->guid/all");
}

else {
	elgg_push_breadcrumb($crumbs_title, "file/owner/$owner->username");
}


//contexto grupo
//elgg_set_page_owner_guid($owner->guid);
echo $owner->guid;

$title = $file->title;

elgg_push_breadcrumb($title);



//-------------------------------------------------
//nueva vista para archivos
$vars['entity']=$file;


$url = elgg_get_download_url($file);
$iframe_url = elgg_normalize_url("mod/actividad/providers/viewerjs-0.5.8/ViewerJS/index.html#$url");
$attr = elgg_format_attributes(array(
    'src' => $iframe_url,
    'name' => $file->title,
    'height' => 780,
    'width' => "100%",
    'seamless' => true
));
$content=" <div class='elgg-col elgg-col-1of1 clearfloat'>  <iframe $attr></iframe>  </div>";

if($file->container!='actividad'){
    $content .= elgg_view_entity($file, array('full_view' => true));
    $content .= elgg_view_comments($file);     

    
}



 
//-----------------------------------------------------

elgg_register_menu_item('title', array(
	'name' => 'download',
	'text' => elgg_echo('download'),
	'href' => elgg_get_download_url($file),
	'link_class' => 'elgg-button elgg-button-action',
));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);