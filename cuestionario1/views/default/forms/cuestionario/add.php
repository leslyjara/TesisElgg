<?php

$group = elgg_extract('group', $vars);
$entity = elgg_extract('guid', $vars);
$page = elgg_extract('page', $vars);

$intento                  = 1;
$calificacion_aprovatoria = number_format(4.0, 1);
$porcentaje_exigencia     = 60;
//get_entity($group);
if($entity){
    $cuestionario = get_entity($entity);
    echo elgg_view_field([
        '#type' => 'hidden',
        'name' => 'cuestionario',
        'value' => $cuestionario->guid,
    ]);
    $porcentaje_exigencia     = $cuestionario->exigencia;
    $calificacion_aprovatoria = $cuestionario->calificacion;
    $intento                  = $cuestionario->intentos;
}
//ID_Group
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' => $group,
]);
//ID_Pagina
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'page',
    'value' => $page,
]);

//General
$nombre = elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('Nombre'),
    'name' => 'nombre',
    'value' => $cuestionario->nombre,
    'required' => true,
]);

$descripcion = elgg_view_field([
    '#type' => 'longtext',
    '#label' => elgg_echo('Descripción'),
    'name' => 'descripcion',
    'value' => $cuestionario->descripcion,
]);

//funcion para fecha y minutos con dos digitos
function twoDigitos($limite){
    $arr=[];
    for($i=0; $i<$limite ; $i++) { 
        $numero= str_pad($i, 2, "0", STR_PAD_LEFT);
        array_push($arr, $numero);
    }
    return $arr;
}




//Tiempo
$inicio = elgg_view_field([
    '#type' => 'date',
    '#label' => elgg_echo('Inicio cuestionario'),
    'name' => ' inicio',
    'value' => $cuestionario->inicio,
]);
$inicio.= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Hora'),
    'name' => 'horaInicio',
    'value' => $cuestionario->horaInicio,
    'options_values' => twoDigitos(24) ,   
    
]);
$inicio.= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Minuto'),
    'name' => 'minutoInicio',
    'value' => $cuestionario->minutoInicio,
	'options_values' => twoDigitos(60),
    
]);

$numero = 1;
$numeroConCeros = str_pad($numero, 2, "0", STR_PAD_LEFT);



$termino = elgg_view_field([
    '#type' => 'date',
    '#label' => elgg_echo('Termino cuestionario'),
    'name' => ' termino',
    'value' => $cuestionario->termino,
]);
$termino.= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Hora'),
    'name' => 'horaTermino',
    'value' => $cuestionario->horaTermino,
    'options_values' => twoDigitos(24) ,   
    
]);
$termino.= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Minuto'),
    'name' => 'minutoTermino',
   'value' => $cuestionario->minutoTermino,
	'options_values' => twoDigitos(60),
    
]);
$limite = elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('Limite de tiempo'),
    'name' => ' limite',
    'value' => $cuestionario->limite,
]);


//Calificación
// $categoria = elgg_view_field([
//     '#type' => 'text',
//     '#label' => elgg_echo('Categoría'),
//     'name' => 'categoria',
//     'value' => $cuestionario->categoria,
// ]);
$calificacion = elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('Calificación aprobatoria'),
    'name' => 'calificacion',
    'step' => '0.01',
    'value' => $calificacion_aprovatoria,
]);
$exigencia = elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('Porcentaje de exigencia'),
    'name' => 'exigencia',
    'value' => $porcentaje_exigencia,
]);
$intentos = elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('Intentos permitidos'),
    'name' => 'intentos',
    'value' =>  $intento,
]);


$metodo= elgg_view_field([
    '#type' => 'select',
    '#label'=>elgg_echo('Método de calificación'),
    'name' => 'metodos',
    'options_values' =>array('masAlta'=>elgg_echo('Calificación más alta'), 'promedio'=>elgg_echo('Promedio de calificaciones'),'primerInternto'=>elgg_echo('Primer intento'),'ultimoIntento'=>elgg_echo('Último intento')),
    'value'=> $cuestionario->metodo,
    
]);


//Diseño
$nueva = elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Página nueva '),
    'name' => 'nueva',
    'options_values' => array(
        '1' => elgg_echo('Cada pregunta'),
        '3' => elgg_echo('Cada 3 preguntas'),
    ),
    'value' => $cuestionario->nueva,
]);


//Preguntas
$ordenar = elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('Ordenar al azar las respuestas '),
    'name' => 'ordenar',
    'options_values' => ([
        'si' => elgg_echo('Si'),
        'no' => elgg_echo('No'),
    ]),
    'value' => $cuestionario->ordenar,
]);



$icon = elgg_view_icon('chevron-down');
$html = <<<___HTML
            <div>
                <h1 class="h1_add" onClick="Switch('#ge')">
                    <ul>
                        <li>General</li>
                        <li class='icono'>$icon</li>
                    </ul>
                </h1>
                <div id="ge" class="tablas">
                    <table>
                        <td>
                            <tr>$nombre</tr>
                            <tr>$descripcion</tr>
                        </td>
                    </table>
                </div>
            </div>

            <div>
                <h1 class="h1_add" onClick="Switch('#ti')">
                    <ul>
                        <li>Tiempo</li>
                        <li class='icono'>$icon</li>
                    </ul>
                </h1>
                    <div id="ti" class="tablas">
                    <table>
                        <td>
                            <tr>$inicio</tr>
                            <tr>$termino</tr>
                            <tr>$limite</tr>
                        </td>
                    </table>
                </div>
            </div>

            <div>
                <h1 class="h1_add" onClick="Switch('#ca')">
                    <ul>
                        <li>Calificación</li>
                        <li class='icono'>$icon</li>
                    </ul>
                </h1>
                <div id="ca" class="tablas">
                    <table>
                        <td>
                            <tr>$categoria</tr>
                            <tr>$calificacion</tr>
                            <tr>$exigencia</tr>
                            <tr>$intentos</tr>
                            <tr>$metodo</tr>
                        </td>
                    </table>
                </div>
            </div>

            <div>
                <h1 class="h1_add" onClick="Switch('#dp')">
                    <ul>
                        <li>Diseño de presentación</li>
                        <li class='icono'>$icon</li>
                    </ul>
                </h1>
                <div id="dp" class="tablas">
                    <table>
                        <td>
                            <tr>$nueva</tr>
                        </td>
                    </table>
                </div>
            </div>

            <div>
                <h1 class="h1_add" onClick="Switch('#cp')">
                    <ul>
                        <li>Comprtamiento de las preguntas</li>
                        <li class='icono'>$icon</li>
                    </ul>
                </h1>
                <div id="cp" class="tablas">
                    <table>
                        <td>
                            <tr>$ordenar</tr>
                        </td>
                    </table>
                </div>
            </div>
___HTML;

echo $html;

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot center',
    'value' => elgg_echo('Guardar'),
));
elgg_set_form_footer($submit);



?>

<script type="text/javascript">
    function Switch($N) {
        $($N).toggle(500);
    }
</script>