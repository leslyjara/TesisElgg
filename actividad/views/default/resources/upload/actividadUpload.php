<style>
   .panel1{
      border : 1px solid rgb(206,94,2);
      border-radius: 10px;

      padding-top: 20px;
      padding-right: 20px;
      padding-bottom: 20px;
      padding-left: 20px;
      /* border-collapse: collapse;
      border:  1px red;
      border-radius: 10px;
      overflow: hidden;  */

   }
   table {
      
 
    
   }
   th, td {      
   
      Height :30px;
   }
</style>
<?php
/*
ARCHIVO QUE MUMESTRA FORMULARIO PARA SUBIR ACTIVIDAD
*/
// asegurarse que le usuario inicio sesion
use DateTime;
//elgg_require_js('../js/upload');
gatekeeper();
elgg_group_gatekeeper();
date_default_timezone_set('America/Santiago');





$guid = elgg_extract('guid', $vars);//guid actividad
$mi_actividad = get_entity($guid);//entidad mi_actividad
$user=elgg_get_logged_in_user_guid();



//contexto grupo
elgg_set_page_owner_guid((int)$mi_actividad->guid_group);

// registro de visualizacion de entidad
add_entity_relationship($user, 'visualizar', $mi_actividad->guid);

//recurso de actividad
$recurso= elgg_list_entities_from_relationship([
   'type' => 'object',
   'subtype'=>'file', 
   'relationship' =>'recurso',// tipo de relacion
   'relationship_guid' => $mi_actividad->guid, 
   'full_view' => false,
   
]);






$mi_actividad_guid_group= $mi_actividad->guid_group;//guid del grupo al que pertenece la actividad
elgg_group_gatekeeper(true, $mi_actividad_guid_group);//acceso solo miembros del grupo

$title = $mi_actividad->title;
$content = elgg_view_title($title);

$content.= $recurso;
$content.= $mi_actividad->description;





//obteneido entidad Respuesta Entidad completa
$options = array('type'=>'object','subtype'=>'respuesta');//respuesta Entidad
$entities= elgg_get_entities($options);
foreach($entities as $entity){
   if($entity->owner_guid==elgg_get_logged_in_user_guid() && $entity->actividad==$mi_actividad->guid){
     // $content.=$entity->respuesta;
      $respuesta= get_entity($entity->guid); 
      
   }
}
$res=$respuesta->respuesta;


if($mi_actividad->tipoEntrega== 'archivo'){
   

  if($respuesta){
   $guidFile= $respuesta->respuesta;
   $file=get_entity($guidFile); 
   if($file) {
      $res = elgg_view_entity($file, array('full_view' => false));
   } else{$res="";}
  }
   
  
   
}
$labelRespuestas = elgg_echo('actividad:answers');
$labelFechaTermino = elgg_echo('actividad:endDate');
$labelUltimaModificacion = elgg_echo('actividad:LastModification');
$labelTarea = elgg_echo('actividad:task');
$labelNota = elgg_echo('actividad:grade');
$labelComentario = elgg_echo('actividad:comment');
$labelEditarTarea= elgg_echo('actividad:editTask');
//profesor
if($mi_actividad->owner==elgg_get_logged_in_user_guid()){

   $tiempo= tiempoRestante($mi_actividad);
   $fechaE= $mi_actividad->fechaTermino.'   '.$mi_actividad->horaTermino.':'.$mi_actividad->minutoTermino.' hrs -';
  
   if($entity->conFecha == 'on'){
      $info= "<table>
      <tr >
         <td>$labelFechaTermino </td>
         <td> $fechaE   $tiempo</td>
       </tr>
      </table>";

   }else{
      $info = "<br>".elgg_echo('actividad:SinFecha');
     
   }
  

   $content.= $info;
  
   $content.=" <br> <br><br> <br><hr>  <h3>". $labelRespuestas." :</h3>";
   if($mi_actividad->tipoEntrega !='archivo'){   
      
   }
   //respuestas de los alumnos
   $list=elgg_list_entities_from_relationship([
      'type' => 'object',
      'subtype'=>'respuesta', 
      'relationship' =>'respuesta',// tipo de relacion
      'relationship_guid' => $mi_actividad->guid, 
      'full_view' => false,
      'no_results' => elgg_echo('actividad:noAnswersYet'),     
   ]);
   $content.= $list;    
  
   


}else{

     // $content.=$entities;//recurs de actividad
      if($respuesta){
         $estado=elgg_echo('actividad:Submitted');
         $modificacion= elgg_get_friendly_time($respuesta->time_created);
      }     

     
      $resource_vars['guid'] = $mi_actividad->guid;   

      
      if($mi_actividad->conFecha=="off"){         
         $fechaE=elgg_echo('actividad:noEndDate');
         $tiempo=" ";
      }else{
         $tiempo= tiempoRestante($mi_actividad);
         $fechaE= $mi_actividad->fechaTermino.'   '.$mi_actividad->horaTermino.':'.$mi_actividad->minutoTermino.' hrs';

      }     
     
      if(tiempoRestante($mi_actividad)!= false){  
       

        // $tiempo= tiempoRestante($mi_actividad);
         if($mi_actividad->tipoEntrega =='archivo'){      
            $form_vars = array('enctype' => 'multipart/form-data');
            $form= elgg_view_form("upload/actividadUpload",$form_vars,$resource_vars);        
                       

         }elseif($mi_actividad->tipoEntrega =='texto'){
            $resource_vars['texto'] = $respuesta->respuesta;
           // $form= elgg_view_form("upload/actividadTexto",$resource_vars);
            $form= elgg_view_form("upload/actividadTexto",array(),$resource_vars);

         }elseif($mi_actividad->tipoEntrega =='video'){  
            $resource_vars['texto'] = $respuesta->respuesta;          
            $form= elgg_view_form("upload/actividadVideo",array(),$resource_vars);            
         }
        
      }else{
         $frase= "No se admiten mas entregas";
      }
      

   
      
      $labelEstado= elgg_echo('actividad:state');
      
         $html= " <br/> <br/>
            <div class='panel1'>         
                 <table  WIDTH='100%' >
                  <tr >           
                     <td  BORDER WIDTH='20%' >{$labelEstado}</td>
                     <td>{$estado}  </td>
                  </tr>  
                  
            

                  <tr>
                     <td>{$labelFechaTermino}</td>
                     <td>{$fechaE} {$tiempo}</td>
                  </tr>
                  <tr >
                     <td  >{$labelUltimaModificacion }</td>
                     <td>{$modificacion}</td>
                  </tr>
               
                  <tr >
                     <td>{$labelTarea} </td>
                     <td> {$res}</td>
                  </tr>


                  <tr >           
                     <td  BORDER WIDTH='20%' >$labelNota</td>
                     <td> {$respuesta->nota} </td>
                  </tr>

                  <tr  >           
                     <td  BORDER WIDTH='20%' >$labelComentario</td>
                     <td> {$respuesta->comentario} </td>
                  </tr>
                  
               </tr  >
                  <tr>
                  <td COLSPAN=2> <div id='form' >{$form}</div></td>
                  </tr>
               </table> 
            </div>
            <br/><br/><br/>
            <div align='center' id='boton'>
                <button type='button' id='mostrarForm' class='elgg-button elgg-button-submit' >$labelEditarTarea</button>
            </div>
           
      
            
                 
            
            
      ";

      $content.=$html;
      $content.= $frase;
      

}

