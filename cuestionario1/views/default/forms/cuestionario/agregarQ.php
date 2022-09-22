
<?php


$group= elgg_extract('group', $vars);
$group = get_entity($group);
$container= elgg_extract('container', $vars);
$cuestionario= elgg_extract('cuestionario', $vars);
$categoria=(int)elgg_extract('categoria', $vars);
$sitio=elgg_get_site_url();
$siteGuid=get_entity($group->site_guid);

if($cuestionario){
    $cuestionario=get_entity($cuestionario);
        
   
}

//container, group y cuestionarion se envian por ajax
echo elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'container',
    'id'=>'container',
    'value'=>$container,
]);
echo elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'categoria',
    'id'=>'categoria',
    'value'=>$categoria,  
]);
echo elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'cuestionario',
    'id'=>'cuestionario',
    'value'=>$cuestionario->guid,
]);
echo elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'group',
    'id'=>'group',
    'value'=>$group->guid,
]);

$cuestionariosGrupo=elgg_get_entities([
    'type' => 'object',
    'subtype'=>'cuestionario',
	'relationship' => 'CuestionarioGrupo',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
  
]);


$arr=[1=> elgg_echo('En sistema'),$group->guid => elgg_echo('En '). $group->name];
foreach($cuestionariosGrupo as $cuest){
    $arr[$cuest->guid]= "&nbsp;&nbsp;&nbsp;&nbsp;". $cuest->title;
} 


echo elgg_view_field([
    '#type' => 'select',     
    'name' =>'setContainer',
    'id' =>'setContainer',
    'options_values' => $arr,//array($group->guid => elgg_echo('En '). $group->name,'all'=>elgg_echo('Todas')),
    'value'=> $categoria,
]);






//----------------------
$checkAll= elgg_view_field([
    '#type' => 'checkbox',     
    'name' =>"all",
    'id'=>'all',

]);

$p= elgg_get_entities(array(
    'type' => 'object',
    'subtype'=>'questions',
	'relationship' => 'preguntaCategoria',
	'relationship_guid' => (int)$categoria,
	'inverse_relationship' => true,
     'no_results' => elgg_echo('Sin resultados.'), 
));


// if($container=='all'){  
//     $p= elgg_get_entities(array(
//         'subtype'=>'questions',
//         'type' => 'object',
//         'full_view'=>false,
//     ));
// }

$type=elgg_view_icon('list');
$edit=elgg_view_icon('edit');
$delete=elgg_view_icon('delete');
$item='';//Metadatos de preguta

foreach($p as $pregunta){
  
    $check= elgg_view_field([
        '#type' => 'checkbox',     
        'name' =>"{$pregunta->guid}entity",
        'value'=>$pregunta->guid,
    ]);
 

   
    $type="<img src='$sitio/mod/questions/images/$pregunta->typeQuestion.png' title='$pregunta->typeString ' >";
    $getGuid= elgg_view_field([
        '#type' => 'hidden',     
        'name' =>'group',
        'id'=>'group',
        'value'=>$group->guid,
    ]);

    $editarLink= $sitio."questions/edit/". $pregunta->guid."/".$group->guid;

 
    $menu= elgg()->menus->getMenu('entity',array('entity' => $pregunta,'handler'=>'questions'));
    $sections = $menu->getSections();  
       
     //obtener menu dlete
    foreach($sections as $items) {       
        $i=0;
        foreach($items as $itemsss) {       
            if ($i >0) break;   
            $i++;  
            $delete= elgg_view_menu_item($itemsss);
        }     
    }
  
   // $it= elgg_view_menu_item('delete',);

    $owner=get_entity($pregunta->owner);
    $asd=get_entity($pregunta->container_guid);
    $time=elgg_get_friendly_time( $pregunta->time_updated);
    $item.=<<<___HTML
        <tr class="row center"> 
   
            <td >$check $getGuid </td>
            <td >$type </td>
            <td >$pregunta->title </td>
            <td >$owner->name</td>          
            <td >$time</td>
            <td > <a href="$editarLink" title="editar" class="elgg-menu-content">$edit</a>   </td> 
        </tr>   
    ___HTML;

}
//fila
$list= <<<___HTML
<br><br>
<table class=" table-questions">
    <tr class="row ">   
        <th>$checkAll</td>
        <th >tipo</td>
        <th >Pregunta</td>
        <th >Creado por</td>             
        <th >última modificación</td>
        <th >Editar</td>   

    </tr>  
    $item   
</table>
<br><br><br><br>

___HTML;

if(count($p)==0){
    echo elgg_echo("Sin preguntas para mostrar");
}else{
    echo $list;

    echo elgg_view_field(array(
        '#type' => 'submit',
        '#class' => ' center ',
        'id' => 'agregar',
        'name' => 'agregar',
        'value' => elgg_echo('Agregar')
    ));
}
echo <<<___HTML
 <script type='text/javascript' src='{$sitio}mod/cuestionario/js/forms/agregarQ.js'></script>
___HTML;

