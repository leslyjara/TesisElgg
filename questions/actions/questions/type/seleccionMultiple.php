<?php


$group=get_input('group');
$guid=get_input('guid');
$cuestionario=get_input('cuestionario');
$categoria=get_input('categoria');
$nombre=get_input('nombre');
$texto=get_input('texto');
$puntuacion=get_input('puntuacion');
$ReGeneral=get_input('ReGeneral');
$barajar= get_input('barajar');
$opcion1=get_input("opcion1");
$calificacion1=get_input("calificacion1");
$retroalimentacion1=get_input("retroalimentacion1");
$opcion2=get_input("opcion2");
$calificacion2=get_input("calificacion2");
$retroalimentacion2=get_input("retroalimentacion2");
$opcion3=get_input("opcion3");
$calificacion3=get_input("calificacion3");
$retroalimentacion3=get_input("retroalimentacion3");
$opcion4=get_input("opcion4");
$calificacion4=get_input("calificacion4");
$retroalimentacion4=get_input("retroalimentacion4");
$opcion5=get_input("opcion5");
$calificacion5=get_input("calificacion5");
$retroalimentacion5=get_input("retroalimentacion5");
$respuestaCorrecta=get_input('RespuestaCorrecta');
$RespuestaParcialCorrecta=get_input('RespuestaParcialCorrecta');
$RespuestaIncorrecta=get_input('RespuestaIncorrecta');

if($guid){
    $pregunta= get_entity($guid);
    $group= $group;//$pregunta->container_guid;

}else{      
$pregunta = new ElggObject();
$pregunta->subtype= 'questions';
$pregunta->typeQuestion= 'SM';
$pregunta->typeString= 'Seleccion multiple';
$pregunta->container_guid=$categoria;
$pregunta->owner= elgg_get_logged_in_user_guid();


}
$pregunta->container_guid=$categoria;
$pregunta->categoria=$categoria;
$pregunta->title=$nombre;
$pregunta->texto=$texto;
$pregunta->puntuacion=$puntuacion;
$pregunta->ReGeneral=$ReGeneral;
$pregunta->barajar=$barajar;
$pregunta->opcion1=$opcion1;
$pregunta->calificacion1=$calificacion1;
$pregunta->retroalimentacion1=$retroalimentacion1;
$pregunta->opcion2=$opcion2;
$pregunta->calificacion2=$calificacion2;
$pregunta->retroalimentacion2=$retroalimentacion2;
$pregunta->opcion3=$opcion3;
$pregunta->calificacion3=$calificacion3;
$pregunta->retroalimentacion3=$retroalimentacion3;
$pregunta->opcion4=$opcion4;
$pregunta->calificacion4=$calificacion4;
$pregunta->retroalimentacion4=$retroalimentacion4;
$pregunta->opcion5=$opcion5;
$pregunta->calificacion5=$calificacion5;
$pregunta->retroalimentacion5=$retroalimentacion5;
$pregunta->RespuestaCorrecta=$respuestaCorrecta;
$pregunta->RespuestaParcialCorrecta=$RespuestaParcialCorrecta;
$pregunta->RespuestaIncorrecta=$RespuestaIncorrecta ;
$pregunta->access_id=2 ;


$pregunta_guid =$pregunta->save();
if(!$guid){
    add_entity_relationship($pregunta->guid, 'preguntaCategoria',(int)$categoria);//sistema, grupo, cuestionario
}

if ($pregunta_guid) {
    system_message("Guardado");
    //retornar a cuestionario
    $c= get_entity($categoria);
    if($c){
        if($c->getSubtype()=='cuestionario'){
            return elgg_redirect_response("cuestionario/view/$group/$categoria");
        } 
    }
  
  
    return elgg_redirect_response("questions/all/$group");
   // forward($pregunta->getURL());
       
       
 } else {
       register_error("Error al guardar");
       forward(REFERER); // REFERER es una variable global que define la página anterior
 }