;
// opciones barra lateral
$sidebar= elgg_view('sidebar/options', array(
   'group' => $mi_actividad_guid_group,
      
));


// layout the page
$body = elgg_view_layout('one_sidebar', array(
   'content' => $content,
   'sidebar' => $sidebar
));



echo elgg_view_page($title, $body);


function dias_restantes($fecha_final){  
   $fecha_actual = date("Y-m-d");  
   $s = strtotime($fecha_final)-strtotime($fecha_actual);  
   $d = intval($s/86400);  
   $diferencia = $d;     
   return $diferencia;  //dias restantes
}

function tiempoRestante($actividad){
   $fecha= $actividad->fechaTermino." ".$actividad->horaTermino.":".$actividad->minutoTermino.":00";
   $fecha1 = new DateTime();
   $fecha1->format("y-m-d H:i");//fecha actual
   $fecha2 = new DateTime($fecha);//fecha entrega
   $fecha2->format("Y-m-d H:i:s");
   $fecha3 =$fecha2->diff($fecha1)->format("%d %h:%i:%s");
   $diferencia="";
   //echo "Diferencia de horas: ".$fecha3;//.PHP_EOL;
   //echo  $fecha2->diff($fecha1)->format("%d %H:%i:%s");
   if($fecha2->diff($fecha1)->format("%m")!=0){
      $diferencia= $fecha2->diff($fecha1)->format("%m mes(es) restante");
   }elseif($fecha2->diff($fecha1)->format("%d")!=0){
      $diferencia= $fecha2->diff($fecha1)->format("%d dia(s) restante");
   }elseif($fecha2->diff($fecha1)->format("%h")!=0){
      $diferencia= $fecha2->diff($fecha1)->format("%h hora(s) restante");
   }elseif($fecha2->diff($fecha1)->format("%i")!=0) {
      $diferencia= $fecha2->diff($fecha1)->format("%i minuto(s) restante");
   }elseif($fecha2->diff($fecha1)->format("%s")!=0) {
      $diferencia= $fecha2->diff($fecha1)->format("%s segundos restante");
   }

   if($actividad->conFecha=='off'){
      return true;
   }else{
      if( $fecha1>$fecha2){
         return false;
      }else return $diferencia;

   }

   
}


?>
<script type="text/javascript">  
 
  $(document).ready(function(){   
      
      $("#form").hide();
      $("#mostrarForm").click(function(){
         //mostrar formulario de entrega
         $("#form").show();
         $("#mostrarForm").hide();
       
      });         
     
           
   });
</script>