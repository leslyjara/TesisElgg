<?php

$usuario = elgg_get_logged_in_user_guid();
$group = get_input('group');
$page = get_input('page');
$nombre = get_input('nombre');
$descripcion = get_input('descripcion');
$inicio = get_input('inicio');
$horaInicio= get_input('horaInicio');
$minutoInicio= get_input('minutoInicio');
$termino = get_input('termino');
$horaTermino=get_input('horaTermino');
$minutoTermino=get_input('minutoTermino');
$limite = get_input('limite');
$categoria = get_input('categoria');
$calificacion = get_input('calificacion');
$intentos = get_input('intentos');
$metodo = get_input('metodos');
$exigencia = get_input('exigencia');
$nueva = get_input('nueva');
$ordenar = get_input('ordenar');
$editar=0;
$entity = get_input("cuestionario");
if($entity){
    $cuestionario = get_entity($entity);
 
}else {
   
    $cuestionario = new ElggObject();
    $cuestionario->subtype = 'cuestionario';
    $cuestionario->habilitadoPara = array(["init"]);
    $cuestionario->group = $group;
    $cuestionario->container_guid =$page;
    $cuestionario->owner = $usuario;

    //ACCESO
    $access = $group ;    
    $entity =get_entity($access);
    $cuestionario->access_id = $entity->access_id;  
    $editar = 1;
}

$cuestionario->nombre           = $nombre;
$cuestionario->title            = $nombre;
$cuestionario->descripcion      = $descripcion;
$cuestionario->inicio           = $inicio;
$cuestionario->horaInicio       = $horaInicio;
$cuestionario->minutoInicio     = $minutoInicio;
$cuestionario->termino          = $termino;
$cuestionario->horaTermino      = $horaTermino;
$cuestionario->minutoTermino    = $minutoTermino;
$cuestionario->limite           = $limite;
$cuestionario->categoria        = $categoria;
$cuestionario->calificacion     = $calificacion;
$cuestionario->intentos         = $intentos;
$cuestionario->metodo           = $metodo;
$cuestionario->exigencia        = $exigencia;
$cuestionario->nueva            = $nueva;
$cuestionario->ordenar          = $ordenar;
$cuestionario->aleatorioAlumno  = null;//si las preguntas son aleatorias para cada usuario
$cuestionario->numeroPreguntas  = false;//cantidad de preguntas aleatorias

$variable = $cuestionario->save();

if($editar==1){add_entity_relationship($cuestionario->guid, 'CuestionarioGrupo',$group);}


if ($variable) {
    system_message("Guardado");
    // elgg_clear_sticky_form('mi_actividad');
    forward($cuestionario->getURL());
           
}else {
       register_error("La actividad no pudo ser creada.");
       forward(REFERER); // REFERER es una variable global que define la página anterior
}