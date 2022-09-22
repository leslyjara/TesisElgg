<style type="text/css">

.table{
width:100%;
border-collapse: collapse;
vertical-align: middle;  




}

.row{
    height: 50px;   
    border:  1px #D5D8DC ;
    border-bottom-style: solid;  
    margin: auto;
    padding: 50px;
}



</style>

<?php



// get the entity
$group = elgg_extract('group', $vars);
$group = get_entity($group);
$site=get_entity($group->site_guid);
$container= $group->guid;//elgg_extract('container', $vars);
$cuestionario= elgg_extract('cuestionario', $vars);


$vars['group']=$group->guid;

$content.= elgg_view_field([
'#type' => 'hidden',     
'name' =>'group',
'id' =>'group',
'value'=> $group->guid,
]);
$content.= elgg_view_field([
'#type' => 'hidden',     
'name' =>'container',
'id' =>'container',
'value'=> $container,
]);
$content.= elgg_view_field([
'#type' => 'hidden',     
'name' =>'cuestionario',
'id' =>'cuestionario',
'value'=> $cuestionario,
]);

//LISTAR PREGUNTAS, formulatio
//$delete= elgg_view_form("questions/deleteQ",array(),$vars);
$content.="<div  id='view-form'> </div>";

$content.=$delete;
$vars['group']= $group->guid;

echo $content;
$sitio=elgg_get_site_url();

echo <<<___HTML
    <script type='text/javascript' src='{$sitio}mod/questions/js/resources/questions/all.js'></script>
___HTML;
?>






