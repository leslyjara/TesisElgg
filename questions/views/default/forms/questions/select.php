<?php

$group = elgg_extract('group', $vars);
$group = get_entity($group);
$site=get_entity($group->site_guid);
$cuestionario = elgg_extract('cuestionario', $vars);//guid cuestionario



echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' =>  $group->guid,
    
]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'cuestionario',
    'value' =>  $cuestionario,
    
]);

$preguntas=elgg_view_field([
    //'value' => $nombre,
    '#type' => 'radio',
  //  '#label' =>"<div> Preguntas</div>",
    'name' => 'preguntas',
    'options' => array('Verdadero/Falso'=>'VerdaderoFalso','Seleccion multiple'=>'seleccionMultiple','texto'=>'texto'),
    '#class'=>'elgg-table'
    
]);

$html=<<<___HTML
<div class="grids">
    <div class="div2">
        $preguntas
    </div>
    <div class="div3 1fr" id="descripcion">
        Seleccione una pregunta para ver su descripción.
    </div>
    
   
    

</div>
    <!-- <div> <a  href="#">  <blockquote  class="center"> </blockquote>  </a> </div> -->

___HTML;
echo $html;

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot center',
   'value' => elgg_echo('Agregar')  
));
elgg_set_form_footer($submit);
?>