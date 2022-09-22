<?php
/*agrega preguntas a cuestionario, desde categorias y subcategorias */

use function DI\get;

$cuestionario= get_input('cuestionario');
$cuestionario= get_entity($cuestionario);
$group=get_input('group');

$aleatorio=get_input('aleatorio');
$numeroPreguntas= get_input('numeroPreguntas');

$cuestionario->aleatorioAlumno=$aleatorio;
$cuestionario->numeroPreguntas=$numeroPreguntas;
$cuestionario->save();

system_message('Guardado');

// $preguntasCuestionario=elgg_get_entities([ //preguntas de categoria seleccionada
//     'type' => 'object',
//     'subtype'=>'questions',
//     'relationship' => 'preguntaCategoria',
//     'relationship_guid' => $cuestionario->guid,
//     'inverse_relationship' => true,  
// ]);
// $IDs=[];
// $orden=[];//arreglo con id's aleatorios
// foreach($preguntasCuestionario as $pregunta){
//     array_Push($IDs,$pregunta->guid);
// }

// function random_questions($arr,$ordenQ,$n){
//     $length= count($arr);
//     $numero=rand(0,$length-1);
//     array_Push($ordenQ,$arr[$numero]);
//     array_splice($arr,1,$numero);
//     if(count($ordenQ)>=$n){ 
//         system_message("retorno ".$ordenQ[1]) ;
//         return $ordenQ;
//     }else{
//         return random_questions($arr,$ordenQ,$n);

//     }

// }

// $list=random_questions($IDs,$orden,$numeroPreguntas);



// foreach($list as $l){
//     system_message($l. " gg");
// }

