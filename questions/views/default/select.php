<?php
// vista seleccionar tipo de pregunta


$group = elgg_extract('group', $vars);
$cuestionario = elgg_extract('cuestionario', $vars);

$vars['group']=$group;
$vars['CUESTIONARIO']=$cuestionario;
echo " <p>Elija un tipo de pregunta.</p> ";
echo elgg_view_form("questions/select",array(),$vars);


?>
