<?php

elgg_gatekeeper();
use DateTime;
date_default_timezone_set('America/Santiago');
$group = elgg_extract('group', $vars);
$guid = elgg_extract('guid', $vars);
$sitio=elgg_get_site_url();
$user=elgg_get_logged_in_user_guid();



$group = get_entity($group);
$container= $group->guid;//elgg_extract('container', $vars);
$cuestionario = get_entity($guid);
elgg_entity_gatekeeper($group->guid);


$site=get_entity($group->site_guid);
$url=$site->url;
$url.= "cuestionario/add/".$group->guid;
$vars['group']= $cuestionario->group;
$vars['cuestionario']= $cuestionario->guid;
$user=elgg_get_logged_in_user_guid();
#$form = elgg_view_form("cuestionario/view", array(), $vars);

$nombre=$cuestionario->nombre;
$descripcion=$cuestionario->descripcion;
$inicio=$cuestionario->inicio;
$termino=$cuestionario->termino;
$limite=$cuestionario->limite;


// registro de visualizacion de entidad
add_entity_relationship($user, 'visualizar', $cuestionario->guid);

$add = elgg_view("select", $vars);
$banco = elgg_view("listPreguntas", $vars);
$question = elgg_view("preguntas", $vars);
$aleatorio= elgg_view('randomQuestions', $vars);

if($user!=$cuestionario->owner){
    #COMPROBAR METODO DE EVALUACION
    $answer = elgg_get_entities([
        'type' => 'object',
        'subtype' => 'answer',
        'relationship' => 'respuestaCuestionario',
        'relationship_guid' => $cuestionario->guid,
        'inverse_relationship' => true,    
        'owner_guid' => $user,
    ]);
    $notasArray=[];
    $nota=0;
    foreach($answer as $respuesta){
        array_push($notasArray,$respuesta->nota);
    }
    if($cuestionario->metodo=="promedio"){//si metodo de evaluacion es promedio      
      
        $nota=array_sum($notasArray)/count($notasArray);
    }
    if($cuestionario->metodo=="masAlta"){//si metodo de evaluacion es la nota mas alta  
        $nota=max($notasArray);
    }
    if($cuestionario->metodo=="ultimoIntento"){//si metodo de evaluacion es el primer intento
       $nota=$answer[0]->nota;
    }
    if($cuestionario->metodo=="primerInternto"){//si metodo de evaluacion es el primer intento
       $nota= end($notasArray);
    } 
  
    $notaString="Nota: $nota";
    foreach($answer as $res){//guarda la nota total en metadato de  cada respuesta
        $res->notaTotal =$nota;
        $res->save();
    };
}

$view=<<<___HTML
        <br><br>
        <fieldset>
            <legend class='RC ftoggler'>
                <div class="cont">
                  
                    <div>  $descripcion</div>  
                    <br>         
                    Fecha de inicio: $inicio <br>
                    Fecha de Término: $termino <br>
                    Duración: $limite minutos <br>
                    Intentos permitidos: $cuestionario->intentos<br>
                    $notaString<br>
                   
                </div>
            </legend>                
        </fieldset>
    ___HTML;

$nav = <<<___HTML
    <nav id='menu'>           
        <ul>
            <li> <a><div id="verPreguntasClick" name="verPreguntasClick" class="verPreguntasClick">Ver preguntas</div></a> </li>
            <li><a><div id="verRespuestasClick" name="verRespuestasClick" class="verRespuestasClick">Ver respuestas</div></a></li>
            <li><a class='dropdown-arrow' href='#'>Agregar preguntas</a>
                <ul class='sub-menus'>
                <li><div id="btn_modal1"><a href="#ex1" rel="modal:open">Nueva pregunta</a></div></li> 
                <li><div id="btn_modal2"><a href="#ex2" rel="modal:open">Del banco de preguntas</a></div></li>
                <li><div id="btn_modal3"><a href="#ex3" rel="modal:open">Aleatorio</a></div></li>
                </ul>
            </li>                
        </ul>
    </nav> 
    <br><br>
___HTML;







$nueva_pregunta= <<<___HTML
<div class"elgg-page elgg-page-default">
    <!-- Modal HTML embedded directly into document -->
    <div name="ex1" id="modal1" class="modal1">
        <div class='modal-content'>
        <span class="close">&times;</span>
            $add
        </div>
           
    </div>
