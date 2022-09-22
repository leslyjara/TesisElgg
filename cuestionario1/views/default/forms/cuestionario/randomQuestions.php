<?php
/* formularion para añadir preguntas aleatorias a un cuestionario*/


$cuestionario= elgg_extract('cuestionario',$vars);
$cuestionario= get_entity($cuestionario);
$group= elgg_extract('group',$vars);
$group=get_entity($group);
$question_icon=elgg_view_icon('question');

//--HIDDEN
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'cuestionario',
    'value' => $cuestionario->guid,
]);
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' => $group->guid,
]);
if($cuestionario->aleatorioAlumno=='on'){
    $checked=true;
}else{$checked=false;}
$aleatorio=elgg_view_field([//slecciona si las preguntas son aleatorias para cada alumno
    '#type' => 'checkbox',
    'name' => 'aleatorio',
    'checked'=>$checked,
   // 'value' =>$cuestionario->aleatorioAlumno, 
]);

echo <<<___HTML
    <div class="labelContainer">
        <s title='Seleccione si desea que las preguntas tengan un comportamiento aleatorio para cada usuario'>$question_icon</s>
        Aleatorio 
    </div>
    <div class="inputContainer">
        $aleatorio
        <br>
        
    </div>
___HTML;




$numeroPreguntas=elgg_view_field([
    '#type' => 'number',
    'name' => 'numeroPreguntas',
    'value' => $cuestionario->numeroPreguntas,    
]);
echo <<<___HTML
    <div class="labelContainer">
        <s title='Seleccione la cantidad de preguntas que debe tener el cuestionario'>$question_icon</s>
        Número de preguntas aleatorias para cada alumno
    </div>
    <div class="inputContainer">
        $numeroPreguntas
        <br>
        
    </div>
___HTML;

echo elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'center ',
    'value' => elgg_echo('Guardar') 
));


elgg_set_form_footer($submit);  