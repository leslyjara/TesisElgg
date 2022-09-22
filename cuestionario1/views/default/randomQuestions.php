<?php
/*vista para agregar preguntas aleatorias a cuestionario*/

$cuestionario= elgg_extract('cuestionario',$vars);
$group= elgg_extract('group',$vars);

$vars['cuestionario']=$cuestionario;
$vars['group']=$group;


$title="Preguntas aleatorias <hr>";

$form=elgg_view_form('cuestionario/randomQuestions',array(),$vars);









$view=$title;
$view.=$form;

echo $view;
