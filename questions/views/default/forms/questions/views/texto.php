<?php
//formulario parcial para responder a preguntas-- texto

$entity = elgg_extract('entity', $vars);
$entity= get_entity($entity);

echo elgg_view_field([
  //'value' => $nombre,
  '#type' => 'hidden',
  'name' => "{$entity->guid}",
  'value'=> $entity->guid,
]);


$name='pregunta'. $entity->guid;
echo <<<___HTML

<div class="inputContainer">
<br>
    <textarea id="w3review" name=$name rows="4" cols="50">
   
    </textarea>
    </div>
___HTML;