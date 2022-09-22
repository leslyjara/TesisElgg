<?php
elgg_gatekeeper();
$group=elgg_extract("group", $vars);
$page=elgg_extract("page", $vars);


$title="<div class='titulo'>Crear Cuestionario </div>";
$content=elgg_view_title($title);
$content.=elgg_view_form("cuestionario/add", array(), $vars);

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page("Cuestionario", $body);
