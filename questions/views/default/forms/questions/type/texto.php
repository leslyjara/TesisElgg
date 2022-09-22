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

.titleF{
    float: left;
    width: 75%;
    text-align: left;
    box-sizing: border-box;
    padding: 14px;
    margin: auto;
   

}
.right{
    float: right;
    width: 25%;    
    text-align: right;
    box-sizing: border-box;
    padding: 14px;
    margin: auto;

}
.ftoggler{
    width: 100%;
    border: 1px solid #D6DAE4;
    border-radius:5px;   
    box-shadow: 2px 3px 5px #EEF0F3;
    
    
  
}


</style>

<?php
$icon=elgg_view_icon('angle-up');


$group = elgg_extract('group', $vars);
$group = get_entity($group);
$cuestionario= elgg_extract('cuestionario',$vars);
$cuestionario= get_entity($cuestionario);



$guid = elgg_extract('guid', $vars);//guid questions

if($guid){//editar

    $question = get_entity($guid);
    $categoria= $question->categoria;
    $nombre= $question->title;
    $texto= $question->texto;
    $puntuacion= $question->puntuacion;
    $ReGeneral= $question->ReGeneral;
 
   // $group= get_entity($question->container_guid);
}
else{ 
  
}


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

if($categoria){
    $c= get_entity($categoria);
    if($c->getSubtype()=='cuestionario'){
        $cuestionario=$c;       
        $arr+=[$cuestionario->guid=>elgg_echo($cuestionario->title)];   
        
    }

}
//--------------------

$categoria= elgg_view_field([
    '#type' => 'select',
    //'#label'=>elgg_echo('Categoría'),
    'name' => 'categoria',
    'options_values' =>$arr,// array($group->guid => elgg_echo('En '). $group->name , $site->guid => elgg_echo('En sistema'),$cuestionario->guid=>elgg_echo($cuestionario->title)),   
    'value'=>$group->guid ,
    
	//'value'=> $conFecha,   
]);
$nombrePregunta= elgg_view_field([
    '#type' => 'text',
   // '#label'=>elgg_echo('Nombre de la pregunta'),
    'name' => 'nombre',
    'required'=> 'true', 
    'value'  =>$nombre,
]);
$textoPregunta= elgg_view_field([
    '#type' => 'longtext',
  //  '#label'=>elgg_echo('Texto de la pregunta'),
    'name' => 'texto',
    'required'=> 'true', 
    'value'  =>$texto,
]);
$puntuacion= elgg_view_field([
    '#type' => 'number',
   // '#label'=>elgg_echo('Puntuación'),
    'name' => 'puntuacion',
    'value'=> $puntuacion,
    //'required'=> 'true',   
]);
$ReGeneral= elgg_view_field([
    '#type' => 'longtext',
    //'#label'=>elgg_echo('Retroalimentación General'),
    'name' => 'ReGeneral',
    'value'=> $ReGeneral,
    //'required'=> 'true',   
]);



echo <<<___HTML
<!-- GENERAL-->
    <fieldset>
       
        <!--  ------------------------------------------------- -->
        <div class=''>       
           
            <div class="labelContainer">
                Categoria
            </div>
            <div class="inputContainer">
                $categoria      
            </div>    
            <!--  ------------------------------------------------- -->    
            <div class="labelContainer">
                Nombre de la pregunta
            </div>
            <div class="inputContainer">
                $nombrePregunta      
            </div>    
            <!--  ------------------------------------------------- -->      
            <div class="labelContainer">
                Texto de la pregunta
            </div>
            <div class="inputContainer">
                $textoPregunta      
            </div>    
            <!--  ------------------------------------------------- -->  
            <div class="labelContainer">
                Puntuación
            </div>
            <div class="inputContainer">
                $puntuacion      
            </div>    
            <!--  ------------------------------------------------- -->      
            <div class="labelContainer">
                Retroalimentación general
            </div>
            <div class="inputContainer">
                $ReGeneral      
            </div>    
            <!--  ------------------------------------------------- -->                       
               

        </div>

    </fieldset>    
    <br> 
___HTML;



//--FIN GENERAL-----

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'center ',
    'value' => elgg_echo('Guardar') 
 ));

elgg_set_form_footer($submit); 



?>