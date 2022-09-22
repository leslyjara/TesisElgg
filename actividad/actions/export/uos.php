<?php
/* ACTION: EXPORTAR NOTAS A HOJA DE CALCULO*/

// get the form inputs
$group_guid = get_input('group_guid');//gud de grupo
//$matriz = get_input('dat');//matriz con actividades y notas


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
$optionsActividades =  array('type'=>'object','subtype'=>'mi_actividad','relationship' =>'pertenece','relationship_guid' => $group->guid,);//actividad
$actividades= elgg_get_entities_from_relationship($optionsActividades);

$matriz=array();
$columna=array();

array_push($columna,'Nombre');
foreach($actividades as $i){
    array_push($columna,$i->title);
    
}
array_push($matriz,$columna);



//--- CREAR MATRIX CON NOTAS
for ($i =0; $i < count($member); $i++) {
    $name=$member[$i]->name;   
    $owner_group= get_entity($group->owner_guid); //propietario grupo          
    
   // $columna=array();
   // array_push($columna,$name);
  
   if($name != $owner_group->name){
       $columna=array();
       array_push($columna,$name);


        foreach($actividades as $act){
            $guidA=$act->guid;  
            
            $nota="--";
            //respuestas de cada actividad
            $optionsRespuesta =  array('type'=>'object','subtype'=>'respuesta','relationship' =>'respuesta','relationship_guid' => $guidA,);//respuesta actividad
            $respuesta= elgg_get_entities_from_relationship($optionsRespuesta);

            foreach($respuesta as $res){ 
                $owner=get_entity($res->owner_guid);
                //echo($owner->name);
                //echo($owner->name);
                if($owner->name ==$name){
                $nota=$res->nota;   
                }  
            }
        // array_push($columna,$nota);
            if($name!= $owner_group->name){
                array_push($columna,$nota);
            }

        }
        array_push($matriz,$columna);
        $columna=""; 

    }

}



//_-----------------------------
//escritura de archivo hoja de calculo
$file = new ElggFile();
function exportarUOS($group,$matriz,$file){
    $nombreArchivo=$group->name.'Notas.uos';
   
    $file->subtype = 'file';
    
    $file->owner_guid =  elgg_get_logged_in_user_guid();
    $file->setFilename($nombreArchivo);
    $file->open('write');

    for ($i=0; $i < count($matriz); $i++){
        for ($j=0; $j < count($matriz[$i]); $j++){
            $file->write($matriz[$i][$j]);
            $file->write(";");
        }
        $file->write("\n");    
    }
    $file->close();
    
    $archivo=$file->save(); 
   
}
exportarUOS($group,$matriz,$file);


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

