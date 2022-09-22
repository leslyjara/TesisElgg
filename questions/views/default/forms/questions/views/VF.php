
<?php
//formulario parcial para responder a preguntas-- verdadero falso

$entity = elgg_extract('entity', $vars);
$entity= get_entity($entity);


echo elgg_view_field([
  //'value' => $nombre,
  '#type' => 'hidden',
  'name' => 'guid_'. $entity->guid,
  'value'=> $entity->guid,
]);
$preguntas=elgg_view_field([
  '#type' => 'radio',
  'name' => "{$entity->guid}",
  'options' => array('Verdadero'=>elgg_echo('Verdadero'),'Falso '=>elgg_echo('Falso')),
  
]);


echo <<<___HTML

<div class="inputContainer">
<br>
$preguntas
</div>
___HTML;