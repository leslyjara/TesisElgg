<?php

/*
MUESTRA ESTADO DE ACTIVIDADES PARA EXPORTAR
*/
// asegurarse que el usuario inicio sesion
gatekeeper();

$titlebar = "actividad";
$pagetitle = "evaluaciones";


$guid = elgg_extract('group', $vars);//guid de grupo

$group=get_entity($guid);//grupo entidad
//acceso solo para miembros del grupo
elgg_group_gatekeeper(true, $guid);

//elgg_push_context('groups');

$Guid_user=elgg_get_logged_in_user_guid();
$user= get_entity($Guid_user);

$lista= elgg_list_entities_from_relationship([ //actividades que pertenecen al curso
    'type' => 'object',
    'subtype'=>'mi_actividad', 
    'relationship' =>'pertenece',// tipo de relacion
    'relationship_guid' => $group->guid, 
    'full_view' => false,
    'no_results' => elgg_echo('no hay cursos por mostrar.'),     
    
]);
$cont="";
//------------------------------------------
//alumnos del curso (Entidad)
$memberAux= elgg_get_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->$guid,
	'inverse_relationship' => true,
	'limit' => 0,
));//$content= $member[2]->name;
$member=array();
$owner_group= get_entity($group->owner_guid); //propietario grupo 

if($owner_group->guid!=$user->guid){
    for ($i =0; $i <count($memberAux); $i++) {     
        if($memberAux[$i]->name== $user->name ){
            array_push($member,$memberAux[$i]);
                    
        }          
    }
}else{ $member=$memberAux;}

//actividades del curso
$optionsActividades =  array('type'=>'object','subtype'=>'mi_actividad','relationship' =>'pertenece','relationship_guid' => $group->guid,);//actividad
$actividades= elgg_get_entities_from_relationship($optionsActividades);



//-------------------------------

$matriz=array();
$columna=array();

array_push($columna,'Nombre');
foreach($actividades as $i){
    array_push($columna,$i->title);
    
}
array_push($matriz,$columna);



//--- CREAR MATRIZ CON NOTAS
for ($i =0; $i < count($member); $i++) {
    $name=$member[$i]->name;  //nomre alumno
   
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
            $owner=get_entity($res->owner_guid);//propietario de respuesta
                      
           
            if($owner->name ==$name ){
               $nota=$res->nota;   
            }  
        }
        if($name!= $owner_group->name){
            array_push($columna,$nota);
        }
        
        // array_push($columna,$nota);

    }
    array_push($matriz,$columna);
    $columna="";


    }
    
     

}

//--------------------------------------------
//bOTONES EXPORTAR 
$resource_vars['group'] = $group->guid;
$resource_vars['dat'] = $matriz;//matriz con evaluaciones y notas
$btnUOS=elgg_view_form("export/uos",array(),$resource_vars); //boton de exportacion a formato .uos
$btnXML=elgg_view_form("export/XML",array(),$resource_vars); //boton de exportacion a formato XML

$btns=<<<___HTML
    <div>
   
    </div>

    <div align="right">
        <table>
        <tr>
           <td>  Exportar a :  </td>
            <td><strong>{$btnUOS}  </strong></td>
          
            <td><strong> {$btnXML} </strong></td>
        
        </tr>
        </table>
    </div>


___HTML;


$content = $btns;





//--TABLA HTML CON NOTAS

$html= "<table  style=' 
border: 2px solid grey;
  padding: 10px;
  border-radius: 50px;
' WIDTH='100%' >";   

for ($i =0; $i < count($matriz); $i++){
    if($i==0){
        $html.= "<TR  BGCOLOR='#5499C7 ' > ";
    }else{    
    $html.= "<TR> ";}
   
    for ($j =0; $j < count($matriz[$i]); $j++){
        $celda= $matriz[$i][$j];
        if($j==0){
            $html.=  "<TH BGCOLOR='#5499C7 '  style=' 
            border: 2px solid grey;
              padding: 10px;
             
            '   > <strong>{$celda}</strong></TH>";
        }
        else{$html.=  "<td style=' 
            border: 2px solid grey;
              padding: 10px;
             
            ' >{$celda}</td>"; }
    }
    $html.= " </TR> ";
}

$html.=   "</table> ";
//-------------------------------------------------------
        
$content.= $html;



$sidebar =elgg_view('sidebar/options', array(
    'group' => $guid,
       
));

// layout the page
$body = elgg_view_layout('one_sidebar', array(
    'title'=> "{$group->name}: Actividades",
   'content' => $content,
   'sidebar' => $sidebar,
));

echo elgg_view_page($titlebar, $body);

