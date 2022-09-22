<?php
/* HABILITA CUESTIONARIO PARA ALGUN ALUMNO EN ESPECIFICO*/
$user=get_input('userGuid');
$cuestionario=get_input('cuestionario');
$cuestionario=get_entity($cuestionario);

if(gettype( $cuestionario->habilitadoPara)=='array'){     
  
    $arr=$cuestionario->habilitadoPara;
    array_push($arr,$user);
    $cuestionario->habilitadoPara= $arr;
}

if(gettype( $cuestionario->habilitadoPara)=='string'|| gettype( $cuestionario->habilitadoPara)=='NULL'){
    
    $arr=["init"];
    array_push($arr,$user);
    $cuestionario->habilitadoPara= $arr;
    

}
$cuestionario->save();
system_message('habilitado');