</div>
___HTML;
$banco_preguntas= <<<___HTML
<div class"elgg-page elgg-page-default">
    <!-- Modal HTML embedded directly into document -->
    <div name="ex2" id="modal2" class="modal1">
        <div class='modal-content'>
        <span class="close">&times;</span>
        <div  id='view-form'></div>       
            
        </div>
           
    </div>
</div>
___HTML;
$preguntasAleatorias= <<<___HTML
<div class"elgg-page elgg-page-default">
    <!-- Modal HTML embedded directly into document -->
    <div name="ex3" id="modal3" class="modal1">
        <div class='modal-content'>
        <span class="close">&times;</span>
        $aleatorio    
            
        </div>
           
    </div>
</div>
___HTML;


//-----------------------------------------
if($user==$group->owner_guid){
    $view.=$nav;
}else{ 
    $intentos = <<<___HTML
      
        <div class="cont-list-try  ">
            <div class="row_try borde">
                <div class="col_try">Intentos</div>
                <div class="col_try">Fecha</div>
                <div class="col_try">Puntos</div>
                <div class="col_try">Calificación</div>
                <div class="col_try">Revisión</div>
            </div>
        </div>
    ___HTML;
    $intentos .= elgg_list_entities([
        'type' => 'object',
        'subtype' => 'answer',
        'relationship' => 'respuestaCuestionario',
        'relationship_guid' =>  $cuestionario->guid,
        'inverse_relationship' => true,
        'full_view' => false,
        'owner_guid' => $user,
        'item_view' => 'list_try',
        'group' => $group->guid,
        'cuestionario' => $cuestionario->guid
    ]);
}

$respuestas= elgg_get_entities([
    'type' => 'object',
	'subtype' => 'answer',
	'relationship' => 'respuestaCuestionario',
    'relationship_guid' => $cuestionario->guid,
    'inverse_relationship' => true,    
	'owner_guid' => $user,
]);
$intentosRealizados=0;
foreach($respuestas as $respuesta){
    $intentosRealizados++;    
    // if($respuesta->owner== $user){//para cuestionarios que admiten 1 intento
    //     $res=$respuesta;
    //     $btnText="Revisar Examen";
    // }
}


if($cuestionario->intentos > $intentosRealizados|| in_array($user, $cuestionario->habilitadoPara )){    
    $comenzar= elgg_view('output/url', array(
        'text' => "Responder Examen",
        'href' => "cuestionario/reply/{$group->guid}/{$cuestionario->guid}",
        'confirm' => 'Seguro de comenzar examen?',
        '#class' => 'elgg-button',
        'is_trusted' => true,
        'is_action' => false,
    ));
}

//disponibiidad del cuestionario
if(tiempoRestante($cuestionario)['inicio']=='menor'){
    $disponibilidad="Cuestionario no disponible aun ";
}

if((tiempoRestante($cuestionario)['inicio']=='mayor'&& (tiempoRestante($cuestionario)['termino']=='menor')) ){
  
    $disponibilidad= <<<___HTML
        Cuestionario disponible
        $comenzar
    ___HTML;
  
  
}



if((tiempoRestante($cuestionario)['termino']=='mayor')){
    if(in_array($user, $cuestionario->habilitadoPara)){ 
        //$btnText="Revisar Examen";
        $disponibilidad="El cuestionario ya  no está disponible! $comenzar";
    }else{  
    ///$disponibilidad="El cuestionario ya  no está disponible ";
    }    
}


$content=elgg_view_title($nombre);

$content.= elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'group',
    'id' =>'group',
    'value'=> $group->guid,
]);
$content.= elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'container',
    'id' =>'container',
    'value'=> $container,
]);
$content.= elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'categoria',
    'id' =>'categoria',
    'value'=> $group->guid,
]);

$content.= elgg_view_field([
    '#type' => 'hidden',     
    'name' =>'cuestionario',
    'id' =>'cuestionario',
    'value'=> $cuestionario->guid,
]);


$verPreguntas=<<<___HTML
    <br><br>
    <div id="verPreguntas" name="verPreguntas" class="verPreguntas">     </div>
___HTML;
$verRespuestas=<<<___HTML
    <br><br>
    <div id="verRespuestas" name="verRespuestas" class="verRespuestas">     </div>
___HTML;

$content.= $view;
$content.= $nueva_pregunta;
$content.= $banco_preguntas;
$content.= $preguntasAleatorias;
$content.= $disponibilidad;
$content.= $verPreguntas;
$content.= $verRespuestas;
$content.= $intentos;


