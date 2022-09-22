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

$cuestionario = elgg_extract('cuestionario', $vars);
$cuestionario= get_entity($cuestionario);

$guid = elgg_extract('guid', $vars);//guid questions
if($guid){//editar
    $question = get_entity($guid);
    $categoria= $question->categoria;
    $nombre= $question->title;
    $texto= $question->texto;
    $puntuacion= $question->puntuacion;
    $ReGeneral= $question->ReGeneral;
    $barajar= $question->barajar;
    $opcion1= $question->opcion1;
    $calificacion1= $question->calificacion1;
    $retroalimentacion1= $question->retroalimentacion1;
    $opcion2= $question->opcion2;
    $calificacion2= $question->calificacion2;
    $retroalimentacion2= $question->retroalimentacion2;
    $opcion3= $question->opcion3;
    $calificacion3= $question->calificacion3;
    $retroalimentacion3= $question->retroalimentacion3;
    $opcion4= $question->opcion4;
    $calificacion4= $question->calificacion4;
    $retroalimentacion4= $question->retroalimentacion4;
    $opcion5= $question->opcion5;
    $calificacion5= $question->calificacion5;
    $retroalimentacion5= $question->retroalimentacion5;
    $RespuestaCorrecta= $question->RespuestaCorrecta;
    $RespuestaParcialCorrecta= $question->RespuestaParcialCorrecta;
    $RespuestaIncorrecta= $question->RespuestaIncorrecta;

  
    //$group= get_entity($question->container_guid);
   
    
}else{
    $RespuestaCorrecta="Su respuesta es correcta";
    $RespuestaParcialCorrecta="Su respuesta es parcialmente correcta";
    $RespuestaIncorrecta="Su respuesta es incorrecta";
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


//--------------------



echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'categoria',
    'value'=>$cuestionario,  
]);

$categoria= elgg_view_field([
    '#type' => 'select',
    //'#label'=>elgg_echo('Categoría'),
    'name' => 'categoria',
    'options_values' => $arr,//array(),   
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

 if($question->barajar!='on'){
    $checked=false;
}
else{
    $checked=true;
} 

$barajar= elgg_view_field([
    '#type' => 'checkbox',
    'name' => 'barajar',
    'checked' => $checked,
   // 'value'=> $question->barajar,
  
    //'required'=> 'true',   
]);


echo <<<___HTML
<!-- GENERAL-->
    <fieldset>
        <legend class='general ftoggler'>
            <h3 class='titleF' >General</h3> <div class='right'>$icon</div>
        </legend>
        <!--  ------------------------------------------------- -->
        <div class='optionGeneral'>       
           
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
            <div class="labelContainer">
                Barajar opciones
            </div>
            <div class="inputContainer">
                $barajar      
            </div>    
            <!--  ------------------------------------------------- -->     
            

        </div>

    </fieldset>    
    <br> 
___HTML;



//--FIN GENERAL-----
//---PREGUNTAS...........
$Opcion1=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'opcion1',
    'value'=> $opcion1, 
]);
$calificacion1=elgg_view_field([// peso de cada respuesta
    '#type' => 'number',
    'name' => 'calificacion1',
    'step'=>"0.0001",
    'value'=> $calificacion1, 
]);
$retroalimentacion1=elgg_view_field([// peso de cada respuesta
    '#type' => 'longtext',
    'name' => 'retroalimentacion1',
    'value'=> $retroalimentacion1, 
]);
$Opcion2=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'opcion2',
    'value'=> $opcion2, 
]);
$calificacion2=elgg_view_field([// peso de cada respuesta
    '#type' => 'number',
    'step'=>"0.0001",
    'name' => 'calificacion2',
    'value'=> $calificacion2, 
]);
$retroalimentacion2=elgg_view_field([// peso de cada respuesta
    '#type' => 'longtext',
    'name' => 'retroalimentacion2',
    'value'=> $retroalimentacion2, 
]);
$Opcion3=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'opcion3',
    'value'=> $opcion3, 
]);
$calificacion3=elgg_view_field([// peso de cada respuesta
    '#type' => 'number',
    'step'=>"0.0001",
    'name' => 'calificacion3',
    'value'=> $calificacion3, 
]);
$retroalimentacion3=elgg_view_field([// peso de cada respuesta
    '#type' => 'longtext',
    
    'name' => 'retroalimentacion3',
    'value'=> $retroalimentacion3,
]);
$Opcion4=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'opcion4',
    'value'=> $opcion4, 
]);
$calificacion4=elgg_view_field([// peso de cada respuesta
    '#type' => 'number',
    'step'=>"0.0001",
    'name' => 'calificacion4',
    'value'=> $calificacion4, 
]);
$retroalimentacion4=elgg_view_field([// peso de cada respuesta
    '#type' => 'longtext',
    'name' => 'retroalimentacion4',
    'value'=> $retroalimentacion4, 
]);
$Opcion5=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'opcion5',
    'value'=> $opcion5, 
]);
$calificacion5=elgg_view_field([// peso de cada respuesta
    '#type' => 'number',
    'step'=>"0.0001",
    'name' => 'calificacion5',
    'value'=> $calificacion5, 
]);

