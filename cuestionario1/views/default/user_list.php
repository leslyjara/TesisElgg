<?php
use DateTime;
date_default_timezone_set('America/Santiago');
$entity=elgg_extract('entity', $vars);
$cuestionario=elgg_extract('cuestionario', $vars);
$cuestionarioEntidad=get_entity($cuestionario);
$group=elgg_extract('group', $vars);
$sitio=elgg_get_site_url();
$answer = elgg_get_entities([
	'type' => 'object',
	'subtype' => 'answer',
	'relationship' => 'respuestaCuestionario',
    'relationship_guid' => $cuestionario,
    'inverse_relationship' => true,    
	'owner_guid' => $entity->guid,
]);


$icon = elgg_view_entity_icon($entity, 'small');
$time=elgg_get_friendly_time($answer[0]->time_created);
$puntaje	= $answer[0]->puntaje."/".$answer[0]->puntaje_total;
$nota		= $answer[0]->notaTotal;
$answerGuid	= $answer[0]->guid;
$intentos	= count($answer);
// $etiqueta = '<a href="'.$sitio.'cuestionario/reply/'.$group.'/'.$cuestionario.'/'.$answer[0]->guid.'" title="Cuestionario completado" class="revisar">Revisar</a>';
if(count($answer)==0){
	// $etiqueta = '<a title="Cuestionario pendiente" class="no-revisado">Revisar</a>';
	$time = ""; $puntaje = "";
}

// <li data-menu-item="entity-menu-toggle" class="elgg-menu-item-entity-menu-toggle elgg-menu-item-has-dropdown ">
// 	<a href="javascript:void(0);" class="elgg-anchor-label elgg-menu-content elgg-menu-parent elgg-non-link">
// 		<span class="elgg-icon elgg-icon-ellipsis-v elgg-anchor-icon fas fa-ellipsis-v"></span>
// 	</a>
// </li>
//-------------------------------
$arreglo=[];
$fechaI= $cuestionarioEntidad->inicio." ".$cuestionarioEntidad->horaInicio.":".$cuestionarioEntidad->minutoInicio.":00"; //fecha Inicio cuestionario
$fechaT= $cuestionarioEntidad->termino." ".$cuestionarioEntidad->horaTermino.":".$cuestionarioEntidad->minutoTermino.":00"; //fecha Iniciocuestionario
$fecha1 = new DateTime(); //fecha actual
$fecha1->format("y-m-d H:i");
$fecha2 = new DateTime($fechaI);//fecha inicio
$fecha2->format("Y-m-d H:i:s");
// $fecha3 =$fecha2->diff($fecha1)->format("%d %h:%i:%s");
$diferencia="";
$fechaTermino= new DateTime($fechaT); //fecha termino
$fechaTermino->format("Y-m-d H:i:s");

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

$arreglo+=['tiempoRestante'=> $diferencia];//timepo restante para inicio    

if($fecha1>$fecha2){
	$arreglo+=['inicio'=>'mayor'];//fecha actual es mayor que fecha de inicio
}
if( $fecha1<$fecha2){
	$arreglo+=['inicio'=>'menor'];//fecha actual es menor que fecha de inicio
}
if($fecha1>$fechaTermino){
	$arreglo+=['termino'=>'mayor'];//fecha actual es mayor que fecha de termino
}
if($fecha1<$fechaTermino){
	$arreglo+=['termino'=>'menor'];//fecha actual es menor que fecha de termino

}
//-------------------------

if(($intentos>=(int)$cuestionarioEntidad->intentos) || ($arreglo['termino']=='mayor')){
	
	$habilitar="<div  onclick='habilitar($entity->guid,$cuestionario)'><a href='#'>Habilitar</a> </div>";	
}else{
	$habilitar="<div ><a class='disabled' href='#'>Habilitar</a> </div>";

}
echo  <<<___HTML
		<div class='elgg-image-block clearfix elgg-river-item'>
			<div class='elgg-image'>
				<div class='elgg-avatar  '>
					$icon				
				</div>
			</div>
			<div class='elgg-body'>
			<div class="elgg-listing-summary-metadata">
				<nav class="elgg-menu-container elgg-menu-entity-container" data-menu-name="entity">
					<ul class='elgg-menu elgg-menu-social elgg-menu-hz elgg-menu-social-default'>
					<li class='elgg-menu-item-comment  '>Nota: $nota </li>
					<li class='elgg-menu-item-comment  '>Intentos:$intentos </li>
						$etiqueta
						<div  id='dropdown' class="dropdown "> 
							<button  class=' btnOptions'>							
								<span onclick="myFunction($entity->guid)"  class="elgg-icon elgg-icon-ellipsis-v elgg-anchor-icon fas fa-ellipsis-v dropbtn"></span>
							</button>
							<div id="myDropdown-$entity->guid" class="dropdown-content">
								$habilitar 	
								<a href="{$sitio}profile/$entity->name">Ver Perfil</a> 
							</div>
						</div>
					</ul>					
				</nav>
			</div>
				<div class='elgg-river-summary'>
				<a href="{$sitio}/profile/{$entity->name}" class="elgg-anchor">
					<span class="elgg-anchor-label">$entity->name</span>
				</a>
					<div class="elgg-listing-imprint elgg-subtext">
						</span>$time</span>
					</div>
				
				</div>
			</div>
		</div>
		
	___HTML;