$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page($nombre, $body);


echo <<<___HTML
<script type='text/javascript' src='{$sitio}mod/cuestionario/js/questionRelation.js'></script>
<script type='text/javascript' src='{$sitio}mod/cuestionario/js/answerRelation.js'></script>
<script type='text/javascript' src='{$sitio}mod/cuestionario/js/all.js'></script>
  
___HTML;



function tiempoRestante($entidad){
    $arreglo=[];
    $fechaI= $entidad->inicio." ".$entidad->horaInicio.":".$entidad->minutoInicio.":00"; //fecha Inicio cuestionario
    $fechaT= $entidad->termino." ".$entidad->horaTermino.":".$entidad->minutoTermino.":00"; //fecha Iniciocuestionario
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
   

    return $arreglo;
    
    
}
?>

<script type="text/javascript">

    // Get the modal
    var modal1 = document.getElementById("modal1");
    var modal2 = document.getElementById("modal2");
    var modal3 = document.getElementById("modal3");

    // Get the button that opens the modal
    var btn1 = document.getElementById("btn_modal1");
    var btn2 = document.getElementById("btn_modal2");
    var btn3 = document.getElementById("btn_modal3");

    // Get the <span> element that closes the modal
    var span1 = document.getElementsByClassName("close")[0];
    var span2 = document.getElementsByClassName("close")[1];
    var span3 = document.getElementsByClassName("close")[2];

    // When the user clicks the button, open the modal
    btn1.onclick = function() {
        modal1.style.display = "block";
    }
    btn2.onclick = function() {
        modal2.style.display = "block";
    }
    btn3.onclick = function() {
        modal3.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span1.onclick = function() {
        modal1.style.display = "none";
    }
    span2.onclick = function() {
        modal2.style.display = "none";
    }
    span3.onclick = function() {
        modal3.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal1.style.display = "none";
            modal2.style.display = "none";
            modal3.style.display = "none";
        }
    }


    var desc={
        'pregunta':[
            { 'nombre':'Verdadero/Falso', 'descripcion': 'Pregunta de opción múltiple con solamente dos opciones: Falso o Verdadadero.' },
            { 'nombre':'Seleccion multiple', 'descripcion': 'Permite seleccionar una o varias respuestas de una lista pre-definida.' },
            { 'nombre':'texto', 'descripcion': 'Permite ingresar texto como respuesta.' },
        ]
    };


    


    $( "li" ).each(function( index ) {
    console.log( index + ": " + $( this ).text() );
    $(this).click(function(){
            //alert( index + ": " + $( this ).text());
            if($( this ).text()=='Verdadero/Falso'){
                $("#descripcion").text(desc.pregunta[0].descripcion);
            }
            if($( this ).text()=='Seleccion multiple'){
                $("#descripcion").text(desc.pregunta[1].descripcion);
            }
            if($( this ).text()=='texto'){
                $("#descripcion").text(desc.pregunta[2].descripcion);
            }
            //alert(desc.pregunta[1].nombre);
    });
    });


    $("#all").click(function() {
        if($("#all").is(":checked")){
            $('input[type="checkbox"]').prop('checked', true);
        }else{
            $('input[type="checkbox"]').prop('checked', false);
        }
    });
//-----------------------------------------------
//menu navbar
function updatemenu() {
  if (document.getElementById('responsive-menu').checked == true) {
    document.getElementById('menu').style.borderBottomRightRadius = '0';
    document.getElementById('menu').style.borderBottomLeftRadius = '0';
  }else{
    document.getElementById('menu').style.borderRadius = '3px';
  }
}


/*despliega dropdown */
function myFunction(userGuid) {
    myDropdown='myDropdown-'+userGuid;
    document.getElementById(myDropdown).classList.toggle("show");
}
/*habilita cuestionario para alumno */
function habilitar(userGuid,cuestionario){
  
    require(['elgg/Ajax'], Ajax => {
        var ajax = new Ajax();
        ajax.action('cuestionario/habilitar',{
            data:{
               userGuid:userGuid, 
               cuestionario:cuestionario,
            }
        }).done(function (output, statusText, jqXHR) {
            if (jqXHR.AjaxData.status == -1) {
                return;
                console.log("habilitado");
            } 
           
            
        });          
    }); 

}


// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

</script>
