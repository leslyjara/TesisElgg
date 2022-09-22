
<?php
//formulario parcial para responder a preguntas--- seleccion multiple

$entity = elgg_extract('entity', $vars);//entidad
$entity= get_entity($entity);


echo elgg_view_field([
    //'value' => $nombre,
    '#type' => 'hidden',
    'name' => 'guid_'. $entity->guid,
    'value'=> $entity->guid,
    
]);
$len=5;
$list=[];
//guardar en arreglo
for($i =1; $i <= $len; $i++){
    $op= "opcion". $i;
    $cali="calificacion". $i; 
    $retroal="retroalimentacion".$i;
    if($entity->$op){
       // echo $op. "-". $cali. "-". $retroal. "-----------";
        array_push($list,array( 
            'opcion'=> $op,
            'calificacion'=> $cali,
            'retroalimentacion'=>$retroal,
        ));
    }  

}
//barajar opciones
if($entity->barajar=='on'){
    shuffle($list);
}



foreach($list as $index){
    $op= $index['opcion'];
    $cali= $index['calificacion'];

    echo elgg_view_field([       
        '#type' => 'checkbox',
        '#label'=> $entity->$op,
        //'name' => $op. "_". $entity->guid,
        'name' => "{$entity->guid}",
        'value'=>  $op
    ]);
}




echo <<<___HTML


___HTML;
