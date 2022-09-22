
<style type="text/css">
* {
  box-sizing: border-box;
}

.header {
  border: 1px solid blue;
  padding: 15px;
}

.labelContainer {
  width: 25%;
  float: left;
  padding: 15px;
  /* border: 1px solid red; */
  text-align: right;
}

.inputContainer {
  width: 75%;
  float: left;
  padding: 15px;
  /* border: 1px solid red; */
  text-align: left;
}
form input[type="submit"]{
	width:25%;
	padding:15px 16px;
	margin-top:32px;
    border: 1px solid #D6DAE4;
	border-radius:5px;	
	color:#fff;
	background-color:#566573;
}
select{
	width:50%;
	padding:7px 16px;	
	border:1px solid #000;
	border-radius:5px;
    border: 1px solid #D6DAE4;
	
}

</style>

<?php

$group = elgg_extract('group', $vars);
$group = get_entity($group);

$cuestionario = elgg_extract('cuestionario', $vars);
$cuestionario= get_entity($cuestionario);


$guid = elgg_extract('guid', $vars);//guid questions
if($guid){

    $question = get_entity($guid);
    $categoria= $question->categoria;
    $nombre= $question->title;
    $texto= $question->texto;
    $puntuacion= $question->puntuacion;
    $ReGeneral= $question->ReGeneral;
    $respuestaCorrecta= $question->respuestaCorrecta;
    $ReRespuestaVerdadero= $question->ReRespuestaVerdadero;
    $ReRespuestaFalso= $question->ReRespuestaFalso;
   // $group= $group;//get_entity($question->container_guid);
    
}else{


}

//echo $categoria;
$site=get_entity($group->site_guid);


echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'guid',//si existe
    'value' =>  $question->guid,
    
]);
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' =>  $group->guid,
    
]);

//----------- GENERAL--------------------------
$arr=[1=> elgg_echo('En sistema'),$group->guid => elgg_echo('En '). $group->name];

$cuestionariosGrupo=elgg_get_entities([
    'type' => 'object',
    'subtype'=>'cuestionario',
	'relationship' => 'CuestionarioGrupo',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
  
]);

if($cuestionario){   
    $arr+=[$cuestionario->guid=>elgg_echo($cuestionario->title)];
    $categoria=$cuestionario->guid;
}else{
    foreach($cuestionariosGrupo as $cuest){
        $arr[$cuest->guid]= "&nbsp;&nbsp;&nbsp;&nbsp;". $cuest->title;
    }  
  
}


$categoria= elgg_view_field([
    '#type' => 'select',
    'name' => 'categoria',
    'options_values' => $arr,
    'value'=>$cuestionario->guid ,
     
]);

echo <<<___HTML


<div class="labelContainer">
 Categoría
</div>

<div class="inputContainer">
$categoria
</div>
___HTML;
//---------------
$nombrePregunta= elgg_view_field([
    '#type' => 'text',
   // '#label'=>elgg_echo('Nombre de la pregunta'),
    'name' => 'nombre',
    'required'=> 'true', 
    'value'  =>$nombre,
]);
echo <<<___HTML
    <div class="labelContainer ">
        Nombre de la pregunta
    </div>
    <div class="inputContainer">
        $nombrePregunta
    </div>
___HTML;
// ----------------------
$textoPregunta= elgg_view_field([
    '#type' => 'longtext',
  //  '#label'=>elgg_echo('Texto de la pregunta'),
    'name' => 'texto',
    'required'=> 'true', 
    'value'  =>$texto,
]);
echo <<<___HTML
    <div class="labelContainer">
        Texto de la pregunta
    </div>
    <div class="inputContainer">
        $textoPregunta
    </div>
___HTML;
//-----------------------

$puntuacion= elgg_view_field([
    '#type' => 'number',
   // '#label'=>elgg_echo('Puntuación'),
    'name' => 'puntuacion',
    'value'=> $puntuacion,
    //'required'=> 'true',   
]);
echo <<<___HTML
    <div class="labelContainer">
        Puntuación
    </div>
    <div class="inputContainer">
        $puntuacion
    </div>
___HTML;

//----------------------------------
$ReGeneral= elgg_view_field([
    '#type' => 'longtext',
    //'#label'=>elgg_echo('Retroalimentación General'),
    'name' => 'ReGeneral',
    'value'=> $ReGeneral,
    //'required'=> 'true',   
]);
echo <<<___HTML
    <div class="labelContainer">
        Retroalimentación general
    </div>
    <div class="inputContainer">
        $ReGeneral
    </div>
___HTML;
//--------------------
$respuestaCorrecta=elgg_view_field([
    '#type' => 'select',
   // '#label'=>elgg_echo('Respuesta Correcta'),
    'name' => 'respuestaCorrecta',
    'options_values' => array('Falso' => elgg_echo('Falso ') , 'Verdadero'=> elgg_echo('Verdadero')),     
	'value'=> $respuestaCorrecta,   
]);
echo <<<___HTML
    <div class="labelContainer">
        Respuesta Correcta
    </div>
    <div class="inputContainer">
        $respuestaCorrecta
    </div>
___HTML;
//------------------
$ReRespuestaVerdadero= elgg_view_field([
    '#type' => 'longtext',
    //'#label'=>elgg_echo("Retroalimentación para la respuesta 'Verdadero'"),
    'name' => 'ReRespuestaVerdadero',
    'value'=> $ReRespuestaVerdadero,
    //'required'=> 'true',   
]);
echo <<<___HTML
    <div class="labelContainer">
        Retroalimentación para la respuesta 'Verdadero'
    </div>
    <div class="inputContainer">
        $ReRespuestaVerdadero
    </div>
___HTML;
//-------------------------------------------
$ReRespuestaFalso= elgg_view_field([
    '#type' => 'longtext',
    //'#label'=>elgg_echo("retroalimentación para la respuesta 'Falso'"),
    'name' => 'ReRespuestaFalso',
    'value'=> $ReRespuestaFalso,
    //'required'=> 'true',   
]);
echo <<<___HTML
    <div class="labelContainer">
        Retroalimentación para la respuesta 'Falso'
    </div>
    <div class="inputContainer">
        $ReRespuestaFalso
    </div>
___HTML;


$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'center ',
    'value' => elgg_echo('Guardar') 
 ));


elgg_set_form_footer($submit);  