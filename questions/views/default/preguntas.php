
<?php
//muestra cada pregunta, vista dentro de un cuestionario.




$group = elgg_extract('group', $vars);
$cuestionario = elgg_extract('cuestionario', $vars);
//probando modal
$vars['group']=$group;



echo elgg_list_entities(array(
    'subtype'=>'questions',
    'type' => 'object',  
    'item_view' => 'customPregunta',
    'pagination' => true,
    'limit' => 3,
    'cont'=>1,
   // 'offset' =>0,  
    
  //  'relationship' => 'PreguntaCuestionario',
   // 'relationship_guid' => $cuestionario,
    //'inverse_relationship' => true,
   'full_view' => false,
));



// $i=1;
// foreach($preguntas as $pregunta){
//     echo $pregunta->guid;
//     $vars['entity']= $pregunta;
//     $vars['group']= $group;
//     $tipo= $pregunta->typeQuestion;
//     $texto=$pregunta->texto;
//     $form= elgg_view_form("questions/views/$tipo",array(), $vars);
//     $estado='incorrecto';
//     $retroalimentacion= "<div class='Retroalimentacion  $estado'> $pregunta->ReGeneral</div>";
//     echo <<<___HTML
//     <fieldset>
//         <legend class='RC ftoggler'>
//             <div class="cont">
//                 <h3 class='tittle' >Pregunta $i</h3> 
//                 <div>$texto ($pregunta->puntuacion punto/s)</div>           
//                 $form
//             </div>
//             $retroalimentacion
            
//         </legend>      
        
//     </fieldset>
//     <br>
//     ___HTML;

//     $i++;
// }

?>
