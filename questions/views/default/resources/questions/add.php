<?php


elgg_gatekeeper();

$group = elgg_extract('group', $vars);
$group = get_entity($group);
$type = elgg_extract('type', $vars);
$cuestionario = elgg_extract('cuestionario', $vars);


$vars['group']=$group->guid;

$vars['cuestionario']=$cuestionario;
//si exite----
$guid= elgg_extract('guid', $vars);//si existe
if($guid){
    
   
    $question = get_entity($guid);//questions entity
  
    $type=$question->typeQuestion;
    $vars['guid']=$question->guid;
    //$form=elgg_view_form("questions/type/verdaderoFalso",array(),$vars);
    
}


if($type==='VF'){//verdadero falso
    $title="Tipo de pregunta: Verdadero falso";    
    $form=elgg_view_form("questions/type/verdaderoFalso",array(),$vars);

}
if($type==='SM'){//seleccion multiple
    $title="Tipo de pregunta: Selección multiple";
    $form=elgg_view_form("questions/type/seleccionMultiple",array(),$vars);  
}
if($type==='texto'){
    $title="Tipo de pregunta: Texto";
    $form=elgg_view_form("questions/type/texto",array(),$vars);

}


$content= "<br><br>";

$content.=$form;

//$content= $modal;


$params = array(
    'title' => $title,
    'content' => $content,
    'filter' => '',
);

$body = elgg_view_layout('constent', $params);

echo elgg_view_page("Banco de pregunta", $body);
$sitio=elgg_get_site_url();
echo <<<___HTML
    <script type='text/javascript' src='{$sitio}mod/questions/js/resources/questions/add.js'></script>
___HTML;

?>
