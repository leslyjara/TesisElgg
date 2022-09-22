<?php
/* ACTION: EXPORTAR NOTAS A XML*/

// get the form inputs
$group_guid = get_input('group_guid');//guid de grupo
//$matriz = get_input('dat');//gud de grupo


$group=get_entity($group_guid); 




//alumnos del curso (Entidad)
$member= elgg_get_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->$guid,
	'inverse_relationship' => true,
	'limit' => 0,
));//$content= $member[2]->name;

//actividades del curso
//$optionsActividades =  array('type'=>'object','subtype'=>'mi_actividad','relationship' =>'pertenece','relationship_guid' => $group_guid,);//actividad
//$actividades= elgg_get_entities_from_relationship($optionsActividades);
$actividades= elgg_get_entities_from_relationship(array(
	'type' => 'object',
    'subtype'=>'mi_actividad',
	'relationship' => 'pertenece',
	'relationship_guid' => $group->$guid,
	'inverse_relationship' => true,
	'limit' => 0,
));

$matriz=array();
$columna=array();
/*
array_push($columna,'Nombre');
foreach($actividades as $i){
    array_push($columna,$i->title);
    
}
array_push($matriz,$columna);

*/

//--- CREAR XML
$xml = new DomDocument('1.0', 'UTF-8');
//escritura de archivo Notas XML
//$file = new ElggFile();
//function exportarUOS($group,$actividades,$member,$xml){

//nodo raiz
$activ = $xml->createElement('actividades');
$activ = $xml->appendChild($activ);
$curso = $xml->createElement('curso',$group->name);
$curso = $activ->appendChild($curso);


foreach($actividades as $act){
    $guidA=$act->guid;
    //$act->title
    //sub nodos
    $evaluacion = $xml->createElement('actividad');
    $evaluacion = $activ->appendChild($evaluacion);

    $nombreAct = $xml->createElement('NombreActividad',$act->title );
    $nombreAct = $evaluacion->appendChild($nombreAct);


    //system_message($act->subtype); 

             
    foreach($member as $m){

        $name=$m->name;
        $owner_group= get_entity($group->owner_guid); //propietario grupo
            
        $nota=" ";
        if($name != $owner_group->name){

                //subnodo
                $alumno = $xml->createElement('alumno');
                $alumno = $evaluacion->appendChild($alumno);
                //subnodo
                $nombre = $xml->createElement('nombre',$m->name);
                $nombre = $alumno->appendChild($nombre);

                $optionsRespuesta =  array('type'=>'object','subtype'=>'respuesta','relationship' =>'respuesta','relationship_guid' => $guidA,);//respuesta actividad
                $respuesta= elgg_get_entities_from_relationship($optionsRespuesta);
                foreach($respuesta as $r){
                    $owner=get_entity($r->owner_guid);
                    
                    if($owner->name ==$name){
                        $nota=$r->nota;   
                    } 

                }
                $Nnota = $xml->createElement('nota',$nota);
                $Nnota = $alumno->appendChild($Nnota);
        }
        
    }
    
}


//crear archivo
$nombreArchivo=$group->name."Notas.xml";
$xml->formatOutput = true;
$xml->saveXML();
$xml->save($nombreArchivo);//$xml->save('archivoXML.xml');

//}


//cargo archivo creado
$doc = new DOMDocument();
$doc->load($group->name."Notas.xml");
echo $doc->saveXML();



//crear entidad file con XML
$file = new ElggFile();
$nombreArchivo=$group->name.'Notas.xml';
$file->owner_guid = elgg_get_logged_in_user_guid();
$file->subtype = 'file';
$file->setFilename($nombreArchivo);
$file->open('write');

$file->write($doc->saveXML());

$file->close();
$archivo=$file->save(); 


//crear relacion
add_entity_relationship($group_guid, 'notasCurso',$file->guid);
add_entity_relationship($file->guid, 'notasCurso', $group_guid);



//descargararchivo de notas
$f = get_entity($file->guid);
if (!elgg_instanceof($f, 'object', 'file')) {
    register_error(elgg_echo("file:downloadfailed"));
    forward();
}
forward(elgg_get_download_url($f));

