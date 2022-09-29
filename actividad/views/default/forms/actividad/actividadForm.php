<?php
/* formulario para crear una actividad(profesor)*/



//guid del grupo
$guid = elgg_extract('group', $vars);
$entity = elgg_extract('entity', $vars);
$entity = get_entity($entity);//grupo entidad


$page = elgg_extract('page', $vars);


$existe= false;

//si existe, para editar
if($entity){
  
    $nombre= $entity->title;
    $descripcion= $entity->description;  
    $tipoEntrega=$entity->tipoEntrega;
    $conFecha= $entity->conFecha;
    $fecha=$entity->fechaTermino;
    $hora=$entity->horaTermino;
    $minuto=$entity->minutoTermino;
    $existe=true;
    $guid_Act=$entity->guid;
    $guid =$entity->guid_group;//guid del grupo
 
}

echo elgg_view_field([

    '#type' => 'hidden',
    'name' => 'guid_page',
    'value'=> $page,
    
]);

echo elgg_view_field([

    '#type' => 'hidden',
    'name' => 'guid_group',
    'value'=> $guid,
    
]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'existe',
    'value'=> $existe,
    
]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'guid_Act',
    'value'=> $guid_Act,
    
]);

echo elgg_view_field([
    'value' => $nombre,
    '#type' => 'text',
    '#label' => elgg_echo('actividad:name'),
    'name' => 'nombre',
    'required' => true,   
]);

echo elgg_view_field([
    '#type' => 'file',
    'name' => 'upload',
    '#label' => elgg_echo('actividad:uploadFile'),        
]);


echo elgg_view_field([
    '#type' => 'longtext',
    '#label' => elgg_echo('actividad:description'),
    'name' => 'descripcion',
    'required' => false,
    'value' => $descripcion,
]);




$tipo_label= elgg_echo('actividad:type');
$tipo_input = elgg_view_field([
    '#type' => 'select',
    'name' => 'tipoEntrega',
    'value'=> $tipoEntrega,
    'options_values' => array('archivo' => elgg_echo('actividad:file'), 'video' => elgg_echo('actividad:video'), 'texto'=> elgg_echo('actividad:text')),     
	
]);

$fecha_label= elgg_echo('actividad:date');
$fecha_input = elgg_view_field([
    '#type' => 'select',
    'name' => 'conFecha',
    'id' => 'conFecha',
    'options_values' => array('on' => elgg_echo('actividad:on'), 'off' => elgg_echo('actividad:off')),     
	'value'=> $conFecha,
]);


echo <<<___HTML
<div>
	<label >$tipo_label</label>
	$tipo_input
</div>

<div>
	<label >$fecha_label</label>
	$fecha_input
</div>


___HTML;






$date= elgg_view_field([
    '#type' => 'date',
    '#label' => elgg_echo('actividad:endDate'),
    'name' => 'fecha', 
    'id' => 'fecha', 
    'required' => false,
    'value'=> $fecha,
]);

$hora= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('actividad:hour'),
    'name' => 'hora',
    'id' => 'hora',
    'value' => $hora,
    'options_values' => array(                
		'01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
		'08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',  
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
		'20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '00' => '00',       
	),   
    
]);

$min= array(  
    '00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08',  '09' => '09',
    '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18',  '19' => '19',
    '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28',  '29' => '29',  
    '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38',  '39' => '39', 
    '40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48',  '49' => '49', 
    '50' => '50', '51' => '51', '52' => '52', '53' => '53', '54' => '54', '55' => '55', '56' => '56', '57' => '57', '58' => '58',  '59' => '59', 

);


$minuto= elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('actividad:minute'),
    'name' => 'minuto',
    'id' => 'minuto',
    'value' => $minuto,
	'options_values' => $min// range(0,59),  
    
]);





echo <<<___HTML
    <div>
    $date
    </div>

    <div>
        <table>
        <tr>
            <td><strong>{$hora}  </strong></td>
            <td><strong> : </strong></td>
            <td><strong> {$minuto} </strong></td>
        
        </tr>
        </table>
    </div>


___HTML;

//

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot',
    'value' => elgg_echo('actividad:save')  ));




elgg_set_form_footer($submit);