$retroalimentacion5=elgg_view_field([// peso de cada respuesta
    '#type' => 'longtext',
    'name' => 'retroalimentacion5',
    'value'=> $retroalimentacion5, 
]);



echo <<<___HTML
<!-- PREGUNTAS-->
    <fieldset>
        <legend class='questions ftoggler'>
            <h3 class='titleF' >Preguntas</h3> <div class='right'>$icon</div>
        </legend>
        <!--  ------------------------------------------------- -->
        <div class='optionQuestions'>
        
            <div class="sectionContent">
                <div class="labelContainer">
                    Opción 1
                </div>
                <div class="inputContainer">
                    $Opcion1      
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Calificación
                </div>
                <div class="inputContainer">
                    $calificacion1     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Retroalimentación
                </div>
                <div class="inputContainer">
                    $retroalimentacion1     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Opción 2
                </div>
                <div class="inputContainer">
                    $Opcion2     
                </div>
            </div>
                <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Calificación
                </div>
                <div class="inputContainer">
                    $calificacion2    
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Retroalimentación
                </div>
                <div class="inputContainer">
                    $retroalimentacion2     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Opción 3
                </div>
                <div class="inputContainer">
                    $Opcion3     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Calificación
                </div>
                <div class="inputContainer">
                    $calificacion3   
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Retroalimentación
                </div>
                <div class="inputContainer">
                    $retroalimentacion3    
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Opción 4
                </div>
                <div class="inputContainer">
                    $Opcion4     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Calificación
                </div>
                <div class="inputContainer">
                    $calificacion4   
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Retroalimentación
                </div>
                <div class="inputContainer">
                    $retroalimentacion4     
                </div>
            </div>
            <!--  ------------------------------------------------- -->    
        
            <div class="sectionContent">
                <div class="labelContainer">
                    Opción 5
                </div>
                <div class="inputContainer">
                    $Opcion5     
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Calificación
                </div>
                <div class="inputContainer">
                    $calificacion5   
                </div>
            </div>
            <!--  ------------------------------------------------- -->
            <div class="sectionContent">
                <div class="labelContainer">
                    Retroalimentación
                </div>
                <div class="inputContainer">
                    $retroalimentacion5     
                </div>
            </div>
            <!--  ------------------------------------------------- -->    
        </div>

    </fieldset>
    <br>

    
___HTML;
//FIN PREGUNTAS

//RETROALIMENTACION COMBINADA
$RespuestaCorrecta=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'RespuestaCorrecta',
    'value'=> $RespuestaCorrecta, 
]);
$RespuestaParcialCorrecta=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'RespuestaParcialCorrecta',
    'value'=> $RespuestaParcialCorrecta, 
]);
$RespuestaIncorrecta=elgg_view_field([
    '#type' => 'longtext',  
    'name' => 'RespuestaIncorrecta',
    'value'=> $RespuestaIncorrecta, 
]);

echo <<<___HTML
<!-- GENERAL-->
    <fieldset>
        <legend class='RC ftoggler'>
            <h3 class='titleF' >Retroalimentación combinada</h3> <div class='right'>$icon</div>
        </legend>
        <!--  ------------------------------------------------- -->
        <div class='optionRC'>       
           
            <div class="labelContainer">
                Para cualquier respuesta correcta
            </div>
            <div class="inputContainer">
                $RespuestaCorrecta      
            </div>    
            <!--  ------------------------------------------------- -->    
            <div class="labelContainer">
             Para cualquier respuesta parcialmente correcta
            </div>
            <div class="inputContainer">
                $RespuestaParcialCorrecta      
            </div>    
            <!--  ------------------------------------------------- -->      
            <div class="labelContainer">
                Para cualquier respuesta incorrecta
            </div>
            <div class="inputContainer">
                $RespuestaIncorrecta      
            </div>    
            <!--  ------------------------------------------------- -->  
        </div>

    </fieldset>    
    <br> 
___HTML;


//FIN RETROALIMENTACION COMBINADA


$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'center ',
    'value' => elgg_echo('Guardar') 
 ));


elgg_set_form_footer($submit); 