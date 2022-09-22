<?php

$group = elgg_extract('group', $vars);

//ID_Group
echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group',
    'value' => $group,
]);

$question = elgg_view_field([
    '#type' => 'submit',
    '#class' => 'elgg-foot center',
    'value' => elgg_echo('Agregar pregunta'),
]);

elgg_set_form_footer($question);