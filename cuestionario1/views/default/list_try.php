<?php
$answer=elgg_extract('entity', $vars);
$cuestionario=elgg_extract('cuestionario', $vars);
$user=elgg_get_logged_in_user_guid();
$group=elgg_extract('group', $vars);
$sitio=elgg_get_site_url();
$time = elgg_get_friendly_time($answer->time_created);
$intentos = elgg_get_entities([
    'type' => 'object',
    'subtype' => 'answer',
    'relationship' => 'respuestaCuestionario',
    'relationship_guid' =>  $cuestionario,
    'inverse_relationship' => true,
    'full_view' => false,
    'order_by' => 'e.time_created asc',
    'owner_guid' => $user,
]);
$index=0;
foreach($intentos as $intento){
    $index++;
    if($intento->guid == $answer->guid){
        break;
    }
}

echo  <<<___HTML
<div class="row_try">
    <div class="col_try">$index</div>
    <div class="col_try">$time</div>
    <div class="col_try">$answer->puntaje/$answer->puntaje_total</div>
    <div class="col_try">$answer->nota</div>
    <div class="col_try"><a href="{$sitio}cuestionario/reply/$group/$cuestionario/$answer->guid">Revisión</a></div>
</div>
___HTML;
