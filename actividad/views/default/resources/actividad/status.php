<?php
//elgg_set_context('groups');

//elgg_push_context('groups');
/*
MUESTRA ESTADO DE ACTIVIDADES PARA EXPORTAR
*/
// asegurarse que el usuario inicio sesion
gatekeeper();
//$group = elgg_get_page_owner_entity();
$page_owner = elgg_get_page_owner_entity();

$title = "Notas";
$pagetitle = "evaluaciones";

$guid = elgg_extract('group', $vars);//guid de grupo
$group=get_entity($guid);//grupo entidad
//acceso solo para miembros del grupo
elgg_group_gatekeeper(true, $guid);

//contexto grupo
elgg_set_page_owner_guid($group->guid);


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
	'relationship_guid' => $group->guid,
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
$btnUOS=elgg_view_form("export/uos",array(),$resource_vars,$vars); //boton de exportacion a formato .uos
$btnXML=elgg_view_form("export/XML",array(),$resource_vars,$vars); //boton de exportacion a formato XML

$btns=<<<___HTML
    <div>
   
    </div>

    <div align="right" class="">
        <table>
        <tr>
           <td>  Exportar a:  </td>
           <td>   </td>          
            <td> {$btnUOS}  </td>
            <td> &nbsp  </td>
          
            <td>{$btnXML}</td>
        
        </tr>
        </table>
    </div>


___HTML;
$content = elgg_view_title($title);

$content .= $btns . "<br><br><br>";





//--TABLA HTML CON NOTAS
/* border: 2px solid grey;
  padding: 10px;
  border-radius: 50px;
' WIDTH='100%'  */

//elgg-table td elgg-table th elgg-table-alt th 

$html= "<table  class='elgg-table elgg-table-alt '>";   

for ($i =0; $i < count($matriz); $i++){
    if($i==0){
        $html.= "<TR class='elgg-table td'> ";
    }else{    
    $html.= "<TR class='elgg-table td'> ";}
   
    for ($j =0; $j < count($matriz[$i]); $j++){
        $celda= $matriz[$i][$j];
        if($j==0){
            $html.=  "<Td 


               > <strong>{$celda}</strong></Td>";
        }
        else{$html.=  "<td >{$celda}</td>"; }
    }
    $html.= " </TR> ";
}

$html.=   "</table> ";
//-------------------------------------------------------
        
$content.= $html;



$sidebar =elgg_view('sidebar/options', array(
    'group' => $guid,
       
));


$body = elgg_view_layout('one_sidebar', array(
    //'title'=> "{$group->name}: Notas del curso",
   'content' => $content,
   'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

?>