<?php

$sitio=elgg_get_site_url();
$pregunta=$vars['entity'];
$cont=$vars['cont'];
$cont= $cont+1;
echo $cont;

$tipo= $pregunta->typeQuestion;
$texto=$pregunta->texto;

$form= elgg_view_form("questions/views/$tipo",array(), $vars);
$estado='correcto';
$retroalimentacion= "<div class='Retroalimentacion  $estado'> $pregunta->ReGeneral</div>";
echo <<<___HTML
<fieldset>
    <legend class='RC ftoggler'>
        <div class="cont">
            <h3 class='tittle' >Preguntasz $i</h3> 
            <div>$texto ($pregunta->puntuacion punto/s)</div>           
            $form
        </div>
        $retroalimentacion
        
    </legend>      
    
</fieldset>
<br>
___HTML;